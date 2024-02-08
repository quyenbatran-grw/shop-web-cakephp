<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */

use App\Model\Entity\Order;

?>
<div class="users index content">
    <h3><?= __('Dash Board') ?></h3>

    <div>
        <div>New Orders</div>
        <div class="table-responsive">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="text-center">
                        <th><?= $this->Paginator->sort('id') ?></th>
                        <th><?= $this->Paginator->sort('order_number') ?></th>
                        <th><?= $this->Paginator->sort('created', 'Order Date') ?></th>
                        <th><?= $this->Paginator->sort('status') ?></th>
                        <th><?= $this->Paginator->sort('order_name') ?></th>
                        <th><?= $this->Paginator->sort('order_address') ?></th>
                        <th><?= $this->Paginator->sort('order_tel') ?></th>
                        <th><?= $this->Paginator->sort('order_amount') ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if(empty($orders)) { ?>
                    <tr>
                        <td colspan="9" class="text-center">No orders</td>
                    </tr>
                    <?php
                    } else {
                        foreach ($orders as $order) {
                    ?>
                    <tr>
                        <td>
                            <?=$this->Html->link($order->id, '/admin/orders/view/'.$order->id)?>
                        </td>
                        <td><?=$order->order_number?></td>
                        <td><?=$order->created->i18nFormat('Y/MM/dd')?></td>
                        <td class="text-center"><span class="<?=Order::$statusBackground[$order->status]?> ps-1 pe-1 text-white rounded"><?= $order->status_name ?></span></td>
                        <td><?= h($order->order_name) ?></td>
                        <td><?= h($order->order_address) ?></td>
                        <td><?= h($order->order_tel) ?></td>
                        <td class="text-end"><?= number_format($order->order_amount) ?></td>
                    </tr>
                    <?php
                        }
                    ?>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- <?php
    echo $this->Html->link('Add Master', 'admin/masters', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Categories', 'admin/categories', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Products', 'admin/products', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Inventories', 'admin/inventory', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Order', 'admin/orders', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage User', 'admin/list', [
        'class' => 'btn btn-primary'
    ]);
    ?> -->
</div>
