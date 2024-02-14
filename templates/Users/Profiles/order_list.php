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
            '<i class="bi bi-caret-left"></i>Quay Lại',
            ['controller' => 'Profiles', 'action' => 'index'],
            ['escape' => false, 'escapeTitle' => false, 'class' => 'text-decoration-none']
        );?>
        </div>
        <div class="form content">
            <?=$this->Form->create()?>
            <?=$this->Form->control('filter', [
                'class' => 'form-select w-50',
                'label' => false,
                'options' => OrdersTable::$filterTimes
            ])?>
            <?=$this->Form->end()?>
            <!-- <h4 class="heading fw-bold mt-2"><?= __('Order List') ?></h4> -->
            <?php if(count($new_orders)) { ?>
            <div class="row justify-content-start">
                <div class="fw-bold">Mới nhất</div>
                <div>
                    <?php
                    $image_url = '/img/noImage.svg';
                    foreach ($new_orders as $order) {
                        $status_name_bg = 'bg-danger';
                        $image_product = null;
                        if(count($order->order_details) && count($order->order_details[0]->product->image_products)) {
                            $image_product = $order->order_details[0]->product->image_products[0];
                            $image_url = '/img/products/'.$image_product['file_name'];
                        }
                        if($order->status == OrdersTable::DELIVERING) $status_name_bg = 'bg-info';
                        else if($order->status == OrdersTable::PAID) $status_name_bg = 'bg-warning';
                        $url = '/users/order-detail/' . $order->id;
                    ?>
                    <?=$this->Form->create($order, ['url' => $url, 'class' => ''])?>
                    <div class="card mb-3 g-0">
                        <div class="d-flex fix-h-8">
                            <div class="fix-w-6 fix-h-8"><img src="<?=$image_url?>" class="w-100 h-100" alt="..."></div>
                            <div class="p-2 w-100">
                                <h4 class="fs-5 w-75 text-center fw-bold <?=$status_name_bg?> rounded text-white p-1"><?=$order->status_name?></h4>
                                <div class="fs-5">SL: <?=number_format(count($order->order_details))?> Sản phẩm</div>
                                <div class="fs-5">Tổng: <?=number_format($order->order_amount)?></div>
                                <div class="fs-7">Ngày: <?=$order->order_date?></div>
                            </div>
                        </div>


                    </div>
                    <?=$this->Form->end()?>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php } ?>
            <?php if(count($old_orders)) { ?>
            <div class="row justify-content-start">
                <div class="fw-bold">Đơn đã xử lý</div>
                <div>
                    <?php
                    $image_url = '/img/noImage.svg';
                    foreach ($old_orders as $order) {
                        // var_dump($order);
                        $image_product = null;
                        $status_name_bg = 'bg-success';
                        if(count($order->order_details) && count($order->order_details[0]->product->image_products)) {
                            $image_product = $order->order_details[0]->product->image_products[0];
                            $image_url = '/img/products/'.$image_product['file_name'];
                        }
                        if($order->status == OrdersTable::CANCELED) $status_name_bg = 'bg-secondary';
                        $url = 'users/order-detail/' . $order->id;
                    ?>
                    <?=$this->Form->create($order, ['url' => $url, 'class' => ''])?>
                    <div class="card mb-3 g-0">
                        <div class="d-flex fix-h-8">
                            <div class="fix-w-6 fix-h-8"><img src="<?=$image_url?>" class="w-100 h-100" alt="..."></div>
                            <div class="p-2 w-100">
                                <h4 class="fs-5 w-75 text-center fw-bold <?=$status_name_bg?> rounded text-white p-1"><?=$order->status_name?></h4>
                                <div class="fs-5">SL: <?=number_format(count($order->order_details))?> Sản phẩm</div>
                                <div class="fs-5">Tổng: <?=number_format($order->order_amount)?></div>
                                <div class="fs-7">Ngày: <?=$order->order_date?></div>
                            </div>
                        </div>


                    </div>
                    <?=$this->Form->end()?>
                    <?php
                    }
                    ?>
                </div>
            </div>
            <?php } ?>
            <?php if(count($new_orders) == 0 && count($old_orders) == 0) { ?>
            <h2 class="mt-4 text-center fw-bold"><?=__(MSG_0010)?></h2>
            <?php } ?>
        </div>
    </div>
</div>
