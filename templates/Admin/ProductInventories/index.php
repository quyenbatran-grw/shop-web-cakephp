<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductInventory> $productInventories
 */
?>
<div class="productInventories index content">
    <?= $this->Html->link(__('New Product Inventory'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Product Inventories') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover">
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productInventories as $productInventory): ?>
                <tr>
                    <td><?= $this->Number->format($productInventory->id) ?></td>
                    <td><?= $productInventory->has('product') ? $this->Html->link($productInventory->product->name, ['controller' => 'Products', 'action' => 'view', $productInventory->product->id]) : '' ?></td>
                    <td><?= h($productInventory->date) ?></td>
                    <td><?= $this->Number->format($productInventory->unit_price) ?></td>
                    <td><?= $this->Number->format($productInventory->quantity) ?></td>
                    <td><?= h($productInventory->created) ?></td>
                    <td><?= h($productInventory->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $productInventory->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $productInventory->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $productInventory->id], ['confirm' => __('Are you sure you want to delete # {0}?', $productInventory->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <br>
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ') ?>
            <?= $this->Paginator->prev('< ') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(' >') ?>
            <?= $this->Paginator->last(' >>') ?>
        </ul>
    </div>
</div>
