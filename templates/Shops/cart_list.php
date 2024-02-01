<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Category',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false]
);?>
</div>
<div class="content cart-list">
    <?php
    ?>

    <div class="">
        <?php
        $total_amount = 0;
        if(empty($products)) {
            echo 'Don\'t have product';
        ?>
        <div class="d-flex flex-row justify-content-center">
            <div class="row">
            <?=$this->Html->link('Shopping Continue', ['controller' => 'Pages', 'action' => 'display'],
            [
                'class' => 'mt-3',
            ]);?>
            </div>
        </div>
        <?php
        } else {
            foreach ($products as $product) {
                $image_products = $product->image_products;
                $image_url = '/img/noImage.svg';
                if(count($product->image_products)) {
                    $image_product = $product->image_products[0];
                    $image_url = '/img/products/'.$image_product['file_name'];
                }
                $amount = 0;
                $price = 0;
                $product_inventory = $product->product_inventory;
                if(!empty($product_inventory)) {
                    $amount = $product_inventory->unit_price * $product->quantity;
                    $price = $product_inventory->price;
                }
                $total_amount += $amount;
        ?>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <img src="<?=$image_url?>" style="width: 100px" alt="">
            </div>
            <div class="p-2 bd-highlight w-100">
                <h2><?=$product->name?></h2>
                <div class="row">
                    <div class="col">Price</div>
                    <div class="col text-end"><?=$price?></div>
                </div>

                <div class="row">
                    <div class="col">Quantity</div>
                    <div class="col">
                    <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                    <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                    <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                    <?=$this->Form->control('quantity', [
                        'type' => 'select',
                        'label' => false,
                        'class' => 'form-control text-center ms-2 w-75 float-end',
                        'options' => $product->quantity_stocks,
                    ])?>
                    <?=$this->Form->end();?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">Amount</div>
                    <div class="col text-end"><?=number_format($amount)?></div>
                </div>
                <div class="row">
                    <?=$this->Form->create($product, ['type' => 'delete', 'url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                    <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                    <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                    <?=$this->Form->button('Remove', [
                        'type' => 'submit',
                        'label' => false,
                        'class' => 'btn btn-link text-center float-end',
                    ])?>
                    <?=$this->Form->end();?>

                </div>
            </div>

        </div>






        <?php
            }
        ?>
        <hr>
        <div class="d-flex flex-row">
            <div class="p-2 bd-highlight">
                    Total
            </div>
            <div class="p-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end"><?=number_format($total_amount)?></div>
                </div>
            </div>
        </div>
        <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'cart-confirm']]);?>
        <div class="row justify-content-around mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button('Next', ['type' => 'submit', 'class' => 'btn btn-primary col-3']); ?>
        </div>
        <?= $this->Form->end() ?>
        <?php
        }
        ?>
    </div>






</div>
