<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductInventory $productInventory
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Product Inventory'), ['action' => 'edit', $productInventory->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Product Inventory'), ['action' => 'delete', $productInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productInventory->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Product Inventories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Product Inventory'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="productInventories view content">
            <h3><?= h($productInventory->id) ?></h3>
            <table>
                <tr>
                    <th><?= __('Product') ?></th>
                    <td><?= $productInventory->has('product') ? $this->Html->link($productInventory->product->name, ['controller' => 'Products', 'action' => 'view', $productInventory->product->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($productInventory->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Unit Price') ?></th>
                    <td><?= $this->Number->format($productInventory->unit_price) ?></td>
                </tr>
                <tr>
                    <th><?= __('Quantity') ?></th>
                    <td><?= $this->Number->format($productInventory->quantity) ?></td>
                </tr>
                <tr>
                    <th><?= __('Date') ?></th>
                    <td><?= h($productInventory->date) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($productInventory->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($productInventory->modified) ?></td>
                </tr>
            </table>
            <div class="text">
                <strong><?= __('Memo') ?></strong>
                <blockquote>
                    <?= $this->Text->autoParagraph(h($productInventory->memo)); ?>
                </blockquote>
            </div>
            <?=$this->Form->create(null, ['url' => ['controller' => 'ProductInventories', 'action' => 'edit', $productInventory->id], 'type' => 'get']);?>
            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Edit'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?=$this->Form->end();?>
        </div>
    </div>
</div>
