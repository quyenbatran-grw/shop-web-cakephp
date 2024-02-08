<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Product> $products
 */
?>
<div class="products index content">
    <?= $this->Html->link(__('New Product'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-1">Category</div>
        <div class="col col-md-2">
            <?=$this->Form->control('category_id', [
                'class' => 'form-select',
                'label' => false,
                'options' => $categoryList,
                'value' => isset($searchParam['category_id']) ? $searchParam['category_id'] : ''
            ])?>
        </div>

        <div class="col col-md-1">Product</div>
        <div class="col col-md-3">
            <?=$this->Form->control('product_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'Cosmetic',
                'value' => isset($searchParam['product_name']) ? $searchParam['product_name'] : ''
            ])?>
        </div>

        <div class="col col-md-1">Sponser</div>
        <div class="col col-md-3">
            <?=$this->Form->control('sponsor_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'Sponser Name',
                'value' => isset($searchParam['sponsor_name']) ? $searchParam['sponsor_name'] : ''
            ])?>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-3 border-bottom p-4">
        <div class="col col-md-2">
            <?=$this->Form->button('<i class="bi bi-search"></i> Search', [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('<i class="bi bi-x-circle"></i> Clear', ['action' => ''], [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
    </div>
    <?=$this->Form->end()?>
    <h3><?= __('Products') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered fix-header">
            <thead class="text-center sticky-top">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= __('StockIn') ?></th>
                    <th><?= __('StockOut') ?></th>
                    <th><?= $this->Paginator->sort('sponsor_name') ?></th>
                    <th><?= $this->Paginator->sort('sponsor_tel') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product):
                $stockin = isset($inventories[$product->id]) ? number_format($inventories[$product->id]->sum) : 0;
                $stockout = isset($inventories[$product->id]) ? number_format($inventories[$product->id]->sold) : 0;
                ?>
                <tr>
                    <td><?= $this->Number->format($product->id) ?></td>
                    <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
                    <td><?= h($product->name) ?></td>
                    <td class="text-end <?=$stockin == $stockout && $stockout > 0 ? 'bg-danger text-light' : ''?>"><?= $stockin ?></td>
                    <td class="text-end"><?= $stockout ?></td>
                    <td><?= h($product->sponsor_name) ?></td>
                    <td><?= h($product->sponsor_tel) ?></td>
                    <td><?= h($product->description) ?></td>
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
