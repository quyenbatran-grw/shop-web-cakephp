
<div class="content">
    <div class="mb-3 fs-7"><?=__(MSG_0007)?></div>

    <div class="">
        <?php

                            use App\Model\Table\OrdersTable;
                            use Cake\I18n\FrozenDate;

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
                // if(!empty($product_inventory)) {
                    $price = $product->sell_price_f;
                    $amount = $product->sell_price * $product->quantity;
                // }

                $total_amount += $amount;
        ?>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight">
                <img src="<?=$image_url?>" style="width: 100px" alt="">
            </div>
            <div class="p-2 bd-highlight w-100 fs-5">
                <h2><?=$product->name?></h2>
                <div class="row">
                    <div class="col fw-bold">Giá</div>
                    <div class="col text-end"><?=$price?></div>
                </div>

                <div class="row">
                    <div class="col fw-bold">SL</div>
                    <div class="col text-end"><?=number_format($product->quantity)?></div>
                </div>
                <hr>
                <div class="row">
                    <div class="col fw-bold"></div>
                    <div class="col text-end"><?=number_format($amount)?>đ</div>
                </div>

            </div>

        </div>
        <?php
            }
        ?>

        <?=$this->Form->create($order, ['url' => ['controller' => 'Shops', 'action' => 'purchase']]);?>
        <hr>
        <div class="row">
            <div class="p-2 bd-highlight fw-bold">Phương thức thanh toán</div>
        </div>
        <div class="row">
            <div class="input radio">
                <div class="">
                <?=$this->Form->radio('payment',
                    OrdersTable::$paymentTypes,
                    ['class' => 'form-check-input ms-4', 'value' => 0, 'onchange' => 'changePaymentType(this)', 'hiddenField' => false]
                );?>
                </div>
            </div>
            <div class="banking-qr-code d-none">
                <div>Sau khi hoàn thành đặt hàng, làm ơn quét mã QR để thực hiện thanh toán.</div>
                <!-- <img src="/img/noImage.svg" class="d-block w-100 fix-img-size" alt=""> -->
            </div>
            <div class="cash-payment ms-4"><?=__(MSG_0006)?></div>
        </div>
        <hr>
        <div class="row">
            <div class="p-2 bd-highlight fw-bold">Thanh toán bằng điểm</div>
        </div>
        <div class="row">
            <div class="input radio">
                <div class="">
                <?=$this->Form->radio('point_type',
                    ['Một Phần', 'Toàn bộ ('.$customer['point'].' điểm)'],
                    ['class' => 'form-check-input ms-4', 'value' => 0, 'onchange' => 'changePaymentPoint(this)', 'hiddenField' => false]
                );?>
                <?=$this->Form->control('payment_point', [
                    'type' => 'number',
                    'min' => 0,
                    'max' => $customer['point'],
                    'class' => 'form-control w-50 ms-4 mt-2',
                    'label' => false,
                    'onchange' => 'changePaymentPoint(this)'
                ])?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="p-2 bd-highlight fw-bold">Phương thức giao hàng</div>
        </div>
        <div class="row">
            <div class="input radio">
                <div class="">
                <?=$this->Form->radio('delivery_type',
                    OrdersTable::$deliveryTypes,
                    ['class' => 'form-check-input ms-4', 'value' => 0, 'hiddenField' => false]
                );?>
                </div>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="p-2 bd-highlight fw-bold">Thời gian nhận hàng</div>
        </div>
        <div class="row">
            <div class="input radio">
                <div class="">
                <?=$this->Form->control('immediate', [
                    'type' => 'checkbox',
                    'class' => 'form-check',
                    'hiddenField' => false,
                    'label' => 'Giao gấp',
                ]);?>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="input radio">
                <div class="">
                <?=$this->Form->date('delivery_date', [
                    'class' => 'form-control',
                    'label' => false,
                    'minYear' => '2025/01/01'
                ]);?>
                </div>
            </div>
        </div>
        <div class="row mt-2">
            <div class="d-flex">
                <div class="w-50 pe-2">
                <?=$this->Form->control('delivery_hour_start', [
                    'class' => 'form-control text-center',
                    'label' => false,
                    'type' => 'select',
                    'options' => $hours,
                    'disabled' => $disable_hours
                ]);?>
                </div>
                ～
                <div class="w-50 ps-2">
                <?=$this->Form->control('delivery_hour_end', [
                    'class' => 'form-control text-center',
                    'label' => false,
                    'type' => 'select',
                    'options' => $hours,
                    'disabled' => $disable_hours
                ]);?>
                </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex flex-row">
            <div class="ps-2 bd-highlight fw-bold">Tổng</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end amount"><?=number_format($total_amount)?>đ</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="ps-2 bd-highlight fw-bold">VAT(10%)</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end">0</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row">
            <div class="ps-2 bd-highlight fw-bold">Phí</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end">0</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row pay-with-point">
            <div class="ps-2 bd-highlight fw-bold">KM</div>
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end point">0</div>
                </div>
            </div>
        </div>
        <hr>
        <div class="d-flex flex-row">
            <!-- <div class="ps-2 bd-highlight fw-bold">Tổng HĐ</div> -->
            <div class="pe-2 bd-highlight w-100">
                <div class="row">
                    <div class="col"></div>
                    <div class="col text-end total_amount"><?=number_format($total_amount)?>đ</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-row bd-highlight mb-3">
            <div class="p-2 bd-highlight w-100 fs-5">
                <div class="row">
                    <div class="col fw-bold fs-6">Tên</div>
                    <div class="col text-end fs-6"><?=$customer['full_name']?></div>
                </div>

                <div class="row">
                    <div class="col fw-bold fs-6">Địa chỉ</div>
                    <div class="col text-end fs-6"><?=$customer['address']?></div>
                </div>
                <div class="row">
                    <div class="col fw-bold fs-6">SĐT</div>
                    <div class="col text-end fs-6"><?=$customer['tel']?></div>
                </div>
                <div class="row">
                    <div class="col fw-bold fs-6">Ghi chú</div>
                    <div class="col text-end fs-6"><?=$customer['memo']?></div>
                </div>

            </div>

        </div>


        <div class="d-flex flex-row justify-content-center mt-4">
            <div class="w-100">
                <!-- <div class="mb-3">
                    <div class="input radio">
                        <?=__(MSG_0005)?>
                        <div class="d-flex">
                        <?=$this->Form->radio('payment',
                            OrdersTable::$paymentTypes,
                            ['class' => 'form-check-input ms-4', 'value' => 0, 'onchange' => 'changePaymentType(this)']
                        );?>
                        </div>
                    </div>
                    <div class="banking-qr-code d-none">
                        <img src="/img/noImage.svg" class="d-block w-100 fix-img-size" alt="">
                    </div>
                    <div class="cash-payment ms-4"><?=__(MSG_0006)?></div>
                </div> -->
                <div class="row justify-content-around mt-5">
                <?= $this->Html->link(__('Quay lại'), ['controller' => 'Shops', 'action' => 'cart_confirm'], ['class' => 'btn btn-secondary col-4']) ?>
                <?=$this->Form->button('Đặt Hàng', [
                    'class' => 'btn btn-primary col-4'
                ]);?>
                </div>
            </div>
        </div>
                <?=$this->Form->end();?>
        <?php
        }
        ?>

    </div>




</div>
