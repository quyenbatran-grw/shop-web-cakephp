<?php
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
 * @since     0.10.0
 * @license   https://opensource.org/licenses/mit-license.php MIT License
 * @var \App\View\AppView $this
 */
use Cake\Cache\Cache;
use Cake\Core\Configure;
use Cake\Core\Plugin;
use Cake\Datasource\ConnectionManager;
use Cake\Error\Debugger;
use Cake\Http\Exception\NotFoundException;

$this->disableAutoLayout();

// $checkConnection = function (string $name) {
//     $error = null;
//     $connected = false;
//     try {
//         $connection = ConnectionManager::get($name);
//         $connected = $connection->connect();
//     } catch (Exception $connectionError) {
//         $error = $connectionError->getMessage();
//         if (method_exists($connectionError, 'getAttributes')) {
//             $attributes = $connectionError->getAttributes();
//             if (isset($attributes['message'])) {
//                 $error .= '<br />' . $attributes['message'];
//             }
//         }
//     }

//     return compact('connected', 'error');
// };

// if (!Configure::read('debug')) :
//     throw new NotFoundException(
//         'Please replace templates/Pages/home.php with your own version or re-enable debug mode.'
//     );
// endif;

?>
<!DOCTYPE html>
<html>
<head>
    <?= $this->Html->charset() ?>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        CakePHP: the rapid development PHP framework:
        <?= $this->fetch('title') ?>
    </title>
    <?= $this->Html->meta('icon') ?>

    <link href="https://fonts.googleapis.com/css?family=Raleway:400,700" rel="stylesheet">

    <?= $this->Html->css(['cake', 'home', 'bootstrap.min']) ?>

    <?= $this->Html->script('bootstrap.min', ['block' => true]); ?>
    <?= $this->Html->script('common', ['block' => true]); ?>



    <?= $this->fetch('meta') ?>
    <?= $this->fetch('css') ?>
    <?= $this->fetch('script') ?>
</head>
<body>
    <header>
        <div class="container text-center ">
            <h1>
                Category Product List
            </h1>
            <img src="/img/cake-logo.png" alt="">
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div class="">

                <div class="row-sm row-cols-3">
                    <?php
                    if(empty($category)) {
                        echo 'Don\'t have any product';
                    } else {
                        $products = $category->products;
                        $image_url = '/img/noImage.svg';
                        foreach ($products as $key => $product) {
                            $image_product = null;
                            if(count($product->image_products)) {
                                $image_product = $product->image_products[0];
                                $image_url = '/img/products/'.$image_product['file_name'];
                            }

                    ?>
                    <div class="col-sm">
                        <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $category->id, $product->id], 'class' => ''])?>
                        <div class="card mb-3 fix-h-23">
                            <img src="<?=$image_url?>" class="w-100" alt="...">
                            <div class="card-body">
                                <h3 class="card-title fw-bold"><?=$product->name?></h3>
                                <p class="card-text fs-6"><?=nl2br(substr($product->description, 0, 60))?>...</p>
                                <!-- <p class="card-text"><small class="bg-danger text-white rounded p-2">New Arrival</small></p> -->
                            </div>
                        </div>
                        <?=$this->Form->end()?>
                    </div>
                    <?php
                        }
                    }
                    ?>
                </div>



            </div>
        </div>
    </main>

    <footer>
        <div class="text-center"><?=date('Y')?>@Copyright Created By QUYENTB</div>
    </footer>
<?= $this->Html->scriptStart(['block' => true]); ?>



<?= $this->Html->scriptEnd(); ?>

<?= $this->fetch('script'); ?>
<script>
    document.addEventListener
</script>
</body>
</html>
