
<div class="content">
    <div class="mb-3"><?=__(MSG_0007)?></div>

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
                    <div class="col fw-bold">Price</div>
                    <div class="col text-end"><?=$price?></div>
                </div>

                <div class="row">
                    <div class="col fw-bold">Quantity</div>
                    <div class="col text-end"><?=number_format($product->quantity)?></div>
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
                    <div class="col text-end"><?=$customer['name']?></div>
                </div>

                <div class="row">
                    <div class="col fw-bold">Contact Address</div>
                    <div class="col text-end"><?=$customer['address']?></div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Tel</div>
                    <div class="col text-end"><?=$customer['tel']?></div>
                </div>
                <div class="row">
                    <div class="col fw-bold">Descriptions</div>
                    <div class="col text-end"><?=$customer['memo']?></div>
                </div>

            </div>

        </div>


        <div class="d-flex flex-row justify-content-center mt-4">
            <div class="w-100">
                <?=$this->Form->create($order, ['url' => ['controller' => 'Shops', 'action' => 'purchase']]);?>
                <div class="mb-3">
                    <div class="input radio">
                        <?=__(MSG_0005)?>
                        <div class="d-flex">
                        <?=$this->Form->radio('payment',
                            [1 => 'Cash', 2 => 'Banking'],
                            ['class' => 'form-check-input ms-4', 'value' => 1, 'onchange' => 'changePaymentType(this)']
                        );?>
                        </div>
                    </div>
                    <div class="banking-qr-code d-none">
                        <img src="/img/noImage.svg" class="d-block w-100 fix-img-size" alt="">
                    </div>
                    <div class="cash-payment ms-4"><?=__(MSG_0006)?></div>
                </div>
                <div class="justify-content-center d-flex mt-5">
                <?=$this->Html->link('Back', '#',
                [
                    'onclick' => 'history.back()',
                    'class' => 'btn btn-primary me-4 w-33',
                ]);?>
                <?=$this->Form->button('Order', [
                    'class' => 'btn btn-primary w-33'
                ]);?>
                </div>
                <?=$this->Form->end();?>
            </div>
        </div>
        <?php
        }
        ?>

    </div>




</div>
