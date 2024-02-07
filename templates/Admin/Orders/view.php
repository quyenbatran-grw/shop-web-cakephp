<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <!-- <?= $this->Html->link(__('Edit Order'), ['action' => 'edit', $order->id], ['class' => 'side-nav-item']) ?> -->
            <!-- <?= $this->Form->postLink(__('Delete Order'), ['action' => 'delete', $order->id], ['confirm' => __('Are you sure you want to delete # {0}?', $order->id), 'class' => 'side-nav-item']) ?> -->
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <!-- <?= $this->Html->link(__('New Order'), ['action' => 'add'], ['class' => 'side-nav-item']) ?> -->
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders view content">
            <!-- <h3><?= h($order->id) ?></h3> -->
            <table class="table">
                <tr>
                    <th><?= __('Order Number') ?></th>
                    <td><?= h($order->order_number) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Name') ?></th>
                    <td><?= h($order->order_name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Address') ?></th>
                    <td><?= h($order->order_address) ?></td>
                </tr>
                <tr>
                    <th><?= __('Order Tel') ?></th>
                    <td><?= h($order->order_tel) ?></td>
                </tr>
                <tr>
                    <th><?= __('Status') ?></th>
                    <td>
                        <?=$this->Form->create($order, ['url' => ['controller' => 'Orders', 'action' => 'update-status', $order->id]])?>
                        <?=$this->Form->control('status', [
                            'class' => 'form-select w-50',
                            'options' => $status_list,
                            'label' => false,
                            'multiple' => false,
                            'onChange' => 'submit(this.form)'
                        ])?>
                        <?=$this->Form->end()?>
                        <!-- <?= $order->status_name ?> -->
                    </td>
                </tr>
                <tr>
                    <th><?= __('Order Amount') ?></th>
                    <td><?= number_format($order->order_amount) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($order->created->i18nFormat('Y/MM/dd HH:mm')) ?></td>
                </tr>
                <!-- <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($order->modified) ?></td>
                </tr> -->
            </table>
            <div class="text">
                <strong><?= __('Memo') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($order->memo)); ?>
                </blockquote>
            </div>
            <div class="related">
                <h4><?= __('Related Order Details') ?></h4>
                <?php if (!empty($order->order_details)) : ?>
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <tr>
                            <th><?= __('No') ?></th>
                            <!-- <th><?= __('Order Id') ?></th> -->
                            <th><?= __('Product') ?></th>
                            <!-- <th><?= __('User Id') ?></th> -->
                            <th><?= __('Quantity') ?></th>
                            <th><?= __('Unit Price') ?></th>
                            <th><?= __('Amount') ?></th>
                            <th><?= __('Memo') ?></th>
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
                            <td><?= h($orderDetails->unit_price) ?></td>
                            <td><?= h($orderDetails->amount) ?></td>
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
        </div>
    </div>
</div>
