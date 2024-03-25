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
            <?= $this->Html->link(__('List Masters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="masters form content">
            <?= $this->Form->create($master) ?>
            <fieldset>
                <legend><?= __('Add Master') ?></legend>
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
