<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Categories',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false]
);?>
<?=$this->Html->link(
    '<i class="bi bi-chevron-left fs-6"></i>Product List',
    ['controller' => 'Shops', 'action' => 'category', 'id' => 1],
    ['escape' => false, 'escapeTitle' => false, 'class' => '']
);?>
</div>

<div class="content produc-detail mt-3">
    <?php
    ?>

    <div class="row">
        <?php
        if(empty($product)) {
            echo 'Don\'t have product';
        } else {
            $image_products = $product->image_products;

        ?>
        <h2 class="fw-bold"><?=$product->name?></h2>
        <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="false" data-bs-interval="false">
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0" class="active rounded-circle" aria-current="true" aria-label="Slide 1"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1" aria-label="Slide 2"></button>
                <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2" aria-label="Slide 3"></button>
            </div>
            <button type="button" class="carousel-control-prev" data-bs-target="#carouselExampleCaptions" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">前へ</span>
            </button>
            <button type="button" class="carousel-control-next" data-bs-target="#carouselExampleCaptions" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">次へ</span>
            </button>
            <div class="carousel-inner">
                <?php
                $image_url = '/img/noImage.svg';
                if(count($image_products)) {
                    foreach ($image_products as $key => $image_product) {
                        if(!empty($image_product) && !empty($image_product['file_name'])) $image_url = '/img/products/'.$image_product['file_name'];
                ?>
                <div class="carousel-item h-100 <?=$key ? '' : 'active'?>">
                <img src="<?=$image_url?>" class="d-block w-100 h-100" alt="...">
                </div>
                <?php
                    }
                } else {
                ?>
                <div class="carousel-item h-100 active">
                <img src="<?=$image_url?>" class="d-block w-100 h-100" alt="...">
                </div>
                <?php
                }
                ?>

            </div>

        </div>

        <div class="fw-bold">Price: <?=$product->product_inventories[0]->price;?></div>
        <div class="fw-bold fs-5">Description</div>

        <div class="fs-6">
            <?=nl2br($product->description)?>
        </div>

        <hr>

        <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $product->category_id, $product->id]])?>
        <div class="add-cart-group d-flex mt-3" role="group" aria-label="Basic example">
            <!-- <div>Quantity</div> -->

            <div class="w-25">
                <?=$this->Form->control('quantity', [
                    'type' => 'select',
                    'label' => 'Quantity',
                    'class' => 'form-control text-center ms-2',
                    'options' => $stock_quantity
                ])?>
            </div>


            <?= $this->Form->button('<i class="bi bi-cart3"></i>Add To Card', [
                'type' => 'submit',
                'class' => 'btn btn-primary ms-4 mt-4',
                'escapeTitle' => false,
            ]); ?>
        </div>
        <?=$this->Form->end();?>
        <?php } ?>

        <div class="mt-2">Relative Products</div>
        <table class="table table-responsive">
            <tr>
                <?php foreach ($other_products as $other_product) {
                    $product_images = $other_product->image_products;
                    $image_url = '/img/noImage.svg';
                    $className = 'fix-h-15';
                    if(count($product_images)) {
                        $product_image = $product_images[0];
                        $image_url = '/img/products/'.$product_images[0]['file_name'];
                    }

                ?>
                <td>
                    <?= $this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $other_product->category_id, $other_product->id], 'class' => ''])?>
                    <button class="btn text-start">
                    <div class="fix-w-12">
                        <div class="fix-h-15"><img src="<?=$image_url?>" class="fix-h-15 fix-w-12 rounded" alt="..."></div>
                        <div class="fix-h-6">
                            <div class="fs-5"><?=$other_product->name?></div>
                            <div class="fs-5"><?=isset($other_product->product_inventories[0]) ? $other_product->product_inventories[0]->price : '';?></div>
                        </div>
                    </div>
                    </button>
                    <?=$this->Form->end();?>
                </td>
                <?php } ?>
            </tr>
        </table>

    </div>
</div>
