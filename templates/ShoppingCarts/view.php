<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCart $shoppingCart
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Shopping Cart'), ['action' => 'edit', $shoppingCart->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Shopping Cart'), ['action' => 'delete', $shoppingCart->id], ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingCart->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Shopping Carts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Shopping Cart'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="shoppingCarts view content">
            <h3><?= h($shoppingCart->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('User') ?></th>
                    <td><?= $shoppingCart->has('user') ? $this->Html->link($shoppingCart->user->id, ['controller' => 'Users', 'action' => 'view', $shoppingCart->user->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Device Token') ?></th>
                    <td><?= $shoppingCart->has('device_token') ? $this->Html->link($shoppingCart->device_token->id, ['controller' => 'DeviceTokens', 'action' => 'view', $shoppingCart->device_token->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Category') ?></th>
                    <td><?= $shoppingCart->has('category') ? $this->Html->link($shoppingCart->category->name, ['controller' => 'Categories', 'action' => 'view', $shoppingCart->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $shoppingCart->has('product') ? $this->Html->link($shoppingCart->product->name, ['controller' => 'Products', 'action' => 'view', $shoppingCart->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($shoppingCart->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($shoppingCart->quantity) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
