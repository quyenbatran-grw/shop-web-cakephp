<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Master $master
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('Edit Master'), ['action' => 'edit', $master->id], ['class' => 'side-nav-item']) ?>
            <?= $this->Form->postLink(__('Delete Master'), ['action' => 'delete', $master->id], ['confirm' => __('Are you sure you want to delete # {0}?', $master->id), 'class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('List Masters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
            <?= $this->Html->link(__('New Master'), ['action' => 'add'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masters view content">
            <h3><?= h($master->name) ?></h3>
            <table>
                <tr>
                    <th><?= __('Name') ?></th>
                    <td><?= h($master->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Id') ?></th>
                    <td><?= $this->Number->format($master->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Type') ?></th>
                    <td><?= $this->Number->format($master->type) ?></td>
                </tr>
                <tr>
                    <th><?= __('Rank') ?></th>
                    <td><?= $this->Number->format($master->rank) ?></td>
                </tr>
                <tr>
                    <th><?= __('Created') ?></th>
                    <td><?= h($master->created) ?></td>
                </tr>
                <tr>
                    <th><?= __('Modified') ?></th>
                    <td><?= h($master->modified) ?></td>
                </tr>
            </table>
        </div>
    </div>
</div>
