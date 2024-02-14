<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Order;
use App\Model\Entity\Product;
use App\Model\Table\OrdersTable;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieInterface;
use Cake\Http\Session;
use Cake\I18n\FrozenDate;
use Cake\I18n\FrozenTime;
use Cake\I18n\Number;
use Cake\ORM\Query;
use DateInterval;
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
            ->order(['Products.name'])
            ->all()
            ->toArray();
        $product_arr = [];
        $product_sold_out_arr = [];
        foreach ($products as $product) {
            if(count($product->product_inventories)) $product_arr[] = $product;
            else $product_sold_out_arr[] = $product;
        }
        $products = array_merge($product_arr, $product_sold_out_arr);

        $quantity_stocks = $this->_getStockQuantity($id);
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('products', 'cart_quantity', 'quantity_stocks'));
        $this->render('category');
    }


    /**
     * カートに商品を追加する
     * Product method
     * @param int|null $id カテゴリーID
     * @param int|null $product_id 商品ID
     * @return \Cake\Http\Response|null|void Renders view
     */
    public function product($id = null, $product_id = null)
    {
        $this->viewBuilder()->setLayout('shop');
        $cart_quantity = '';
        $add_to_cart = false;
        $other_products = $this->Categories->Products
            ->find()
            ->contain([
                'ImageProducts',
                'ProductInventories' => function($query) {
                    return $query
                        ->order(['ProductInventories.date' => 'DESC']);
                },
                'Categories'
            ])
            ->where([
                'Products.id <>' => $product_id,
                'Products.category_id' => $id
            ])
            ->order(['Products.name'])
            ->toArray();
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
        $stock_quantity = range(0, $quantity_stocks[$product->id]);
        unset($stock_quantity[0]);


        $shopping_cart = $this->request->getCookie(self::COOKIE_NM);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
            $shopping_cart[self::PRODUCT_COOKIE_NM][$id] = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        // $cart_quantity = $this->_getShoppingCartTotalQuantity($shopping_cart);



        if($this->request->is(['post', 'put'])) {
            $quantity = $this->request->getData('quantity', null);
            if(!is_null($quantity) && $quantity_stocks[$product->id] >= $quantity) {
                if(isset($shopping_cart[self::PRODUCT_COOKIE_NM][$id][$product_id])) $shopping_cart[self::PRODUCT_COOKIE_NM][$id][$product_id] += $quantity;
                else $shopping_cart[self::PRODUCT_COOKIE_NM][$id][$product_id] = $quantity;
                // $cookie = (new Cookie(self::COOKIE_NM))
                //     ->withValue($shopping_cart)
                //     ->withExpiry(new DateTime('+1 year'))
                //     ->withPath('/')
                //     ->withDomain('localhost')
                //     ->withSecure(false)
                //     ->withSameSite(CookieInterface::SAMESITE_STRICT)
                //     ->withHttpOnly(false);

                // $this->response = $this->response->withCookie($cookie);
                $this->_setShoppingCookie(self::COOKIE_NM, $shopping_cart);
                $add_to_cart = true;
                // var_dump($shopping_cart);
                // var_dump($_COOKIE);exit();
            }
            if($add_to_cart) $this->Flash->toast(MSG_0001);
            return $this->redirect(['controller' => 'Shops', 'action' => 'product', $id, $product_id]);
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity($shopping_cart);
        $this->set(compact('product', 'cart_quantity', 'stock_quantity', 'add_to_cart', 'other_products'));
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
            foreach ($quantity as $key => $value) {
                $product_id = $key;
                if(is_null($value)) unset($cart_products[$product_id]);
                if(isset($cart_products[$product_id])) $cart_products[$product_id] = $value;
                $shopping_cart = $this->_setShoppingProductCookie($category_id, $product_id, $value);
            }
        }
        $products = null;
        // 在庫の数
        $quantity_stocks = $this->_getStockQuantity();
        if(!empty($cart_products)) {
            $product_ids = array_keys($cart_products);
            $products = $this->Categories->Products
                            ->find('productCart', $product_ids)
                            ->all()
                            ->map(function(Product $product) use($cart_products, $quantity_stocks) {
                                $product['product_inventory'] = null;
                                if(isset($cart_products[$product->id])) $product->quantity = $cart_products[$product->id];
                                if(isset($quantity_stocks[$product->id])) $product->quantity_stocks = range(0, $quantity_stocks[$product->id]);
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
        $customer = $this->_getShopingCustomerCookie();
        if($this->Authentication && $this->Authentication->user) {
            $auth = true;
            $customer = $this->Authentication->user;
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
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
        $delivery_time = FrozenTime::now()->addMinute(60);
        $order->set([
            'delivery_datetime' => $delivery_time->i18nFormat('Y/MM/dd HH:mm:ss')
        ]);
        $order['delivery_date'] = $delivery_time->i18nFormat('Y/MM/dd');
        $order['delivery_hour_start'] = $delivery_time->i18nFormat('HH');
        $order['delivery_min_start'] = $delivery_time->i18nFormat('00');
        $delivery_time = FrozenTime::now()->addMinute(120);
        $order['delivery_hour_end'] = $delivery_time->i18nFormat('HH');
        $order['delivery_min_end'] = $delivery_time->i18nFormat('00');

        $this->viewBuilder()->setLayout('shop');
        $customer = [];
        if($this->request->is(['post', 'put'])) {
            $customer = $this->request->getData();
            $this->_setShoppingCustomer($customer);
        } else {
            $customer = $this->_getShopingCustomerCookie();
        }
        $customer['point'] = 0;
        if($this->Authentication->user) {
            $user = $this->Users->get($this->Authentication->user->id);
            $customer['point'] = $user->point < 0 ? 0 : $user->point;
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
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $hours = $this->_getSelectionRange();
        $disable_hours = [];
        foreach ($hours as $key => $value) {
            $hours[$key] = $value.':00';
            if($order['delivery_hour_start'] > $value) $disable_hours[] = $value;
        }
        // $minutes = $this->_getSelectionRange(0, 59);

        $this->set(compact('products', 'cart_quantity', 'customer', 'order', 'hours', 'disable_hours'));
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
        $order = null;
        if($this->request->is(['post', 'put'])) {
            if(!empty($cart_products) && $cart_quantity) {
                // 配送時間をチェック
                $requestData = $this->request->getData();
                $delivery_type = $this->request->getData('delivery_type', 0);
                $immediate = $this->request->getData('immediate', null);
                $delivery_start_time = null;
                $delivery_end_time = null;
                if(is_null($immediate)) {
                    // 日時チェック
                    $delivery_date = FrozenTime::parse($this->request->getData('delivery_date'))->i18nFormat('Y/MM/dd');
                    $delivery_time_start = $this->request->getData('delivery_hour_start') . ':00:00';
                    $delivery_time_end = $this->request->getData('delivery_hour_end') . ':00:00';
                    if($delivery_time_start > $delivery_time_end) {
                        $this->Flash->error(MSG_2003);
                        return $this->redirect(['controller' => 'Shops', 'action' => 'order-info']);
                    }
                    $check_time = FrozenTime::now()->i18nFormat('Y/MM/dd HH:mm:00');
                    $delivery_start_time = __('{0} {1}', $delivery_date, $delivery_time_start);
                    $delivery_end_time = __('{0} {1}', $delivery_date, $delivery_time_end);
                    // var_dump($delivery_datetime);
                    // var_dump($check_time);
                    // exit();
                    if($check_time > $delivery_start_time) {
                        $this->Flash->error(MSG_2003);
                        return $this->redirect(['controller' => 'Shops', 'action' => 'order-info']);
                    }
                }

                $customer = $this->_getShopingCustomerCookie();
                $user = $this->Authentication->user;
                $associated = ['OrderDetails'];
                $order_details = [];
                $order = $requestData;
                if(!empty($user)) $order['user_id'] = $user->id;
                // 本日の最新注文番号を取得する
                $today = FrozenDate::today()->i18nFormat('yyMMdd');
                $order_number = $this->Orders
                    ->find()
                    ->where(['order_number >=' => $today . '0000', ['order_number <=' => $today . '9999']])
                    ->orderDesc('order_number')
                    ->first();
                if(!empty($order_number)) {
                    $order_number = substr($order_number['order_number'], -4);
                    $order_number = intval($order_number) + 1;
                    $order_number = $today . str_pad((string)$order_number, 4, '0', STR_PAD_LEFT);
                } else {
                    $order_number = $today . '0001';
                }
                //保存データを整理
                $order['order_number'] = $order_number;
                $order['order_name'] = $customer['full_name'];
                $order['order_address'] = $customer['address'];
                $order['order_tel'] = $customer['tel'];
                $order['memo'] = $customer['memo'];
                $order['order_amount'] = 0;
                $order['payment_point'] = $this->request->getData('payment_point', 0);
                if(empty($order['payment_point'])) $order['payment_point'] = 0;
                $order['payment_type'] = $this->request->getData('payment', 1);
                $order['payment_status'] = OrdersTable::PREPARING;
                $order['user_id'] = null;
                if(is_null($immediate)) {
                    $order['delivery_start_time'] = FrozenTime::parse($delivery_start_time);
                    $order['delivery_end_time'] = FrozenTime::parse($delivery_end_time);
                }
                if($this->Authentication && $this->Authentication->user) {
                    $order['user_id'] = $this->Authentication->user->id;
                    $user = $this->Users->get($this->Authentication->user->id);
                }
                foreach ($cart_products as $product_id => $quantity) {
                    $product = $this->Categories->Products->ProductInventories
                        ->find()
                        ->where(['ProductInventories.product_id' => $product_id])
                        ->order(['ProductInventories.date' => 'DESC'])
                        ->firstOrFail();
                    $unit_price = 0;
                    if(!empty($product)) $unit_price = intval($product->unit_price);
                    $amount = $quantity * $unit_price;
                    $order_details[] = [
                        'product_id' => $product_id,
                        'quantity' => $quantity,
                        'unit_price' => $unit_price,
                        'amount' => $amount,
                    ];
                    $order['order_amount'] += $amount;
                }
                $order['order_amount'] -= $order['payment_point'];
                $order['order_details'] = $order_details;
                $orderEntity = $this->Orders->newEmptyEntity();
                $orderEntity = $this->Orders->patchEntity($orderEntity, $order, ['associated' => ['OrderDetails']]);
                if($this->Orders->save($orderEntity)) {
                    if(!empty($user)) {
                        $point = $user->point - $order['payment_point'];
                        $point = $point < 0 ? 0 : $point;
                        $user = $this->Users->patchEntity($user, ['point' => $point]);
                        $this->Users->save($user);
                    }
                    $this->sendNotify('NEW ORDER', __(MSG_0009, 'for immediation'));
                    // 注文データを保存できたらクッキーのデータを削除
                    $this->_deleteShoppingCookie();
                    $cart_quantity = 0;
                }
            }
            $this->_deleteShoppingCookie();
        }

        if($this->Authentication->user && is_null($order)) {
            $order = $this->Orders->find()
                ->where([
                    'user_id' => $this->Authentication->user->id,
                    'payment_status' => OrdersTable::PREPARING,
                    'payment_type' => OrdersTable::BANKING
                ])
                ->orderAsc('order_number')
                ->limit(1)
                ->firstOrFail();
        }
        $this->set(compact('order', 'cart_quantity'));
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
                    ->innerJoinWith('Orders', function($query) {
                        return $query->where(['Orders.status <>' => OrdersTable::CANCELED]);
                    })
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
                    ->withExpiry(FrozenTime::now()->addYear(1))
                    ->withPath('/')
                    ->withDomain('')
                    ->withSecure(false)
                    ->withSameSite(CookieInterface::SAMESITE_STRICT)
                    ->withHttpOnly(false);

        $this->response = $this->response->withCookie($cookie);
    }

    /**
     * 購入商品クッキーを削除する
     */
    private function _deleteShoppingCookie() {
        $shopping_cart = $this->_getShoppingCookie(self::COOKIE_NM);
        if(!is_null($shopping_cart)) {
            unset($shopping_cart[self::PRODUCT_COOKIE_NM]);
        }
        $this->_setShoppingCookie(self::COOKIE_NM, $shopping_cart);
        // $cookie = (new Cookie(self::COOKIE_NM))
        //             ->withExpiry(new DateTime('-1 year'))
        //             ->withPath('/')
        //             ->withDomain('localhost')
        //             ->withSecure(false)
        //             ->withSameSite(CookieInterface::SAMESITE_STRICT)
        //             ->withHttpOnly(false);

        // $this->response = $this->response->withCookie($cookie);
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
            $shopping_cart = isset($shopping_cart[self::CUSTOMER_COOKIE_NM]) ? $shopping_cart[self::CUSTOMER_COOKIE_NM] : null;
        }
        return $shopping_cart;
    }

    /**
     * プッシュ通知を行う
     */
    private function sendNotify($title = '', $message = '') {
        $FIREBASE_API_KEY = "AAAAFkT__IQ:APA91bGmZt6pTEszdNQfAtAUySHXQHPi15ppxogks1QpCoPt8efpngzUoCnPKw-TZv0DMDnmDMCTEpo01KcH9KUXj0nun_6k-6VIMZ-30SPqeOwqUt-xF-2FFHPWswhb8Bu568tUsVj7";
        $device_token = 'fARpDTXbSEpCnlFX9mcklR:APA91bEek68XOlXNL5zbdw649po1XBy_I9p9hbtM3FmmoaU7wKTD6xF1WgoiIsnyDksDRo7MjndeXxbrh4lTrfaDZazx_crjFnlBh-GTWmOt9PmpzEcKrHro3O5mz_V8MMYlIoukuSim';
        $end_point = "https://fcm.googleapis.com/fcm/send";
        $headers = array(
            'Authorization: key=' . $FIREBASE_API_KEY,
            'Content-Type: application/json'
        );
        if(!empty($title) && !empty($message)) {
            $data = array(
                "to" => $device_token
            ,	"notification" => array(
                    "body" => $message
                ,	"title" => $title
                ,	"badge" => 1
                ,	"sound" => "default",
                )
            ,	"data" => array(
                    "body" => "AAAA"
                ,	"title" => "TEST"
                )
            ,	"apns" => [
                    "payload" => [
                        "aps" => [
                            "sound" => "default",
                            "badge" => 1
                        ],
                    ],
                ],
            );
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, $end_point);
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
            $push_result[] = curl_exec($ch);
            curl_close($ch);
        }
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
                $this->Flash->success(__(MSG_1000));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(MSG_2000));
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
                $this->Flash->success(__(MSG_1000));

                return $this->redirect(['action' => 'index']);
            }
            $this->Flash->error(__(MSG_2000));
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
            $this->Flash->success(__(MSG_1001));
        } else {
            $this->Flash->error(__(MSG_2001));
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
            $this->Flash->error(MSG_2002);
        }
    }

    public function logout()
    {
        $this->Authentication->logout();
        return $this->redirect(['controller' => 'Shops', 'action' => 'login']);
    }
}
