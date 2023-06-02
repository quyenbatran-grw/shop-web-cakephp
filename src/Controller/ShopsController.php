<?php
declare(strict_types=1);

namespace App\Controller;

use App\Model\Entity\Product;
use Authentication\PasswordHasher\DefaultPasswordHasher;
use Cake\Core\Configure;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieInterface;
use Cake\ORM\Query;
use DateTime;
use Exception;
use Psr\Http\Message\ServerRequestInterface;

use function PHPUnit\Framework\isNull;

/**
 * Users Controller
 *
 * @property \App\Model\Table\UsersTable $Users
 * @method \App\Model\Entity\User[]|\Cake\Datasource\ResultSetInterface paginate($object = null, array $settings = [])
 */
class ShopsController extends AppController
{
    const PRODUCT_COOKIE_NM = 'shopping_carts';

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
                                        ->contain('ImageProducts');
                            }
                        ])
                        ->all()
                        ->map(function($category) {
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
        $category = $this->Categories
                        ->find()
                        ->contain([
                            'Products' => function(Query $query) {
                                return $query->contain('ImageProducts');
                            }
                        ])
                        ->where(['Categories.id' => $id])
                        ->firstOrFail();
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('category', 'cart_quantity'));
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
        $product = $this->Categories->Products
                        ->find()
                        ->contain([
                            'ImageProducts',
                            'Categories'
                        ])
                        ->where(['Products.id' => $product_id])
                        ->firstOrFail();
        $quantity = $this->request->getData('quantity', null);

        $shopping_cart = $this->request->getCookie(self::PRODUCT_COOKIE_NM);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
            $shopping_cart[$id] = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        if(!is_null($quantity)) {
            $shopping_cart[$id][$product_id] = $quantity;
            $cookie = (new Cookie(self::PRODUCT_COOKIE_NM))
            ->withValue($shopping_cart)
            ->withExpiry(new DateTime('+1 year'))
            ->withPath('/')
            ->withDomain('localhost')
            ->withSecure(false)
            ->withSameSite(CookieInterface::SAMESITE_STRICT)
            ->withHttpOnly(false);

            $this->response = $this->response->withCookie($cookie);
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity($shopping_cart);


        $this->set(compact('product', 'cart_quantity'));
        $this->render('product');
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
    private function _updateShoppingCookie($category_id, $product_id, $quantity = null) {
        $shopping_cart = $this->request->getCookie(self::PRODUCT_COOKIE_NM);
        if(is_null($shopping_cart)) {
            $shopping_cart = [];
            $shopping_cart[$category_id] = [];
        } else {
            $shopping_cart = json_decode($shopping_cart, true);
        }
        if(is_null($quantity)) unset($shopping_cart[$category_id][$product_id]);
        else $shopping_cart[$category_id][$product_id] = $quantity;
        $cookie = (new Cookie(self::PRODUCT_COOKIE_NM))
                    ->withValue($shopping_cart)
                    ->withExpiry(new DateTime('+1 year'))
                    ->withPath('/')
                    ->withDomain('localhost')
                    ->withSecure(false)
                    ->withSameSite(CookieInterface::SAMESITE_STRICT)
                    ->withHttpOnly(false);

        $this->response = $this->response->withCookie($cookie);
        return $shopping_cart;
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
            $shopping_cart = $this->request->getCookie(self::PRODUCT_COOKIE_NM);
            if(!empty($shopping_cart)) $shopping_cart = json_decode($shopping_cart, true);
        }
        $quantity = 0;
        if(!empty($shopping_cart)) {
            foreach ($shopping_cart as $key => $category) {
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
            $shopping_cart = $this->request->getCookie(self::PRODUCT_COOKIE_NM);
            if(!empty($shopping_cart)) $shopping_cart = json_decode($shopping_cart, true);
        }
        $products = [];
        if(!empty($shopping_cart)) {
            foreach ($shopping_cart as $key => $category) {
                if(is_array($category)) $products += $category;
            }
        }
        return $products;
    }

    /**
     * CartList method
     *
     * @param string|null $id User id.
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
            $shopping_cart = $this->_updateShoppingCookie($category_id, $product_id, $quantity);
        }
        $products = null;
        if(!empty($cart_products)) {
            $product_ids = array_keys($cart_products);
            $products = $this->Categories->Products
                            ->find()
                            ->contain([
                                'Categories',
                                'ImageProducts' => function(Query $query) {
                                    return $query->limit(1);
                                }
                            ])
                            ->where(['Products.id IN' => $product_ids])
                            ->all()
                            ->map(function(Product $product) use($cart_products) {
                                if(isset($cart_products[$product->id])) $product->quantity = $cart_products[$product->id];
                                return $product;
                            });
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
        if($this->Authentication && $this->Authentication->user) {
            $auth = true;
        }
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('auth', 'cart_quantity', 'continue'));
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
        $this->viewBuilder()->setLayout('shop');

        $cart_products = $this->_getProductsFromCart();
        $product_ids = array_keys($cart_products);
        $products = $this->Categories->Products
                        ->find()
                        ->contain([
                            'Categories',
                            'ImageProducts' => function(Query $query) {
                                return $query->limit(1);
                            }
                        ])
                        ->where(['Products.id IN' => $product_ids])
                        ->all()
                        ->map(function(Product $product) use($cart_products) {
                            if(isset($cart_products[$product->id])) $product->quantity = $cart_products[$product->id];
                            return $product;
                        });
        $cart_quantity = $this->_getShoppingCartTotalQuantity();
        $this->set(compact('products', 'cart_quantity'));
        $this->render('order_info');
    }

    /**
     * OrderInfo method
     *
     * @param string|null $id User id.
     * @return \Cake\Http\Response|null|void Renders view
     * @throws \Cake\Datasource\Exception\RecordNotFoundException When record not found.
     */
    public function purchase($id = null)
    {
        $this->viewBuilder()->setLayout('shop');
        $cookie = (new Cookie(self::PRODUCT_COOKIE_NM))
        ->withExpiry(new DateTime('-1 year'))
        ->withPath('/')
        ->withDomain('localhost')
        ->withSecure(false)
        ->withSameSite(CookieInterface::SAMESITE_STRICT)
        ->withHttpOnly(false);

        $this->response = $this->response->withCookie($cookie);

        $cart_quantity = null;
        $this->set(compact('cart_quantity'));
        $this->render('purchase');
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
            $target = $this->Authentication->getLoginRedirect() ?? '/shops';
            $user = $this->Authentication->user;
            if($user->role) $target = '/admin';
            else $target = 'users';
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
