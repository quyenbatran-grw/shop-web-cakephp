<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Quay Lại',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false, 'class' => 'text-decoration-none']
);?>
</div>
<div class="">


    <!-- <div class="row"> -->
        <?php
        if(empty($products)) {
            echo 'Don\'t have any product';
        } else {
            // $products = $category->products;
            // var_dump($products);
            $image_url = '/img/noImage.svg';
            foreach ($products as $key => $product) {
                if(empty($product)) continue;
                $product_inventory = isset($product->product_inventories[0]) ? $product->product_inventories[0] : null;
                $image_product = null;
                if(count($product->image_products)) {
                    $image_product = $product->image_products[0];
                    $image_url = '/img/products/'.$image_product['file_name'];
                }
                $isStock = $product->quantity > 0 ?? false;
                // if(!isset($quantity_stocks[$product->id]) || $quantity_stocks[$product->id] <= 0) $isStock = false;

        ?>
        <div class="">
            <?=$isStock ? $this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'product', $product->category_id, $product->id], 'class' => '']) : ''?>
            <div class="card mb-3 g-0">
                <div class="d-flex fix-h-11">
                    <div class="fix-w-6 my-auto"><img src="<?=$image_url?>" class="w-100" alt="..."></div>
                    <div class="p-2">
                        <div class="text-wrap">
                            <h4 class="card-title fw-bold"><?=$product->name?> </h4>
                            <div class="text-danger fs-5"><?=$isStock ? $product->sell_price_f : 'Sold Out'?></div>
                            <div class="fw-bold fs-5">Detail</div>
                            <p class="card-text fs-6 ps-2 text-truncate"><?=nl2br(substr($product->description, 0, 60)) . (strlen($product->description) > 60 ? ' ...' : '')?></p>

                        </div>
                    </div>
                </div>


            </div>
            <?=$isStock ? $this->Form->end() : ''?>
        </div>
        <?php
            }
        }
        ?>
    <!-- </div> -->

    <?php if($this->Paginator->param('pageCount') > 1) { ?>
    <div class="row">
    <div class="paginator col col-md-8">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ') ?>
            <?= $this->Paginator->current() > 1 ? $this->Paginator->prev($this->Paginator->current() - 1) : '' ?>
            <li class="page-item active"><a class="page-link" href="?page=<?= $this->Paginator->current() ?>"><?= $this->Paginator->current() ?></a></li>
            <?= $this->Paginator->current() < $this->Paginator->param('pageCount') ? $this->Paginator->next($this->Paginator->current() + 1) : '' ?>
            <?= $this->Paginator->last(' >>') ?>
        </ul>
    </div>
    </div>
    <?php } ?>
</div>
