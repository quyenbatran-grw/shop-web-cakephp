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
            </fieldset>
            <table class="table">
                <tr>
                    <th class="w-25"><?=__('Type*')?></th>
                    <td><?=$this->Form->control('type', [
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false
                    ]);?></td>
                </tr>
                <tr>
                    <th class="w-25"><?=__('Name*')?></th>
                    <td><?=$this->Form->control('name', [
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false
                    ]);?></td>
                </tr>
            </table>
            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
