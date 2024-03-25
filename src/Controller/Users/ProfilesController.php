<?php
declare(strict_types=1);

namespace App\Controller\Users;

use App\Controller\AppController;
use App\Controller\ShopsController;
use App\Model\Entity\Order;
use App\Model\Table\OrdersTable;
use Cake\Database\Query;
use Cake\I18n\FrozenDate;

/**
 * Profiles Controller
 *
 * @method \App\Model\Entity\Profile[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ProfilesController extends AppController
{

    public function initialize(): void
    {
        parent::initialize();
        $this->viewBuilder()->setLayout('shop');

        $this->Users = $this->fetchTable('Users');
        $this->Orders = $this->fetchTable('Orders');
    }
    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index()
    {
        // $profiles = $this->paginate($this->Profiles);
        $profile = $this->Users->find()->where(['id' => $this->Authentication->user->id])->first();
        // 決済済の注文
        $query = $this->Orders->find()
            ->where(['user_id' => $this->Authentication->user->id, 'status IN' => [OrdersTable::DELIVERED, OrdersTable::PAID]]);
        $query = $query->select(['count' => $query->func()->count('id'), 'amount' => $query->func()->sum('order_amount')])
            ->firstOrFail();
        $order_count = 0;
        $paid = 0;
        $unpaid = 0;
        if(!empty($query)) {
            $order_count = $query->count;
            $paid = $query->amount ? number_format($query->amount) : 0;
        }
        $query = $this->Orders->find()
            ->where(['user_id' => $this->Authentication->user->id, 'status NOT IN' => [OrdersTable::DELIVERED, OrdersTable::PAID]]);
        $query = $query->select(['count' => $query->func()->count('id'), 'amount' => $query->func()->sum('order_amount')])
            ->firstOrFail();
        if(!empty($query)) {
            $order_count += $query->count;
            $unpaid = $query->amount ? number_format($query->amount) : 0;
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('profile', 'cart_quantity', 'order_count', 'paid', 'unpaid'));
    }

    /**
     * ログイン中のユーザーに該当する注文データを取得
     */
    public function orderList() {
        $new_orders = $this->Orders->find()
            ->contain([
                'OrderDetails' => function($query) {
                    return $query->contain('Products', function($query) {
                        return $query->contain('ImageProducts', function($query) {
                            return $query->limit(1);
                        });
                    });
                }
            ])
            ->where([
                'Orders.user_id' => $this->Authentication->user->id,
                'OR' => [
                    'Orders.status IN ' => [OrdersTable::PREPARING, OrdersTable::DELIVERING],
                    'AND' => [
                        'Orders.status' => OrdersTable::CANCELED,
                        'Orders.payment_status IN' => [OrdersTable::PAID, OrdersTable::DELIVERED],
                    ],
                ],
            ])
            ->order(['Orders.status' => 'ASC', 'Orders.order_number' => 'ASC'])
            // ->sql();
            ->all()
            ->map(function(Order $order) {
                $order['order_date'] = $order->created->format('Y-m-d');
                return $order;
            })
            ->toList();

        $old_orders = $this->Orders->find()
            ->contain([
                'OrderDetails' => function($query) {
                    return $query->contain('Products', function($query) {
                        return $query->contain('ImageProducts', function($query) {
                            return $query->limit(1);
                        });
                    });
                }
            ])
            ->where([
                'Orders.user_id' => $this->Authentication->user->id,
                'OR' => [
                    'Orders.status' => OrdersTable::DELIVERED,
                    'AND' => [
                        'Orders.status' => OrdersTable::CANCELED,
                        'Orders.payment_status IN' => [OrdersTable::PREPARING, OrdersTable::CANCELED],
                    ]
                ]
            ])
            ->order(['Orders.status' => 'ASC', 'Orders.order_number' => 'DESC'])
            ->all()
            ->map(function(Order $order) {
                $order['order_date'] = $order->created->format('Y-m-d');
                return $order;
            })
            ->toList();
            // var_dump($old_orders);
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('cart_quantity', 'new_orders', 'old_orders'));
    }

    /**
     * 注文詳細データを取得
     */
    public function orderDetail($id = null) {
        $order = $this->Orders->find()
            ->contain([
                'OrderDetails' => function($query) {
                    return $query->contain('Products', function($query) {
                        return $query->contain(['ImageProducts', 'Categories'])
                        ->order(['Products.category_id', 'Products.name']);
                    })
                    ->order('OrderDetails.product_id');
                }
            ])
            ->where([
                'Orders.id' => $id,
            ])
            ->all()
            ->map(function(Order $order) {
                $order['order_date'] = $order->created->format('Y-m-d');
                return $order;
            })->first();

            // var_dump($order);
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('cart_quantity', 'order'));
    }

    /**
     * 注文のキャンセル
     *
     * @param int $id 注文ID
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function orderCancel($id = null) {
        if(is_null($id)) {
            $this->Flash->error('AAAA');
        }
        if($this->request->is(['put', 'post'])) {
            $order = $this->Orders->find()->where(['id' => $id])->contain('OrderDetails')->first();
            if($order) {
                $order->set('status', OrdersTable::CANCELED);
                $payment_point = $order->payment_point;
                $user = $this->Users->get($this->Authentication->user->id);
                $user->point += $payment_point;
                if($this->Orders->save($order)) {
                    $this->Users->save($user);
                    $products = [];
                    foreach ($order->order_details as $key => $order_detail) {
                        $product = $this->Orders->OrderDetails->Products->find()->where(['id' => $order_detail->product_id])->first();
                        if(!empty($product)) {
                            $product->quantity += $order_detail->quantity;
                            $products[] = $product;
                        }
                    }
                    if(count($products) > 0) {
                        $this->Orders->OrderDetails->Products->saveMany($products);
                    }
                    // $this->Flash->success(MSG_1000);
                }
            }
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('cart_quantity'));
    }

    /**
     * 購入商品カートの数を取得する
     *
     * @param array $shopping_cart クッキーに格納している情報
     * @return int
     */
    private function _getShoppingCartTotalQuantity($shopping_cart = null)
    {
        if(empty($shopping_cart)) {
            $shopping_cart = $this->request->getCookie(ShopsController::COOKIE_NM);
            if(!empty($shopping_cart)) $shopping_cart = json_decode($shopping_cart, true);
        }
        $quantity = 0;
        if(!empty($shopping_cart[ShopsController::PRODUCT_COOKIE_NM])) {
            foreach ($shopping_cart[ShopsController::PRODUCT_COOKIE_NM] as $key => $category) {
                if(is_array($category)) $quantity += array_sum($category);
            }
        }
        return $quantity ? $quantity : null;
    }

    // /**
    //  * View method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Http\Response|null|void Renders view
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function view($id = null)
    // {
    //     $profile = $this->Profiles->get($id, [
    //         'contain' => [],
    //     ]);

    //     $this->set(compact('profile'));
    // }

    // /**
    //  * Add method
    //  *
    //  * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
    //  */
    // public function add()
    // {
    //     $profile = $this->Profiles->newEmptyEntity();
    //     if ($this->request->is('post')) {
    //         $profile = $this->Profiles->patchEntity($profile, $this->request->getData());
    //         if ($this->Profiles->save($profile)) {
    //             $this->Flash->success(__('The profile has been saved.'));

    //             return $this->redirect(['action' => 'index']);
    //         }
    //         $this->Flash->error(__('The profile could not be saved. Please, try again.'));
    //     }
    //     $this->set(compact('profile'));
    // }

    /**
     * Edit method
     *
     * @param string|null $id Profile id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        if(empty($this->Authentication) || empty($this->Authentication->user)) {
            $this->Flash->error(__('Please sign-in for editing profile'));
            return $this->redirect(['action' => 'index']);
        }
        $profile = $this->Users->find()->where(['id' => $this->Authentication->user->id])->first();
        if ($this->request->is(['patch', 'post', 'put'])) {
            $profile = $this->Users->patchEntity($profile, $this->request->getData());
            if ($this->Users->save($profile)) {
                $this->Flash->success(__('The profile has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The profile could not be saved. Please, try again.'));
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('profile', 'cart_quantity'));
    }

    // /**
    //  * Delete method
    //  *
    //  * @param string|null $id Profile id.
    //  * @return \Cake\Http\Response|null|void Redirects to index.
    //  * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
    //  */
    // public function delete($id = null)
    // {
    //     $this->request->allowMethod(['post', 'delete']);
    //     $profile = $this->Profiles->get($id);
    //     if ($this->Profiles->delete($profile)) {
    //         $this->Flash->success(__('The profile has been deleted.'));
    //     } else {
    //         $this->Flash->error(__('The profile could not be deleted. Please, try again.'));
    //     }

    //     return $this->redirect(['action' => 'index']);
    // }
}
