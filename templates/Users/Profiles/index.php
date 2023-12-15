<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <h3><?= __('User Profiles') ?></h3>

    <div class="row border-bottom justify-content-start mt-2">
        <div class="col-md-5 fw-bold">UserName</div>
        <div class="col-md-7"><p><?=$profile->username?></p></div>
    </div>

    <div class="row border-bottom justify-content-start">
        <div class="col-md-5 fw-bold">First Name</div>
        <div class="col-md-7"><p><?=$profile->first_name?></p></div>
    </div>

    <div class="row border-bottom justify-content-start mt-2">
        <div class="col-md-5 fw-bold">Last Name</div>
        <div class="col-md-7"><p><?=$profile->last_name?></p></div>
    </div>

    <div class="row border-bottom justify-content-start mt-2">
        <div class="col-md-5 fw-bold">Phone</div>
        <div class="col-md-7"><p><?=$profile->tel?></p></div>
    </div>

    <div class="row border-bottom justify-content-start mt-2">
        <div class="col-md-5 fw-bold">Email</div>
        <div class="col-md-7"><p class="text-break"><?=$profile->email?></p></div>
    </div>

    <div class="row border-bottom justify-content-start mt-2">
        <div class="col-md-5 fw-bold">Address</div>
        <div class="col-md-7 text-break"><p><?=$profile->address?></p></div>
    </div>

    <div class="row justify-content-around">
        <div class="col-md-4">
            <?=$this->Form->create(null, ['type' => 'GET', 'url' => ['controller' => 'Profiles', 'action' => 'edit']]);?>
            <?= $this->Form->button('Edit', ['class' => 'btn btn-primary btn-lg rounded-pill col-md-4 mt-4 w-100']); ?>
            <?=$this->Form->end();?>
        </div>
        <div class="col-md-4">
            <?=$this->Form->create(null, ['url' => '/shops']);?>
            <?= $this->Form->button('Shopping Continue', ['class' => 'btn btn-primary btn-lg rounded-pill col-md-4 mt-4 w-100']); ?>
            <?=$this->Form->end();?>
        </div>
    </div>

    <div class="row justify-content-around mt-4">
        <div class="col-md-2 text-center">
            <a href="/shops/logout/">Logout</a>
        </div>
    </div>
</div>
