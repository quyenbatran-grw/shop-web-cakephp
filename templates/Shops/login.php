<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="users form content">
    <?= $this->Form->create() ?>
    <fieldset>
        <legend><?= __('Please enter your email and password') ?></legend>

        <?= $this->Form->control('password') ?>
    </fieldset>

    <div class="">
    <?= $this->Form->control('username', ['class' => 'form-control']) ?>
    </div>
    <div class="d-flex justify-content-center">
    <?= $this->Form->button(__('Login'), ['class' => 'mt-5']); ?>
    </div>
    <?= $this->Form->end() ?>
</div>
