<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Order> $orders
 */

use App\Model\Entity\Order;
use App\Model\Table\OrdersTable;

?>
<div class="orders index content">
    <!-- <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'button float-right']) ?> -->
    <!-- <h3><?= __('Orders') ?></h3> -->
    <?=$this->Form->create()?>
    <div class="row border-bottom pb-2">
        <div class="col col-md-2">Order Number</div>
        <div class="col col-md-2">
            <?=$this->Form->control('order_number', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => '2401010001',
                'value' => isset($searchParam['order_number']) ? $searchParam['order_number'] : ''
            ])?>
        </div>

        <div class="col col-md-2 text-end">Order Date</div>
        <div class="col col-md-4 d-flex">
            <?=$this->Form->date('start_date', [
                'class' => 'form-control',
                'lable' => false,
                'value' => isset($searchParam['start_date']) ? $searchParam['start_date'] : ''
            ])?>
            <span class="ps-2 pe-2">～</span>
            <?=$this->Form->date('end_date', [
                'class' => 'form-control',
                'lable' => false,
                'value' => isset($searchParam['end_date']) ? $searchParam['end_date'] : ''
            ])?>
        </div>
    </div>

    <div class="row pt-2">
        <div class="col col-md-2">Status</div>
        <div class="col col-md-2">
            <?php
            $statusList = ['ALL'];
            $statusList += Order::$statusList;
            ?>
            <?=$this->Form->control('status', [
                'type' => 'select',
                'class' => 'form-select',
                'label' => false,
                'options' => $statusList,
                'value' => isset($searchParam['status']) ? $searchParam['status'] : 0
            ])?>
        </div>

        <div class="col col-md-2 text-end">Immediation</div>
        <div class="col col-md-3">
            <?=$this->Form->radio('immediate', [2 => 'All', 1 => 'Yes', 0 => 'No'], [
                'class' => 'form-check-input ms-4',
                'hiddenField' => false,
                'value' => isset($searchParam['immediate']) ? $searchParam['immediate'] : 2
            ])?>
        </div>
    </div>

    <div class="row justify-content-center mt-4 border-bottom pb-4">
        <div class="col col-md-2">
            <?=$this->Form->button('<i class="bi bi-search"></i> Search', [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('<i class="bi bi-x-circle"></i> Clear', ['action' => ''], [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
    </div>
    <?=$this->Form->end()?>
    <div class="table-responsive">
        <span class="text-danger fs-5">(*) is immediated order</span>
        <table class="table table-striped table-hover table-bordered fix-header">
            <thead class="sticky-top">
                <tr class="text-center">
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('order_number') ?></th>
                    <th><?= $this->Paginator->sort('created', 'Order Date') ?></th>
                    <th><?= $this->Paginator->sort('status') ?></th>
                    <th><?= $this->Paginator->sort('order_name') ?></th>
                    <th><?= $this->Paginator->sort('order_address') ?></th>
                    <th><?= $this->Paginator->sort('order_tel') ?></th>
                    <th><?= $this->Paginator->sort('order_amount') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($orders as $order): ?>
                <tr class="">
                    <td>
                        <?= $this->Number->format($order->id) ?>
                        <?php if($order->immediate && $order->status != Order::CANCELED && $order->status != Order::DELIVERED) { ?>
                        <span class="text-danger">*</span>
                        <?php } ?>
                    </td>
                    <td><?= h($order->order_number) ?></td>
                    <td><?= h($order->created->i18nFormat('Y/MM/dd HH:mm')) ?></td>
                    <td class="text-center"><span class="<?=Order::$statusBackground[$order->status]?> ps-1 pe-1 text-white rounded"><?= $order->status_name ?></span></td>
                    <td><?= h($order->order_name) ?></td>
                    <td><?= h($order->order_address) ?></td>
                    <td><?= h($order->order_tel) ?></td>
                    <td class="text-end"><?= number_format($order->order_amount) ?></td>
                    <td class="actions text-center">
                        <?= $this->Html->link(__('<i class="bi bi-sticky"></i>'), ['action' => 'view', $order->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <!-- <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', $order->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?> -->
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', $order->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <?php if($this->Paginator->param('pageCount') > 1) { ?>
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ') ?>
            <?= $this->Paginator->prev('< ') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(' >') ?>
            <?= $this->Paginator->last(' >>') ?>
        </ul>
    </div>
    <?php } ?>
</div>
