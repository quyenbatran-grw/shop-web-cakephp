<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\ProductInventory> $productInventories
 */

use App\Model\Entity\ProductInventory;

?>
<div class="productInventories index content">
    <?= $this->Html->link(__('Thêm mới'), ['action' => 'add'], ['class' => 'button float-right']) ?>

    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-1">Sản phẩm</div>
        <div class="col col-md-3">
            <?=$this->Form->control('product_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'Cosmetic',
                'value' => isset($searchParam['product_name']) ? $searchParam['product_name'] : ''
            ])?>
        </div>

        <div class="col col-md-2 text-end">Ngày nhập</div>
        <div class="col col-md-3 d-flex">
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

        <div class="col col-md-1 text-end">Đơn vị</div>
        <div class="col col-md-2">
            <?php
            $unitList = ['Tất cả'];
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
    <h3 class="mt-4"><?= __('Danh sách kho') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered fix-header">
            <thead class="sticky-top">
                <tr class="text-center">
                    <!-- <th><?= $this->Paginator->sort('id', 'ID') ?></th> -->
                    <th><?= $this->Paginator->sort('product_id', 'Sản phẩm') ?></th>
                    <th><?= $this->Paginator->sort('date', 'Ngày nhập') ?></th>
                    <th><?= $this->Paginator->sort('expired_date', 'Hạn sử dụng') ?></th>
                    <th><?= $this->Paginator->sort('unit_price', 'Đơn giá') ?></th>
                    <th><?= $this->Paginator->sort('quantity', 'Số lượng') ?></th>
                    <th><?= $this->Paginator->sort('unit', 'Đơn vị') ?></th>
                    <!-- <th><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="actions"><?= __('') ?></th>
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
                        <?= $this->Html->link(__('<i class="bi bi-sticky"></i>'), ['action' => 'view', $productInventory->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', $productInventory->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', $productInventory->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $productInventory->id), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

    <!-- <div class="row">
        <div class="col col-md-1">
        <?=$this->Html->link('Stock', ['controller' => 'ProductInventories', 'action' => 'stock'], [
            'class' => 'btn btn-primary w-100'
        ])?>
        </div>
    </div> -->

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
