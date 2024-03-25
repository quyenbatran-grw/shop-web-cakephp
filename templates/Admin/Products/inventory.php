<?php
use App\Model\Entity\ProductInventory;
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<div class="products index content">
    <aside class="column">
        <div class="side-nav">
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>

    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-1">Danh mục</div>
        <div class="col col-md-2">
            <?=$this->Form->control('category_id', [
                'class' => 'form-select',
                'label' => false,
                'options' => $categoryList,
                'value' => isset($searchParam['category_id']) ? $searchParam['category_id'] : ''
            ])?>
        </div>

        <div class="col col-md-1">Nhà PP</div>
        <div class="col col-md-3">
            <?=$this->Form->control('sponsor_id', [
                'class' => 'form-select',
                'options' => $sponsors,
                'label' => false,
                'placeholder' => 'Sponser Name',
                'value' => isset($searchParam['sponsor_name']) ? $searchParam['sponsor_name'] : ''
            ])?>
        </div>

        <div class="col col-md-1">Tên SP</div>
        <div class="col col-md-3">
            <?=$this->Form->control('product_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'Cosmetic',
                'value' => isset($searchParam['product_name']) ? $searchParam['product_name'] : ''
            ])?>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-3 border-bottom p-4">
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
    <h3><?= __('Danh sách sản phẩm') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered fix-header">
            <thead class="text-center sticky-top">
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('category_id', 'Danh mục ID') ?></th>
                    <th><?= $this->Paginator->sort('name', 'Tên SP') ?></th>
                    <th><?= __('Nhập kho') ?></th>
                    <th><?= __('Tồn kho') ?></th>
                    <th><?= $this->Paginator->sort('Nhà phân phối') ?></th>
                    <th><?= $this->Paginator->sort('SĐT') ?></th>
                    <th><?= __('Đơn vị') ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product):
                $stockin = isset($inventories[$product->id]) && $inventories[$product->id]->sum ? number_format($inventories[$product->id]->sum) : 0;
                $stockout = isset($inventories[$product->id]) && $inventories[$product->id]->sold ? number_format($inventories[$product->id]->sold) : 0;
                ?>
                <tr>
                    <td><?= $this->Number->format($product->id) ?></td>
                    <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
                    <td><?= h($product->name) ?></td>
                    <td class="text-end <?=$stockin == $stockout && $stockout > 0 ? 'bg-danger text-light' : ''?>"><?= $stockin ?></td>
                    <td class="text-end"><?= $stockout ?></td>
                    <td><?= h($product->sponsor_name) ?></td>
                    <td><?= h($product->sponsor_tel) ?></td>
                    <td><?= isset($product->product_inventories[0]) && isset(ProductInventory::$units[$product->product_inventories[0]->unit]) ? ProductInventory::$units[$product->product_inventories[0]->unit] : '' ?></td>
                    <td class="actions text-center">
                        <?= $this->Html->link(__('<i class="bi bi-sticky"></i>'), ['action' => 'view', $product->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', $product->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', $product->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $product->id), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
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
