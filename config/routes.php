<?php
/**
 * Routes configuration.
 *
 * In this file, you set up routes to your controllers and their actions.
 * Routes are very important mechanism that allows you to freely connect
 * different URLs to chosen controllers and their actions (functions).
 *
 * It's loaded within the context of `Application::routes()` method which
 * receives a `RouteBuilder` instance `$routes` as method argument.
 *
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */

use App\Controller\User\UsersController;
use App\Middleware\AdminMiddleware;
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {

    $routes->registerMiddleware('Admin', AdminMiddleware::class);
    /*
     * The default class to use for all routes
     *
     * The following route classes are supplied with CakePHP and are appropriate
     * to set as the default:
     *
     * - Route
     * - InflectedRoute
     * - DashedRoute
     *
     * If no call is made to `Router::defaultRouteClass()`, the class used is
     * `Route` (`Cake\Routing\Route\Route`)
     *
     * Note that `Route` does not do any inflections on URLs which will result in
     * inconsistently cased URLs when used with `{plugin}`, `{controller}` and
     * `{action}` markers.
     */
    $routes->setRouteClass(DashedRoute::class);

    $routes->scope('/', function (RouteBuilder $builder) {
        /*
         * Here, we are connecting '/' (base path) to a controller called 'Pages',
         * its action called 'display', and we pass a param to select the view file
         * to use (in this case, templates/Pages/home.php)...
         */
        // $builder->connect('/', ['controller' => 'Pages', 'action' => 'display', 'home']);
        $builder->connect('/', ['controller' => 'Shops', 'action' => 'index', 'home']);
        $builder->connect('/shops/{id}', ['controller' => 'Shops', 'action' => 'category'], ['pass' => ['id']]);
        $builder->connect('/shops/login', ['controller' => 'Shops', 'action' => 'login']);
        $builder->connect('/shops/logout', ['controller' => 'Shops', 'action' => 'logout']);
        $builder->connect('/shops/product', ['controller' => 'Shops', 'action' => 'product']);
        $builder->connect('/shops/cart-list', ['controller' => 'Shops', 'action' => 'cart-list']);
        $builder->connect('/shops/cart-confirm', ['controller' => 'Shops', 'action' => 'cart-confirm']);
        $builder->connect('/shops/order-info', ['controller' => 'Shops', 'action' => 'order-info']);
        $builder->connect('/shops/purchase', ['controller' => 'Shops', 'action' => 'purchase']);

        $builder->connect('/shops/{action}/*', ['controller' => 'Shops']);


        /*
         * ...and connect the rest of 'Pages' controller's URLs.
         */
        $builder->connect('/pages/*', 'Pages::display');

        /*
         * Connect catchall routes for all controllers.
         *
         * The `fallbacks` method is a shortcut for
         *
         * ```
         * $builder->connect('/{controller}', ['action' => 'index']);
         * $builder->connect('/{controller}/{action}/*', []);
         * ```
         *
         * You can remove these routes once you've connected the
         * routes you want in your application.
         */
        $builder->fallbacks();
    });

    /*
     * If you need a different set of middleware or none at all,
     * open new scope and define routes there.
     *
     * ```
     * $routes->scope('/api', function (RouteBuilder $builder) {
     *     // No $builder->applyMiddleware() here.
     *
     *     // Parse specified extensions from URLs
     *     // $builder->setExtensions(['json', 'xml']);
     *
     *     // Connect API actions here.
     * });
     * ```
     */

    $routes->prefix('User', ['path' => 'User'], function(RouteBuilder $builder) {
        // $builder->connect('/login', ['controller' => UsersController::class, 'action' => 'login']);
        $builder->connect('/shops/{action}/*', ['controller' => 'Shops']);
    });

    // $routes->connect('login', ['controller' => 'Login', 'action' => 'login']);


    $routes->scope('/admin', ['prefix' => 'Admin'], function(RouteBuilder $builder) {
        $builder->applyMiddleware('Admin');
        $builder->connect('/', ['controller' => 'Profiles', 'action' => 'index']);
        $builder->connect('/list', ['controller' => 'Profiles', 'action' => 'list']);
        $builder->connect('/masters', ['controller' => 'Masters', 'action' => 'index']);
        $builder->connect('/categories', ['controller' => 'Categories', 'action' => 'index']);
        $builder->connect('/products', ['controller' => 'Products', 'action' => 'index']);
        $builder->connect('/orders', ['controller' => 'Orders', 'action' => 'index']);
        $builder->connect('/profiles', ['controller' => 'Profiles', 'action' => 'view']);
        $builder->connect('/masters/edit/{type}/{id}', ['controller' => 'Masters', 'action' => 'edit']);
        $builder->connect('/{controller}/{action}/*', ['controller' => 'Masters', 'action' => '*']);
        $builder->connect('/{controller}/{action}/*', ['controller' => 'Categories', 'action' => '*']);
        $builder->connect('/{controller}/{action}/*', ['controller' => 'Products', 'action' => '*']);
        $builder->connect('/{controller}/{action}/*', ['controller' => 'Orders', 'action' => '*']);

        $builder->scope('/inventory', ['prefix' => 'Admin'], function(RouteBuilder $builderInventory) {
            $builderInventory->connect('/', ['controller' => 'ProductInventories', 'action' => 'index']);
            $builderInventory->connect('/{action}/*', ['controller' => 'ProductInventories', 'action' => '*']);
        });
    });

    $routes->scope('/users', ['prefix' => 'Users'], function(RouteBuilder $builder) {
        $builder->connect('/', ['controller' => 'Profiles', 'action' => 'index']);
        $builder->connect('/add', ['controller' => 'Profiles', 'action' => 'add']);
        $builder->connect('/edit', ['controller' => 'Profiles', 'action' => 'edit']);
        // $builder->connect('/', ['controller' => 'Users', 'action' => 'index']);
        $builder->connect('/{action}/*', ['controller' => 'Profiles']);
    });


};
