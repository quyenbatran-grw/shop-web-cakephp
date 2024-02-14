<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Sửa thông tin') ?></h4>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <div class="row justify-content-start">
                <div class="col-md-4 fw-bold">Tài khoản</div>
                <div class="col-md-8"><?=__($profile->username)?></div>
            </div>
            <?= $this->Form->create($profile) ?>
            <div class="row justify-content-start mt-3 border-top">
                <div class="col-md-4 mt-2 fw-bold">Họ*</div>
                <div class="col-md-8">
                    <?=$this->Form->control('first_name', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Tên*</div>
                <div class="col-md-8">
                    <?=$this->Form->control('last_name', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">SĐT*</div>
                <div class="col-md-8">
                    <?=$this->Form->control('tel', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Email</div>
                <div class="col-md-8">
                    <?=$this->Form->control('email', [
                        'class' => 'form-control mt-2',
                        'required' => false,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Địa chỉ*</div>
                <div class="col-md-8">
                    <?=$this->Form->control('address', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-around mt-4">
                <div class="col-md-3">
                    <?= $this->Form->button('Hủy', ['class' => 'btn btn-secondary btn-lg col-md-3 mt-4 w-100', 'type' => 'button', 'onclick' => 'history.back()']); ?>
                </div>
                <div class="col-md-3">
                    <?= $this->Form->button('Lưu', ['class' => 'btn btn-primary btn-lg col-md-3 mt-4 w-100']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
