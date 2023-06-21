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
        <table>
            <thead>
                <tr>
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('type') ?></th>
                    <th><?= $this->Paginator->sort('name') ?></th>
                    <th><?= $this->Paginator->sort('rank') ?></th>
                    <th><?= $this->Paginator->sort('created') ?></th>
                    <th><?= $this->Paginator->sort('modified') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($masters as $master): ?>
                <tr>
                    <td><?= $this->Number->format($master->id) ?></td>
                    <td><?= $this->Number->format($master->type) ?></td>
                    <td><?= h($master->name) ?></td>
                    <td><?= $this->Number->format($master->rank) ?></td>
                    <td><?= h($master->created) ?></td>
                    <td><?= h($master->modified) ?></td>
                    <td class="actions">
                        <?= $this->Html->link(__('View'), ['action' => 'view', $master->id]) ?>
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $master->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $master->id], ['confirm' => __('Are you sure you want to delete # {0}?', $master->id)]) ?>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
    <div class="paginator">
        <ul class="pagination">
            <?= $this->Paginator->first('<< ' . __('first')) ?>
            <?= $this->Paginator->prev('< ' . __('previous')) ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(__('next') . ' >') ?>
            <?= $this->Paginator->last(__('last') . ' >>') ?>
        </ul>
        <p><?= $this->Paginator->counter(__('Page {{page}} of {{pages}}, showing {{current}} record(s) out of {{count}} total')) ?></p>
    </div>
</div>
