<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Category> $categories
 */
?>
<div class="categories index content">
    <?= $this->Html->link(__('New Category'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Categories') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <!-- <th><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($categories as $category): ?>
                <tr>
                    <td><?= $this->Number->format($category->id) ?></td>
                    <td><?= h($category->name) ?></td>
                    <!-- <td><?= h($category->created) ?></td> -->
                    <!-- <td><?= h($category->modified) ?></td> -->
                    <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $category->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $category->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $category->id], ['confirm' => __('Are you sure you want to delete # {0}?', $category->id)]) ?>
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
