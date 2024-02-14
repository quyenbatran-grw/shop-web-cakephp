<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */

use App\Model\Table\OrdersTable;

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <!-- <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?> -->
            <!-- <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <!-- <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?> -->
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders view content">
            <!-- <h3><?= h($order->id) ?></h3> -->
            <?=$this->Form->create($order, ['url' => ['controller' => 'Orders', 'action' => 'update-status', $order->id]])?>
            <table class="table">
                <tr>
                    <th><?= __('Mã đơn hàng') ?></th>
                    <td><?= h($order->order_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tên người đặt') ?></th>
                    <td><?= h($order->order_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Địa chỉ người đặt') ?></th>
                    <td><?= h($order->order_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('SĐT người đặt') ?></th>
                    <td><?= h($order->order_tel) ?></td>
                </tr>

                <tr>
                    <th><?= __('Phương thức thanh toán') ?></th>
                    <td><?= OrdersTable::$paymentTypes[$order->payment_type] ?></td>
                </tr>

                <tr>
                    <th><?= __('Trạng thái') ?></th>
                    <td>
                        <?=$this->Form->control('status', [
                            'class' => 'form-select w-50',
                            'options' => $status_list,
                            'label' => false,
                            'multiple' => false,
                        ])?>
                        <!-- <?= $order->status_name ?> -->
                    </td>
                </tr>
                <tr>
                    <th><?= __('Tổng tiền') ?></th>
                    <td><?= number_format($order->order_amount) ?></td>
                </tr>

                <tr>
                    <th><?= __('Thanh toán') ?></th>
                    <td class="d-flex">
                    <?=$this->Form->control('payment_status', [
                        'class' => 'form-select',
                        'options' => OrdersTable::$paymentStatus,
                        'label' => false,
                        'multiple' => false,
                    ])?>
                    <?=$this->Form->control('paid_amount', [
                        'class' => 'form-control ms-2',
                        'label' => false,
                        'type' => 'number',
                    ])?>
                    </td>
                </tr>

                <tr>
                    <th><?= __('Ngày đặt') ?></th>
                    <td><?= h($order->created->i18nFormat('Y/MM/dd HH:mm')) ?></td>
                </tr>
                <!-- <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($order->modified) ?></td>
                </tr> -->
            </table>
            <div class="text">
                <strong><?= __('Ghi chú') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->memo)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Chi tiết đơn hàng Order Details') ?></h4>
                <?php if (!empty($order->order_details)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th><?= __('No') ?></th>
                            <!-- <th><?= __('Order Id') ?></th> -->
                            <th><?= __('Sản phẩm') ?></th>
                            <!-- <th><?= __('User Id') ?></th> -->
                            <th><?= __('Số Lượng') ?></th>
                            <th><?= __('Đơn giá') ?></th>
                            <th><?= __('Tổng tiền') ?></th>
                            <th><?= __('Ghi chú') ?></th>
                            <!-- <th><?= __('Created') ?></th> -->
                            <!-- <th><?= __('Modified') ?></th> -->
                            <!-- <th class="actions"><?= __('Actions') ?></th> -->
                        </tr>
                        <?php foreach ($order->order_details as $key => $orderDetails) : ?>
                        <tr>
                            <td><?= h($key + 1) ?></td>
                            <!-- <td><?= h($orderDetails->order_id) ?></td> -->
                            <td><?= h($orderDetails->product->name) ?></td>
                            <!-- <td><?= h($orderDetails->user_id) ?></td> -->
                            <td><?= h($orderDetails->quantity) ?></td>
                            <td><?= number_format($orderDetails->unit_price) ?></td>
                            <td><?= number_format($orderDetails->amount) ?></td>
                            <td><?= h($orderDetails->memo) ?></td>
                            <!-- <td><?= h($orderDetails->created) ?></td> -->
                            <!-- <td><?= h($orderDetails->modified) ?></td> -->
                            <td class="actions">
                                <!-- <?= $this->Html->link(__('View'), ['controller' => 'OrderDetails', 'action' => 'view', $orderDetails->id]) ?> -->
                                <!-- <?= $this->Html->link(__('Edit'), ['controller' => 'OrderDetails', 'action' => 'edit', $orderDetails->id]) ?> -->
                                <!-- <?= $this->Form->postLink(__('Delete'), ['controller' => 'OrderDetails', 'action' => 'delete', $orderDetails->id], ['confirm' => __('Are you sure you want to delete # {0}?', $orderDetails->id)]) ?> -->
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    </table>
                </div>
                <?php endif; ?>
            </div>

            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Quay lại'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Lưu'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?=$this->Form->end()?>
        </div>
    </div>
</div>
