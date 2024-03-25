<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Quay Lại',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false, 'class' => 'text-decoration-none']
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
            <?=$this->Html->link('Tiếp tục mua hàng', ['controller' => 'Pages', 'action' => 'display'],
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
                // if(!empty($product_inventory)) {
                    $amount = $product->sell_price * $product->quantity;
                    $price = $product->sell_price_f;
                // }
                $total_amount += $amount;
        ?>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <img src="<?=$image_url?>" style="width: 100px" alt="">
            </div>
            <div class="p-2 bd-highlight w-100">
                <h3><?=$product->name?></h3>
                <div class="row">
                    <div class="col fs-5">Giá</div>
                    <div class="col fs-5 text-end"><?=$price?></div>
                </div>

                <div class="row">
                    <div class="col fs-5">SL</div>
                    <div class="col">
                    <?=$this->Form->create($product, ['url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                    <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                    <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                    <?=$this->Form->control('quantity['.$product->id.']', [
                        'type' => 'select',
                        'label' => false,
                        'class' => 'form-control text-center ms-2 w-75 float-end change-quantity',
                        'value' => $product->quantity,
                        'options' => $product->quantity_stocks,
                    ])?>
                    <?=$this->Form->end();?>
                    </div>
                </div>
                <hr>
                <div class="row">
                    <div class="col">Tiền</div>
                    <div class="col text-end"><?=number_format($amount)?>đ</div>
                </div>
                <div class="row">
                    <?=$this->Form->create($product, ['type' => 'delete', 'url' => ['controller' => 'Shops', 'action' => 'cart-list']]);?>
                    <?=$this->Form->hidden('category_id', ['value' => $product->category_id]);?>
                    <?=$this->Form->hidden('product_id', ['value' => $product->id]);?>
                    <?=$this->Form->button('Xóa', [
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
            <div class="ps-2 bd-highlight fs-5">Tổng tiền</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end"><?=number_format($total_amount)?>đ</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="ps-2 bd-highlight fs-5">VAT(10%)</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end fs-5">0</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="ps-2 bd-highlight fs-5">Tổng hóa đơn</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end"><?=number_format($total_amount)?>đ</div>
                </div>
            </div>
        </div>
        <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'cart-confirm']]);?>
        <div class="row justify-content-around mt-5">
            <?= $this->Html->link(__('Quay lại'), ['action' => '/'], ['class' => 'btn btn-secondary col-3']) ?>
            <?= $this->Form->button('Tiếp tục', ['type' => 'submit', 'class' => 'btn btn-primary col-3 ' . ($total_amount == 0 ? 'disabled' : '')]); ?>
        </div>
        <?= $this->Form->end() ?>
        <?php
        }
        ?>
    </div>






</div>
