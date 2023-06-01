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

    <?= $this->Html->css(['normalize.min', 'milligram.min', 'cake', 'home', 'bootstrap.min']) ?>

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
                Welcome to CakePHP <?= h(Configure::version()) ?> Strawberry (🍓)
            </h1>
            <img src="/img/cake-logo.png" alt="">
        </div>
    </header>
    <main class="main">
        <div class="container">
            <div id="carouselExampleControls" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <?php
                    $image_url = '';
                    foreach ($image_products as $key => $image_product) {
                        $image_url = '/img/products/'.$image_product['file_name'];
                    ?>
                    <div class="carousel-item <?=$key ? '' : 'active'?>">
                    <img src="<?=$image_url?>" class="d-block w-100 fix-img-size" alt="...">
                    </div>
                    <?php
                    }
                    ?>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleControls" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
                </div>
            </div>
            <div class="content">
                <div class="row-sm">
                    <?php
                    $image_url = '';
                    foreach ($categories as $key => $category) {
                        if(empty($category)) continue;
                        $image_product = null;
                        foreach ($category->products as $product) {
                            if(count($product->image_products)) {
                                $image_product = $product->image_products[0];
                                break;
                            }
                        }
                        $image_url = '/img/products/'.$image_product['file_name'];
                    ?>
                    <?=$this->Form->create($category->products, ['url' => ['controller' => 'Shops', 'action' => 'index', 'id' => $category->id]])?>
                        <div class="card mb-3 category-card">
                            <div class="row-sm g-0">
                                <div class="col-md-2">
                                <img src="<?=$image_url?>" class="fix-img-size" alt="...">
                                </div>
                                <div class="col-md-8">
                                <div class="card-body">
                                    <h2 class="card-title fw-bold"><?=$category->name?></h2>
                                    <p class="card-text"><?=$category->description?></p>
                                    <p class="card-text"><small class="bg-danger text-white rounded p-2">New Arrival</small></p>
                                </div>
                                </div>
                            </div>
                        </div>
                    <?=$this->Form->end()?>
                    <?php
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
