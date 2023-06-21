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
        if(empty($products)) {
            echo 'Don\'t have any product';
        } else {
            // $products = $category->products;
            // var_dump($products);
            $image_url = '/img/noImage.svg';
            foreach ($products as $key => $product) {
                if(empty($product)) continue;
                $product_inventory = $product->product_inventories[0];
                $image_product = null;
                if(count($product->image_products)) {
                    $image_product = $product->image_products[0];
                    $image_url = '/img/products/'.$image_product['file_name'];
                }
                $isStock = true;
                if(!isset($quantity_stocks[$product->id]) || $quantity_stocks[$product->id] <= 0) $isStock = false;

        ?>
        <div class="col-sm fix-wp-33">
            <?=$isStock ? $this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $product->category_id, $product->id], 'class' => '']) : ''?>
            <div class="card mb-3 fix-h-23">
                <img src="<?=$image_url?>" class="w-100 fix-h-10" alt="...">
                <div class="card-body text-truncate">
                    <h3 class="card-title fw-bold"><?=$product->name?> <span class="text-danger fs-6"><?=$product_inventory->price_k?>K</span></h3>
                    <p class="card-text fs-6"><?=nl2br(substr($product->description, 0, 60))?>...</p>
                    <!-- <p class="card-text"><small class="bg-danger text-white rounded p-2">New Arrival</small></p> -->
                </div>
            </div>
            <?=$isStock ? $this->Form->end() : ''?>
        </div>
        <?php
            }
        }
        ?>
    </div>



</div>
