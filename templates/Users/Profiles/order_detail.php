<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */

use App\Model\Entity\Order;
use App\Model\Table\OrdersTable;
use Cake\Chronos\Date;

?>
<div class="row">
    <aside class="column">

    </aside>
    <div class="column-responsive column-80">
        <div class="menu-link-list">
        <?=$this->Html->link(
            '<i class="bi bi-caret-left"></i>Back',
            ['controller' => 'Profiles', 'action' => 'order-list'],
            ['escape' => false, 'escapeTitle' => false]
        );?>
        </div>
        <div class="form content">
            <h4 class="heading fw-bold"><?= __('Order Detail') ?><span class="fs-5 w-50 text-center fw-bold ms-3 <?=Order::$statusBackground[$order->status]?> rounded text-white p-1"><?=$order->status_name?></span></h4>

            <div class="row">
                <div class="col col-md-2">Quantity</div>
                <div class="col col-md-2 text-end">
                    <?php
                    $quantity = 0;
                    foreach ($order->order_details as $order_detail) {
                        $quantity += $order_detail->quantity;
                    }
                    echo $quantity;
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="col col-md-2">Amount</div>
                <div class="col col-md-2 text-end"><?=number_format($order->order_amount + $order->payment_point)?></div>
            </div>

            <div class="row">
                <div class="col col-md-2">Discount</div>
                <div class="col col-md-2 text-end"><?=number_format(0 - $order->payment_point)?></div>
            </div>

            <div class="row border-top">
                <div class="col col-md-2">Total</div>
                <div class="col col-md-2 text-end"><?=number_format($order->order_amount)?></div>
            </div>

            <?php if($order->status != Order::CANCELED && $order->status != Order::DELIVERED) {?>
            <?=$this->Form->create(null, ['url' => ['controller' => 'Profiles', 'action' => 'order-cancel', $order->id]])?>
            <!-- <div class="row justify-content-end">
            <?=$this->Form->button('Cancel', [
                'type' => 'button',
                'class' => 'btn btn-primary w-33 confirm-delete'
            ])?>
            </div> -->

            <?=$this->element('modal', ['label' => 'Cancel', 'title' => 'Cancel Order', 'message' => 'Do you want to cancel this order?. Please click to [OK] else click to [Close]'])?>


            <?=$this->Form->end()?>
            <?php } ?>

            <div class="row justify-content-start mt-3">
                <div>
                    <?php
                    $image_url = '/img/noImage.svg';
                    foreach ($order->order_details as $order_detail) {
                        $status_name_bg = 'bg-danger';
                        $image_product = null;
                        // var_dump($order);
                        if(count($order_detail->product->image_products)) {
                            $image_product = $order_detail->product->image_products[0];
                            $image_url = '/img/products/'.$image_product['file_name'];
                        }
                        if($order_detail->status == Order::DELIVERING) $status_name_bg = 'bg-info';
                        else if($order_detail->status == Order::PAID) $status_name_bg = 'bg-warning';
                    ?>
                    <?=$this->Form->create($order, ['url' => ['../../shops/product/'.$order_detail->product->category_id.'/'.$order_detail->product->id], 'class' => ''])?>
                    <div class="card mb-3 g-0">
                        <div class="d-flex fix-h-8">
                            <div class="fix-w-6 fix-h-8"><img src="<?=$image_url?>" class="w-100 h-100" alt="..."></div>
                            <div class="ps-2 w-100">
                                <div class="fs-5"><?=__($order_detail->product->name)?></div>
                                <div class="fs-6">Quantity: <?=number_format($order_detail->quantity)?></div>
                                <div class="fs-6">Unit Price: <?=number_format($order_detail->unit_price)?></div>
                                <div class="fs-6">Amount: <?=number_format($order_detail->amount)?></div>
                                <div class="fs-7">Order Date: <?=$order->order_date?></div>
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
    </div>
</div>
