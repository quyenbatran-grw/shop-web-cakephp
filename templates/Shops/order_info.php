
<div class="content">
    <div class="mb-3">There are your shopping cart information. If don't have any mistake, you can press to Order button to finish. Otherwise please press to Back button</div>

    <div class="">
        <?php
        $total_amount = 0;
        if(empty($products)) {
            echo 'Don\'t have product';
        } else {
            foreach ($products as $product) {
                $image_products = $product->image_products;
                $image_url = '/img/noImage.svg';
                if(count($product->image_products)) {
                    $image_product = $product->image_products[0];
                    $image_url = '/img/products/'.$image_product['file_name'];
                }
                $amount = $product->unit_price * $product->quantity;
                $total_amount += $amount;
        ?>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <img src="<?=$image_url?>" style="width: 100px" alt="">
            </div>
            <div class="p-2 bd-highlight w-100">
                <h2><?=$product->name?></h2>
                <div class="row">
                    <div class="col fw-bold">Price</div>
                    <div class="col text-end"><?=$product->price?></div>
                </div>

                <div class="row">
                    <div class="col fw-bold">Quantity</div>
                    <div class="col text-end"><?=$product->quantity_format?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col fw-bold">Amount</div>
                    <div class="col text-end"><?=number_format($amount)?></div>
                </div>

            </div>

        </div>
        <?php
            }
        ?>
        <hr>
        <div class="d-flex flex-row">
            <div class="p-2 bd-highlight fw-bold">Total</div>
            <div class="p-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end"><?=number_format($total_amount)?></div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight w-100 fs-5">
                <div class="row">
                    <div class="col fw-bold">Contact Name</div>
                    <div class="col text-end">AAA</div>
                </div>

                <div class="row">
                    <div class="col fw-bold">Contact Address</div>
                    <div class="col text-end">CCCC</div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Tel</div>
                    <div class="col text-end">VVVV</div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Descriptions</div>
                    <div class="col text-end">VVVV</div>
                </div>

            </div>

        </div>

        <div class="d-flex flex-row justify-content-center">
            <div class="row">
                <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'purchase']]);?>
                <?=$this->Html->link('Back', '#',
                [
                    'onclick' => 'history.back()',
                    'class' => 'btn btn-primary m-1',
                ]);?>
                <?=$this->Form->button('Order', [
                    'class' => 'btn btn-primary'
                ]);?>
                <?=$this->Form->end();?>
            </div>
        </div>
        <?php
        }
        ?>

    </div>




</div>
