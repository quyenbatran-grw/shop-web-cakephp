<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ShoppingCart> $shoppingCarts
 */
?>
<div class="shoppingCarts index content">
    <?= $this->Html->link(__('New Shopping Cart'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Shopping Carts') ?></h3>
    <div class="table-responsive">
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('user_id') ?></th>
                    <th><?= $this->Paginator->sort('device_token_id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($shoppingCarts as $shoppingCart): ?>
                <tr>
                    <td><?= $this->Number->format($shoppingCart->id) ?></td>
                    <td><?= $shoppingCart->has('user') ? $this->Html->link($shoppingCart->user->id, ['controller' => 'Users', 'action' => 'view', $shoppingCart->user->id]) : '' ?></td>
                    <td><?= $shoppingCart->has('device_token') ? $this->Html->link($shoppingCart->device_token->id, ['controller' => 'DeviceTokens', 'action' => 'view', $shoppingCart->device_token->id]) : '' ?></td>
                    <td><?= $shoppingCart->has('category') ? $this->Html->link($shoppingCart->category->name, ['controller' => 'Categories', 'action' => 'view', $shoppingCart->category->id]) : '' ?></td>
                    <td><?= $shoppingCart->has('product') ? $this->Html->link($shoppingCart->product->name, ['controller' => 'Products', 'action' => 'view', $shoppingCart->product->id]) : '' ?></td>
                    <td><?= $this->Number->format($shoppingCart->quantity) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $shoppingCart->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $shoppingCart->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $shoppingCart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingCart->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
