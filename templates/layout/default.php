<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         0.10.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */

$cakeDescription = 'CakePHP';
?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $cakeDescription ?>:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.0/font/bootstrap-icons.css" rel="stylesheet">

    <?= $this->Html->css(['cake', 'home', 'bootstrap.min']) ?>
    <?= $this->Html->script('bootstrap.min', ['block' => true]); ?>
    <?= $this->Html->script('common', ['block' => true]); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header class="fixed-top <?=!$auth || !$auth->role ? 'd-none' : ''?>">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/admin">HOME</a>
                <?php if(!empty($auth)) { ?>
                <a href="/admin/profiles" class="btn btn-outline-success flex-shrink-0 account-link"><i class="bi bi-person"></i></a>
                <?php } else { ?>
                <a href="/shops/login/" class="btn btn-outline-success flex-shrink-0 account-link"><i class="bi bi-person"></i></a>
                <?php } ?>
            </div><!-- /.container-fluid -->
        </nav>
    </header>
    <main class="main">
        <?php if(!empty($auth)) { ?>
        <div class="side-left text-start">
            <ul class="side-left-menu list-group list-group-flush">
                <li class="list-group-item " aria-current="true"><a href="/admin" class="link-primary text-decoration-none">Dashboard</a></li>
                <li class="list-group-item categories"><a href="/admin/categories" class="link-primary text-decoration-none">Categories</a></li>
                <li class="list-group-item products"><a href="/admin/products" class="link-primary text-decoration-none">Products</a></li>
                <li class="list-group-item inventory"><a href="/admin/inventory" class="link-primary text-decoration-none">Stocks</a></li>
                <li class="list-group-item orders"><a href="/admin/orders" class="link-primary text-decoration-none">Orders</a></li>
                <li class="list-group-item profiles"><a href="/admin/list" class="link-primary text-decoration-none">Users</a></li>
            </ul>
        </div>
        <div class="container admin">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <?php } else { ?>

        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
        <?php } ?>
    </main>
    <footer class="">
        <div class="text-center fs-8">
            Copyright <?=date('Y')?><br>
            Create by QUYENTB
        </div>
    </footer>
</body>
</html>
