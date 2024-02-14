<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductInventory> $productInventories
 */

use App\Model\Entity\ProductInventory;

?>
<div class="productInventories index content">

    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-1">Category</div>
        <div class="col col-md-3">
            <?=$this->Form->control('product_name', [
                'class' => 'form-control',
                'label' => false,
                'options' => $categories,
                'value' => isset($searchParam['product_name']) ? $searchParam['product_name'] : ''
            ])?>
        </div>

        <div class="col col-md-1 text-end">Product</div>
        <div class="col col-md-3">
            <?php
            $unitList = ['ALL'];
            $unitList += ProductInventory::$units;
            ?>
            <?=$this->Form->control('unit', [
                'type' => 'select',
                'class' => 'form-select',
                'label' => false,
                'options' => $products,
                'value' => isset($searchParam['unit']) ? $searchParam['unit'] : 0
            ])?>
        </div>
    </div>
    <div class="row justify-content-center mt-4 border-bottom pb-4">
        <div class="col col-md-2">
            <?=$this->Form->button('<i class="bi bi-search"></i> Tìm kiếm', [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('<i class="bi bi-x-circle"></i> Xóa', ['action' => ''], [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
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
                <?php foreach ($inventories as $inventory): ?>
                <tr>
                    <?php var_dump($inventory) ?>
                    <td><?=$inventory->product->id?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <div class="row">
        <div class="col col-md-1">
        <?=$this->Html->link('Stock', ['controller' => 'ProductInventories', 'action' => 'stock'], [
            'class' => 'btn btn-primary w-100'
        ])?>
        </div>
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
