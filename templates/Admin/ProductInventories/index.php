<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductInventory> $productInventories
 */

use App\Model\Entity\ProductInventory;

?>
<div class="productInventories index content">
    <?= $this->Html->link(__('New Product Inventory'), ['action' => 'add'], ['class' => 'button float-right']) ?>

    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-1">Product</div>
        <div class="col col-md-3">
            <?=$this->Form->control('product_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'Cosmetic',
                'value' => isset($searchParam['product_name']) ? $searchParam['product_name'] : ''
            ])?>
        </div>

        <div class="col col-md-1 text-end">Date</div>
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

        <div class="col col-md-1 text-end">Unit</div>
        <div class="col col-md-2">
            <?php
            $unitList = ['ALL'];
            $unitList += ProductInventory::$units;
            ?>
            <?=$this->Form->control('unit', [
                'type' => 'select',
                'class' => 'form-select',
                'label' => false,
                'options' => $unitList,
                'value' => isset($searchParam['unit']) ? $searchParam['unit'] : 0
            ])?>
        </div>
    </div>
    <div class="row justify-content-center mt-4 border-bottom pb-4">
        <div class="col col-md-2">
            <?=$this->Form->button('Search', [
                'class' => 'btn btn-primary w-100'
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('Clear', ['action' => ''], [
                'class' => 'btn btn-primary w-100'
            ])?>
        </div>
    </div>
    <?=$this->Form->end()?>
    <h3 class="mt-4"><?= __('Product Inventories List') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <!-- <th><?= $this->Paginator->sort('id') ?></th> -->
                    <th><?= $this->Paginator->sort('product_id') ?></th>
                    <th><?= $this->Paginator->sort('date') ?></th>
                    <th><?= $this->Paginator->sort('expired_date') ?></th>
                    <th><?= $this->Paginator->sort('unit_price') ?></th>
                    <th><?= $this->Paginator->sort('quantity') ?></th>
                    <th><?= $this->Paginator->sort('unit') ?></th>
                    <!-- <th><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($productInventories as $productInventory): ?>
                <tr>
                    <!-- <td class="text-center"><?= number_format($productInventory->id) ?></td> -->
                    <td><?= $productInventory->has('product') ? $this->Html->link($productInventory->product->name, ['controller' => 'Products', 'action' => 'view', $productInventory->product->id]) : '' ?></td>
                    <td class="text-center"><?= h($productInventory->date->i18nFormat('Y/MM/dd')) ?></td>
                    <td class="text-center"><?= !empty($productInventory->expired_date) ? h($productInventory->expired_date->i18nFormat('Y/MM/dd')) : ''?></td>
                    <td class="text-end"><?= number_format($productInventory->unit_price) ?></td>
                    <td class="text-end"><?= number_format($productInventory->quantity) ?></td>
                    <td class="text-end"><?= $productInventory->unit_name ?></td>
                    <!-- <td><?= h($productInventory->created->i18nFormat('Y/MM/dd')) ?></td> -->
                    <!-- <td><?= h($productInventory->modified) ?></td> -->
                    <td class="actions text-center">
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
