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
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $master->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $master->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Masters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masters form content">
            <?= $this->Form->create($master) ?>
            <fieldset>
                <legend><?= __('Edit Master') ?></legend>
                <?php
                    echo $this->Form->control('type');
                    echo $this->Form->control('name');
                    echo $this->Form->control('rank');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
