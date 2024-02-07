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
    <h3><?= __('Products') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="text-center">
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('category_id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('made_in') ?></th>
                    <th><?= $this->Paginator->sort('sponsor_name') ?></th>
                    <th><?= $this->Paginator->sort('sponsor_address') ?></th>
                    <th><?= $this->Paginator->sort('sponsor_tel') ?></th>
                    <th><?= $this->Paginator->sort('description') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($products as $product): ?>
                <tr>
                    <td><?= $this->Number->format($product->id) ?></td>
                    <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
                    <td><?= h($product->name) ?></td>
                    <td><?= h($product->made_name) ?></td>
                    <td><?= h($product->sponsor_name) ?></td>
                    <td><?= h($product->sponsor_address) ?></td>
                    <td><?= h($product->sponsor_tel) ?></td>
                    <td><?= h($product->description) ?></td>
                    <td class="actions text-center">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $product->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $product->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $product->id], ['confirm' => __('Are you sure you want to delete # {0}?', $product->id)]) ?>
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
