<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Master> $masters
 */
?>
<div class="masters index content">
    <?= $this->Html->link(__('New Master'), ['action' => 'add'], ['class' => 'button float-right']) ?>
    <h3><?= __('Masters') ?></h3>
    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead>
                <tr class="text-center">
                    <!-- <th><?= $this->Paginator->sort('id') ?></th> -->
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('rank') ?></th>
                    <!-- <th><?= $this->Paginator->sort('created') ?></th> -->
                    <!-- <th><?= $this->Paginator->sort('modified') ?></th> -->
                    <th class="actions text-center"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masters as $master): ?>
                <tr>
                    <!-- <td><?= $this->Number->format($master->id) ?></td> -->
                    <td><?= $this->Number->format($master->type) ?></td>
                    <td><?= h($master->name) ?></td>
                    <td><?= $this->Number->format($master->rank) ?></td>
                    <!-- <td><?= h($master->created) ?></td> -->
                    <!-- <td><?= h($master->modified) ?></td> -->
                    <td class="actions text-center">
                        <?= $this->Html->link(__('<i class="bi bi-sticky"></i>'), ['action' => 'view', $master->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', $master->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'), ['action' => 'delete', $master->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $master->id), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
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
