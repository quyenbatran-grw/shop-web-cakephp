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
        <!-- <legend><?= __(MSG_0008) ?></legend> -->
        <?= $this->Form->control('username', ['label' => 'Tên đăng nhập', 'class' => 'form-control']) ?>
        <?= $this->Form->control('password', ['label' => 'Mật khẩu', 'class' => 'form-control']) ?>
    </fieldset>

    <div class="d-flex justify-content-center">
    <?= $this->Form->button(__('Đăng nhập'), ['class' => 'btn btn-primary btn-lg mt-5']); ?>
    </div>
    <div class="d-flex justify-content-center">
        <?=$this->Html->link('Bắt đầu mua sắm',
        ['controller' => 'Pages', 'action' => 'index'],
        ['escape' => false, 'escapeTitle' => false]
        );?>
    </div>
    <?= $this->Form->end() ?>
</div>
