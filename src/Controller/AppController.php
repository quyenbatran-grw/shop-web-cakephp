<?php
declare(strict_types=1);

/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link      https://cakephp.org CakePHP(tm) Project
 * @since     0.2.9
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 */
namespace App\Controller;

use App\Model\Entity\User;
use Cake\Controller\Controller;
use Cake\Event\EventInterface;
use Cake\Http\Cookie\Cookie;
use Cake\Http\Cookie\CookieInterface;
use Cake\Http\Response;
use Cake\I18n\FrozenDate;
use DateTime;

/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @link https://book.cakephp.org/4/en/controllers.html#the-app-controller
 */
class AppController extends Controller
{
    public $paginate = [
        'limit' => 20
    ];
    /**
     * Initialization hook method.
     *
     * Use this method to add common initialization code like loading components.
     *
     * e.g. `$this->loadComponent('FormProtection');`
     *
     * @return void
     */
    public function initialize(): void
    {
        parent::initialize();

        $this->loadComponent('RequestHandler');
        $this->loadComponent('Flash');

        $this->loadComponent('Authentication.Authentication');


        /*
         * Enable the following component for recommended CakePHP form protection settings.
         * see https://book.cakephp.org/4/en/controllers/components/form-protection.html
         */
        //$this->loadComponent('FormProtection');
    }

    public function beforeFilter(EventInterface $event)
    {
        $uri = $_SERVER['REQUEST_URI'];
        if(isset($this->Authentication)) {
            $userResult = $this->Authentication->getResult();
            if($userResult) {
                $user = $userResult->getData();
                $this->set('auth', $user);

                if($user) {
                    $this->Authentication->user = $user;
                    if(($uri == '/admin' && !$user->role) || ($uri == '/users' && $user->role)) $this->redirect('/shops/logout');
                }
            }
        }
    }

    /**
     * クッキー情報を取得する
     *
     * @param string $cookie_name
     * @return array
     */
    function getCookie($cookie_name): array {
        $shopping_cart = $this->request->getCookie($cookie_name);
        return json_decode($shopping_cart, true);
    }

    /**
     * クッキーに格納する
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

        $this->response->withCookie($cookie);
    }

    // /**
    //  * 本日の日付を取得する
    //  * @param string $format default = 'Y-m-d'
    //  * return string
    //  */
    // public function _today($format = 'Y-m-d') {
    //     $now = FrozenDate::now();
    //     return $now->i18nFormat('Y-m-d');
    // }

    /**
     *
     */


}
