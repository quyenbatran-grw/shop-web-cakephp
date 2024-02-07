<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content">
    <?= $this->Form->create() ?>
    <div class="">

    </div>

    <fieldset>
        <legend><?= __(MSG_0008) ?></legend>
        <?= $this->Form->control('username', ['class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['class' => 'form-control']) ?>
    </fieldset>

    <div class="d-flex justify-content-center">
    <?= $this->Form->button(__('Login'), ['class' => 'btn btn-primary btn-lg mt-5']); ?>
    </div>
    <div class="d-flex justify-content-center">
        <?=$this->Html->link('Shopping without login',
        ['controller' => 'Pages', 'action' => 'index'],
        ['escape' => false, 'escapeTitle' => false]
        );?>
    </div>
    <?= $this->Form->end() ?>
</div>
