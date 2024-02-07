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
    <?= $this->Html->script(['common', 'functions', 'moment'], ['block' => true]); ?>

    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header class="fixed-top">
        <nav class="navbar navbar-expand-lg bg-body-tertiary">
            <div class="container-fluid">
                <a class="navbar-brand" href="/shops">HOME</a>
                <!-- <button type="button" class="navbar-toggler" data-bs-toggle="collapse" data-bs-target="" aria-controls="" aria-expanded="false" aria-label="ナビゲーションの切替">
                <span class="navbar-toggler-icon"></span>
                </button> -->
                <?php if(!empty($auth)) { ?>
                <a href="/users" class="btn btn-outline-success flex-shrink-0 account-link"><i class="bi bi-person"></i></a>
                <?php } else { ?>
                <a href="/shops/login/" class="btn btn-outline-success flex-shrink-0 account-link"><i class="bi bi-person"></i></a>
                <?php } ?>
                <div class="collapse navbar-collapse" id="Navber">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <!-- <li class="nav-item">
                    <a class="nav-link active" aria-current="page" href="#">ホーム</a>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link" href="#">リンク</a>
                    </li>
                    <li class="nav-item dropdown">
                    <a href="#" class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        ドロップダウン
                    </a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">メニュー1</a></li>
                        <li><a class="dropdown-item" href="#">メニュー2</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item" href="#">その他</a></li>
                    </ul>
                    </li>
                    <li class="nav-item">
                    <a class="nav-link disabled" aria-disabled="true">無効</a>
                    </li> -->
                </ul>
                <!-- <form class="d-flex" role="search"> -->
                    <!-- <input type="search" class="form-control me-2" placeholder="検索..." aria-label="検索..."> -->
                    <!-- <button type="submit" class="btn btn-outline-success flex-shrink-0">LOGIN</button> -->
                    <!-- <?php if(!empty($auth)) { ?>
                    <a href="/users" class="btn btn-outline-success flex-shrink-0"><i class="bi bi-person"></i></a>
                    <?php } else { ?>
                    <a href="/shops/login/" class="btn btn-outline-success flex-shrink-0"><i class="bi bi-person"></i></a>
                    <?php } ?> -->

                <!-- </form> -->
                </div><!-- /.navbar-collapse -->
            </div><!-- /.container-fluid -->
        </nav>
        <?=$this->Form->create(null, ['url' => '/shops/cart-list']);?>
        <?= $this->Form->button(__('<i class="bi bi-cart3"></i>'.($cart_quantity ? '<span class="badge bg-danger rounded-circle cart-number">{0}</span>' : ''), $cart_quantity), [
            'id' => 'cart-item',
            'type' => 'submit',
            'class' => 'border-0 bg-transparent cart',
            'escapeTitle' => false,
        ]); ?>
        <?=$this->Form->end();?>
    </header>
    <main class="main">
        <div class="container">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer class="">
        <div class="text-center fs-8">
            AAAAA <br>
            大阪府吹田市
            <a href="tel:6031112298">6031112298</a> <br>
            Create by QUYENTB @<?=date('Y')?><br>

        </div>
    </footer>
</body>
</html>
