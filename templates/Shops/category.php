<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Category',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false]
);?>
</div>
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
