<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Product;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieInterface;
use Cake\Http\Session;
use Cake\ORM\Query;
use DateTime;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

use function PHPUnit\Framework\isNull;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @property \App\Model\Table\CategoriesTable $Categories
 * @property \App\Model\Table\ProductsTable $Products
 * @property \App\Model\Table\ImageProductsTable $ImageProducts
 * @property \App\Model\Table\OrdersTable $Orders
 * @property \Cake\Http\Session $Session
 * @property $Authentication
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShopsController extends AppController
{
    const COOKIE_NM = 'shopping_carts';
    const ORDER_NUMBERS_COOKIE_NM = 'order_numbers';
    const PRODUCT_COOKIE_NM = 'product';
    const CUSTOMER_COOKIE_NM = 'customer';

    public function initialize(): void
    {
        parent::initialize();

        Configure::write('Session', [
            'defaults' => 'php',
            'cookie' => 'product_cart',
            'timeout' => 4320 // 3日間
        ]);

        $this->Users = $this->fetchTable('Users');
        $this->Categories = $this->fetchTable('Categories');
        $this->Products = $this->fetchTable('Products');
        $this->ImageProducts = $this->fetchTable('ImageProducts');
        $this->Orders = $this->fetchTable('Orders');

        $this->Session = $this->request->getSession();
    }
    // in src/Controller/UsersController.php
    public function beforeFilter(\Cake\Event\EventInterface $event)
    {
        parent::beforeFilter($event);

        $this->Authentication->allowUnauthenticated(['index', 'category', 'product', 'login', 'add', 'cartList', 'cartConfirm', 'orderInfo', 'purchase']);
        // $this->Authentication->skipAuthorization();
    }

    /**
     * Index method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function index($id = null)
    {
        $this->viewBuilder()->setLayout('shop');
        $categories = $this->Categories
                        ->find()
                        // ->innerJoinWith('Products', function(Query $query) {
                        //     return $query
                        //             ->innerJoinWith('ProductInventories', function(Query $query) {
                        //                 return $query;
                        //             });
                        // })

                        ->contain([
                            'Products' => function(Query $query) {
                                return $query
                                        ->innerJoinWith('ProductInventories', function(Query $query) {
                                            return $query;
                                        })
                                        ->contain(['ImageProducts']);
                            }
                        ])
                        ->all()
                        ->map(function($category) {
                            // $result = $product_inventory;
                            // $result['category']
                            if(count($category->products)) return $category;
                            return null;
                        });
                        // var_dump($categories->toArray());
        $image_products = $this->ImageProducts->find()->limit(3)->all();
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('image_products', 'categories', 'cart_quantity'));
        $this->render('home');
    }
/**
     * Category method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function category($id = null)
    {
        if(empty($id) || !is_numeric($id)) {
            throw new Exception("Error Processing Request", 1);

        }
        $this->viewBuilder()->setLayout('shop');

        $products = $this->Categories->Products
                        ->find()
                        ->contain([
                            'ImageProducts',
                            'ProductInventories' => function($query) {
                                return $query
                                    ->order(['ProductInventories.date' => 'DESC']);
                            }
                        ])
                        ->where(['Products.category_id' => $id])
                        ->all()
                        ->map(function($product) {
                            if(isset($product->product_inventories) && count($product->product_inventories)) return $product;
                            return null;
                        });

        $quantity_stocks = $this->_getStockQuantity($id);
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('products', 'cart_quantity', 'quantity_stocks'));
        $this->render('category');
    }


    /**
     * Product method
     *
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function product($id = null, $product_id = null)
    {
        $this->viewBuilder()->setLayout('shop');
        $cart_quantity = '';
        $add_to_cart = false;
        $product = $this->Categories->Products
                        ->find()
                        ->contain([
                            'ImageProducts',
                            'ProductInventories' => function($query) {
                                return $query
                                    ->order(['ProductInventories.date' => 'DESC']);
                            },
                            'Categories'
                        ])
                        ->where(['Products.id' => $product_id])
                        ->firstOrFail();
        // 在庫の数
        $quantity_stocks = $this->_getStockQuantity($id, $product_id);
        $stock_quantity = [];

        if(isset($quantity_stocks[$product_id])) {
            for($i = 1; $i <= $quantity_stocks[$product_id]; $i++) {
                $stock_quantity[$i] = $i;
            }
        }
        $quantity = $this->request->getData('quantity', null);

        $shopping_cart = $this->request->getCookie(self::COOKIE_NM);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
            $shopping_cart[self::PRODUCT_COOKIE_NM][$id] = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        if(!is_null($quantity) && $stock_quantity >= $quantity) {
            $shopping_cart[self::PRODUCT_COOKIE_NM][$id][$product_id] = $quantity;
            $cookie = (new Cookie(self::COOKIE_NM))
            ->withValue($shopping_cart)
            ->withExpiry(new DateTime('+1 year'))
            ->withPath('/')
            ->withDomain('localhost')
            ->withSecure(false)
            ->withSameSite(CookieInterface::SAMESITE_STRICT)
            ->withHttpOnly(false);

            $this->response = $this->response->withCookie($cookie);
            $add_to_cart = true;
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity($shopping_cart);


        $this->set(compact('product', 'cart_quantity', 'stock_quantity', 'add_to_cart'));

        if($this->request->is(['post', 'put'])) {
            if($add_to_cart) $this->Flash->toast('Product is added to cart');
            return $this->redirect(['controller' => 'Shops', 'action' => 'product', $id, $product_id]);
        }
        $this->render('product');

    }

    /**
     * CartList method
     *
     * @param integer|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cartList($id = null)
    {
        $this->viewBuilder()->setLayout('shop');

        $cart_products = $this->_getProductsFromCart();
        $shopping_cart = null;
        if($this->request->is(['put', 'delete'])) {
            $quantity = $this->request->getData('quantity', null);
            $category_id = $this->request->getData('category_id', 0);
            $product_id = $this->request->getData('product_id', 0);
            if(is_null($quantity)) unset($cart_products[$product_id]);
            if(isset($cart_products[$product_id])) $cart_products[$product_id] = $quantity;
            $shopping_cart = $this->_setShoppingProductCookie($category_id, $product_id, $quantity);
        }
        $products = null;
        // 在庫の数
        $quantity_stocks = $this->_getStockQuantity();
        if(!empty($cart_products)) {
            $product_ids = array_keys($cart_products);
            $products = $this->Categories->Products
                            ->find('productCart', $product_ids)
                            // ->contain([
                            //     'Categories',
                            //     'ImageProducts' => function(Query $query) {
                            //         return $query->limit(1);
                            //     },
                            //     'ProductInventories' => function($query) {
                            //         return $query
                            //         ->orderDesc('ProductInventories.date');
                            //     }
                            // ])
                            // ->where(['Products.id IN' => $product_ids])
                            ->all()
                            ->map(function(Product $product) use($cart_products, $quantity_stocks) {
                                $product['product_inventory'] = null;
                                if(isset($cart_products[$product->id])) $product->quantity = $cart_products[$product->id];
                                if(isset($quantity_stocks[$product->id])) $product->quantity_stocks = range(1, $quantity_stocks[$product->id]);
                                if(isset($product['product_inventories'])) {
                                    if(isset($product['product_inventories'][0])) {
                                        $product['product_inventory'] = $product['product_inventories'][0];
                                        unset($product['product_inventories']);
                                    }
                                }
                                return $product;
                            })
                            ->toArray();
        }
        // debug($quantity_stocks);
        $cart_quantity = $this->_getShoppingCartTotalQuantity($shopping_cart);
        $this->set(compact('products', 'cart_quantity'));
        $this->render('cart_list');
    }

    /**
     * CartConfirm method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function cartConfirm($id = null)
    {
        $this->viewBuilder()->setLayout('shop');
        $user = $this->Authentication->user;
        $auth = false;
        $continue = $this->request->getData('shopping_continue', false);
        if($this->Authentication && $this->Authentication->user) {
            $auth = true;
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $customer = $this->_getShopingCustomerCookie();
        $this->set(compact('auth', 'cart_quantity', 'continue', 'customer'));
        $this->render('cart_confirm');
    }

    /**
     * OrderInfo method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function orderInfo($id = null)
    {
        $orderTable = $this->getTableLocator()->get('Orders');
        $order = $orderTable->newEmptyEntity();
        $this->viewBuilder()->setLayout('shop');
        $customer = [];
        if($this->request->is(['post', 'put'])) {
            $customer = $this->request->getData();
            $this->_setShoppingCustomer($customer);
        }

        $cart_products = $this->_getProductsFromCart();
        $product_ids = array_keys($cart_products);
        // 在庫の数
        $quantity_stocks = $this->_getStockQuantity();
        $products = $this->Categories->Products
                            ->find('productCart', $product_ids)
                            ->all()
                            ->map(function(Product $product) use($cart_products, $quantity_stocks) {
                                $product['product_inventory'] = null;
                                if(isset($cart_products[$product->id])) $product->quantity = $cart_products[$product->id];
                                if(isset($quantity_stocks[$product->id])) $product->quantity_stocks = range(1, $quantity_stocks[$product->id]);
                                if(isset($product['product_inventories'])) {
                                    if(isset($product['product_inventories'][0])) {
                                        $product['product_inventory'] = $product['product_inventories'][0];
                                        unset($product['product_inventories']);
                                    }
                                }
                                return $product;
                            })
                            ->toArray();
                            // debug($products);
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('products', 'cart_quantity', 'customer', 'order'));
        $this->render('order_info');
    }

    /**
     * OrderInfo method
     *
     * @param string|null $id Category id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function purchase($id = null)
    {
        $this->viewBuilder()->setLayout('shop');

        $cart_products = $this->_getProductsFromCart();
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        if($this->request->is(['post', 'put'])) {
            // debug($cart_products);
            if(!empty($cart_products) && $cart_quantity) {
                $customer = $this->_getShopingCustomerCookie();
                // debug($customer);
                $user = $this->Authentication->user;
                $associated = ['OrderDetails'];
                $order_details = [];
                $order = [];
                if(!empty($user)) $order['user_id'] = $user->id;
                $order['order_number'] = time();
                $order['order_name'] = $customer['name'];
                $order['order_address'] = $customer['address'];
                $order['order_tel'] = $customer['tel'];
                $order['memo'] = $customer['memo'];
                $order['order_amount'] = 0;
                foreach ($cart_products as $product_id => $quantity) {
                    $order_details[] = [
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'unit_price' => 0,
                        'amount' => 0,
                    ];
                }
                $order['order_details'] = $order_details;

                // $order = [
                //     'order_number' => time(),
                //     'order_name' => 'test',
                //     'order_address' => 'test1',
                //     'order_tel' => '123445444',
                //     'order_amount' => 1000,
                //     'order_details' => [
                //         [
                //             'product_id' => 4,
                //             'quantity' => 2,
                //             'unit_price' => 130000,
                //             'amount' => 260000,
                //         ],
                //         [
                //             'product_id' => 10,
                //             'quantity' => 2,
                //             'unit_price' => 130000,
                //             'amount' => 260000,
                //         ]
                //     ]
                // ];


                $orderEntity = $this->Orders->newEmptyEntity();
                $orderEntity = $this->Orders->patchEntity($orderEntity, $order, ['associated' => ['OrderDetails']]);
                // var_dump($orderEntity);
                // $order_data = $orderTBL->find()->contain('OrderDetails')->where(['id' => 1])->first();
                // $order_data->order_details[0]->quantity = 10;
                // $this->Orders->save($orderEntity);
                // dd($order_data);
                // $orderDetailsTBL = $this->fetchTable('OrderDetails');

                // $orderDetailEntity = $orderDetailsTBL->newEntities($order_details);

                // $orderDetailsTBL->saveMany($orderDetailEntity);

                // dd($orderDetailEntity);

                // $orderEntity = $orderTBL->newEmptyEntity();
                // $orderEntity = $orderTBL->patchEntity($orderEntity, $order, ['associated' => ['OrderDetails']]);
                // debug($orderEntity);
                // $orderEntity->order_details = $orderDetailEntity;
                // // $orderE = $orderTBL->find()->contain('OrderDetails')->all()->toArray();
                // // dd($orderEntity->order_details);
                // // $orderEntity = $orderTBL->newEntity($order, [
                // //     'associated' => $associated
                // // ]);
                // // $orderEntity->order_details = $order_details;
                // // $orderEntity->setDirty('order_details', true);



                // // $orderEntity = $this->Products->Orders->newEntity($order, ['associated' => $associated]);
                // // $orderEntity = $this->Products->Orders->newEmptyEntity();
                // // $orderEntity = $this->Products->Orders->patchEntity($orderEntity, $order, ['associated' => $conditions]);
                if($this->Orders->save($orderEntity)) {
                //     // if($this->Products->Orders->save($orderEntity, $order, ['associated' => $associated])) {
                    $order_numbers = $this->_getShoppingCookie(self::ORDER_NUMBERS_COOKIE_NM);
                    if(!in_array($orderEntity->order_number, $order_numbers)) {
                        $order_numbers[] = $orderEntity->order_number;
                        $this->_setShoppingCookie(self::ORDER_NUMBERS_COOKIE_NM, $order_numbers);
                    }
                    debug(true);
                }
                debug($orderEntity->getErrors());
                // debug($orderEntity);
            }
            // $this->_deleteShoppingCookie();
            // $cart_quantity = null;
        }



        $this->set(compact('cart_quantity'));
        $this->render('purchase');
    }

    /**
     * 商品の在庫数取得を行う
     *
     * @param int|null $category_id カテゴリーID
     * @param int|null $product_id 商品ID
     *
     * @return array|null;
     */
    private function _getStockQuantity($category_id = null, $product_id = null)
    {
        $search = [
            'category_id' => $category_id,
            'product_id' => $product_id
        ];
        $product_inventories = $this->Categories->Products
                        ->find('search', ['search' => $search])
                        ->contain([
                            'ProductInventories' => function($query) {
                                $query = $query
                                ->select(['ProductInventories.product_id']);
                                return $query
                                ->select(['quantity' => $query->func()->sum('ProductInventories.quantity')])
                                ->group('ProductInventories.product_id');
                            }
                        ])
                        ->formatResults(function($product) {
                            return $product->combine(
                                'id',
                                function($row) {
                                    return isset($row['product_inventories'][0]) ? $row['product_inventories'][0]['quantity'] : null;
                                }
                            );
                        })
                        ->all()
                        ->toArray();

        // 注文した商品の数を取得する
        $orders = $this->Categories->Products
                        ->find('search', ['search' => $search])
                        ->contain([
                            'OrderDetails' => function($query) {
                                $query = $query
                                ->select(['OrderDetails.product_id']);
                                return $query
                                ->select(['quantity' => $query->func()->sum('OrderDetails.quantity')])
                                ->group('OrderDetails.product_id');
                            }
                        ])
                        ->formatResults(function($product) {
                            return $product->combine(
                                'id',
                                function($row) {
                                    return isset($row['order_details'][0]) ? $row['order_details'][0]['quantity'] : null;
                                }
                            );
                        })
                        ->all()
                        ->toArray();

        $product_inventories = array_filter($product_inventories, fn($n) => $n);
        $orders = array_filter($orders, fn($n) => $n);
        $quantity_stocks = [];
        foreach ($product_inventories as $key => $quantity) {
            if(isset($orders[$key])) $quantity = $quantity - $orders[$key];
            $quantity_stocks[$key] = $quantity;
        }
        // var_dump($quantity_stocks);
        return $quantity_stocks;
    }

    /**
     * 購入商品の数量をクッキーに格納する
     *
     * @param int $categoy_id カテゴリーID
     * @param int $product_id 商品ID
     * @param int $quantity 数量
     *
     * @return Array
     */
    private function _setShoppingProductCookie($category_id, $product_id, $quantity = null) {
        $shopping_cart = $this->request->getCookie(self::COOKIE_NM);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
            $shopping_cart[self::PRODUCT_COOKIE_NM][$category_id] = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        if(is_null($quantity)) unset($shopping_cart[self::PRODUCT_COOKIE_NM][$category_id][$product_id]);
        else $shopping_cart[self::PRODUCT_COOKIE_NM][$category_id][$product_id] = $quantity;
        $this->_setShoppingCookie(self::COOKIE_NM, $shopping_cart);
        return $shopping_cart;
    }

    /**
     * クッキー情報を取得する
     *
     * @param string $cookie_name
     * @return array|null
     */
    private function _getShoppingCookie($cookie_name) {
        $shopping_cart = $this->request->getCookie($cookie_name);
        return json_decode($shopping_cart, true);
    }

    /**
     * 購入商品の数量をクッキーに格納する
     *
     * @param string $cookie_name クッキー名
     * @param array $shopping_cart 購入商品
     */
    private function _setShoppingCookie($cookie_name, $shopping_cart) {
        $cookie = (new Cookie($cookie_name))
                    ->withValue($shopping_cart)
                    ->withExpiry(new DateTime('+1 year'))
                    ->withPath('/')
                    ->withDomain('localhost')
                    ->withSecure(false)
                    ->withSameSite(CookieInterface::SAMESITE_STRICT)
                    ->withHttpOnly(false);

        $this->response = $this->response->withCookie($cookie);
    }

    /**
     * 購入商品クッキーを削除する
     */
    private function _deleteShoppingCookie() {
        $cookie = (new Cookie(self::PRODUCT_COOKIE_NM))
                    ->withExpiry(new DateTime('-1 year'))
                    ->withPath('/')
                    ->withDomain('localhost')
                    ->withSecure(false)
                    ->withSameSite(CookieInterface::SAMESITE_STRICT)
                    ->withHttpOnly(false);

        $this->response = $this->response->withCookie($cookie);
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
            $shopping_cart = $this->request->getCookie(self::COOKIE_NM);
            if(!empty($shopping_cart)) $shopping_cart = json_decode($shopping_cart, true);
        }
        $quantity = 0;
        if(!empty($shopping_cart[self::PRODUCT_COOKIE_NM])) {
            foreach ($shopping_cart[self::PRODUCT_COOKIE_NM] as $key => $category) {
                if(is_array($category)) $quantity += array_sum($category);
            }
        }
        return $quantity ? $quantity : null;
    }

    /**
     * カートに入れている商品を取得する
     *
     * @param array $shopping_cart クッキーに格納している情報
     * @return array
     */
    private function _getProductsFromCart($shopping_cart = null)
    {
        if(empty($shopping_cart)) {
            $shopping_cart = $this->request->getCookie(self::COOKIE_NM);
            if(!empty($shopping_cart)) $shopping_cart = json_decode($shopping_cart, true);
        }
        $products = [];
        if(!empty($shopping_cart[self::PRODUCT_COOKIE_NM])) {
            foreach ($shopping_cart[self::PRODUCT_COOKIE_NM] as $key => $category) {
                if(is_array($category)) $products += $category;
            }
        }
        return $products;
    }

    /**
     * 注文のお客様情報をクッキーに格納する
     *
     * @param array $customer 注文のお客様情報
     */
    private function _setShoppingCustomer($customer) {
        $shopping_cart = $this->request->getCookie(self::COOKIE_NM, null);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        $shopping_cart[self::CUSTOMER_COOKIE_NM] = $customer;
        $this->_setShoppingCookie(self::COOKIE_NM, $shopping_cart);
    }

    /**
     * 注文のお客様情報をクッキーを取得する
     *
     * @return array
     */
    private function _getShopingCustomerCookie() {
        $shopping_cart = $this->request->getCookie(self::COOKIE_NM, null);
        if(!is_null($shopping_cart)) {
            $shopping_cart = json_decode($shopping_cart, true);
            $shopping_cart = $shopping_cart[self::CUSTOMER_COOKIE_NM];
        }
        return $shopping_cart;
    }


    /**
     * View method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function view($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);

        $this->set(compact('user'));
    }

    /**
     * Add method
     *
     * @return \Cake\Http\Response|null|void Redirects on successful add, renders view otherwise.
     */
    public function add()
    {
        $user = $this->Users->newEmptyEntity();
        if ($this->request->is('post')) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Edit method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects on successful edit, renders view otherwise.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function edit($id = null)
    {
        $user = $this->Users->get($id, [
            'contain' => [],
        ]);
        if ($this->request->is(['patch', 'post', 'put'])) {
            $user = $this->Users->patchEntity($user, $this->request->getData());
            if ($this->Users->save($user)) {
                $this->Flash->success(__('The user has been saved.'));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__('The user could not be saved. Please, try again.'));
        }
        $this->set(compact('user'));
    }

    /**
     * Delete method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Redirects to index.
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function delete($id = null)
    {
        $this->request->allowMethod(['post', 'delete']);
        $user = $this->Users->get($id);
        if ($this->Users->delete($user)) {
            $this->Flash->success(__('The user has been deleted.'));
        } else {
            $this->Flash->error(__('The user could not be deleted. Please, try again.'));
        }

        return $this->redirect(['action' => 'index']);
    }

    public function login()
    {
        $result = $this->Authentication->getResult();
        // If the user is logged in send them away.
        if ($result->isValid()) {
            $target = $this->Authentication->getLoginRedirect() ?? null;
            // dd($this->Authentication->getLoginRedirect());
            $user = $this->Authentication->user;
            if($user->role) $target = '/admin';
            else if(is_null($target)) $target = 'users';
            return $this->redirect($target);
        }
        if ($this->request->is('post')) {
            $this->Flash->error('Invalid username or password');
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Shops', 'action' => 'login']);
    }
}
