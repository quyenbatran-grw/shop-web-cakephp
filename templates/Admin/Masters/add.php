<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Master $master
 */

use App\Model\Table\MastersTable;

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Masters'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="masters form content">
            <?= $this->Form->create($master) ?>
            <fieldset>
                <legend><?= __('Add Master') ?></legend>
                <?php
                    echo $this->Form->control('type', ['options' => MastersTable::$master_type]);
                    echo $this->Form->control('name');
                ?>
            </fieldset>
            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
