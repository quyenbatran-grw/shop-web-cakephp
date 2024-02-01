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
        <nav class="top-nav">
            <!-- <div class="top-nav-title">
                <a href="<?= $this->Url->build('/admin') ?>"><span>Cake</span>PHP</a>
            </div> -->
            <div class="top-nav-links">
                <?php if($auth && $auth->role) { ?>
                <a rel="noopener" href="<?= $this->Url->build('/admin') ?>">HOME</a>
                <?php } else if($auth && !$auth->role) { ?>
                <!-- <a rel="noopener" href="<?= $this->Url->build('/shops') ?>">HOME</a> -->
                <?php } ?>
                <!-- <a target="_blank" rel="noopener" href="https://api.cakephp.org/">API</a> -->
            </div>
        </nav>
    </header>
    <main class="main">
        <div class="container max-wp-90">
            <?= $this->Flash->render() ?>
            <?= $this->fetch('content') ?>
        </div>
    </main>
    <footer class="">
        <div class="text-center fs-8">
            Copyright <?=date('Y')?><br>
            Create by QUYENTB
        </div>
    </footer>
</body>
</html>
