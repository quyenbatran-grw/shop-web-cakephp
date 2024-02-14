<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <div class="d-flex border-bottom">
        <div class="fix-w-4">
            <img src="/img/noImage.svg" alt="" class="rounded-circle w-100">
            <div class="fix-w-3 mt-2">
                <?=$this->Form->create(null, ['type' => 'GET', 'url' => ['controller' => 'Profiles', 'action' => 'edit']]);?>
                <?= $this->Form->button('<i class="bi bi-pen-fill"></i>', ['class' => 'btn btn-outline-primary float-end', 'escapeTitle' => false]); ?>
                <?=$this->Form->end();?>
            </div>
        </div>
        <div class="ms-2">
            <div class="row justify-content-start mt-2">
                <div class="row fw-bold text-truncate"><?=$profile->first_name?> <?=$profile->last_name?></div>
                <?php if(!empty($profile->email)) { ?>
                <div class="col-md-7 fs-6">Email: <?=$profile->email?></div>
                <?php } ?>
                <div class="col-md-7 fs-6">Tài khoản: <?=$profile->username?></div>
                <div class="col-md-7 fs-6">SĐT: <?=$profile->tel?></div>
                <div class="col-md-7 fs-6"><p>Địa chỉ: <?=$profile->address?></p></div>
            </div>
        </div>
    </div>


    <h3><?= __('Điểm tích lũy') ?><span class="ms-3 fs-1 text-danger"><?=number_format($profile->point)?><span class="fs-7">P</span></span></h3>
    <div class="d-flex">
        <div><h3><?= __('Tổng đơn hàng') ?><span class="ms-3 fs-1 text-danger"><?=$order_count?></span></h3></div>
        <div class="ms-3">
            <?=$this->Form->create(null, ['type' => 'GET', 'url' => ['controller' => 'Profiles', 'action' => 'order-list']]);?>
            <?= $this->Form->button('<i class="bi bi-card-list"></i>', ['class' => 'btn btn-outline-primary btn-sm', 'escapeTitle' => false]); ?>
            <?=$this->Form->end();?>
        </div>
    </div>
    <h3><?= __('Đã thanh toán') ?><span class="ms-3 fs-1 text-danger"><?=$paid?><span class="fs-7"></span></span></h3>
    <h3><?= __('Chưa thanh toán') ?><span class="ms-3 fs-1 text-danger"><?=$unpaid?><span class="fs-7"></span></span></h3>

    <!-- <div class="row border-bottom justify-content-start mt-2">
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
    </div> -->

    <br>
    <div class="row justify-content-around">
        <!-- <div class="col-md-4">
            <?=$this->Form->create(null, ['type' => 'GET', 'url' => ['controller' => 'Profiles', 'action' => 'edit']]);?>
            <?= $this->Form->button('Order Histories', ['class' => 'btn btn-primary btn-lg rounded-pill col-md-4 mt-4 w-100']); ?>
            <?=$this->Form->end();?>
        </div> -->
        <div class="col-md-4 text-center">
        <?=$this->Html->link(
            'Tiếp tục mua hàng',
            '/shops',
            ['escape' => false, 'escapeTitle' => false]
        );?>
        </div>

    </div>

    <div class="row justify-content-around mt-2">
        <div class="col-md-2 text-center">
            <a href="/shops/logout/">Đăng xuất</a>
        </div>
    </div>
</div>
