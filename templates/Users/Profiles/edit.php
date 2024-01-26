<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Edit Account Infomation') ?></h4>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="users form content">
            <?= $this->Form->create($profile) ?>
            <div class="row justify-content-start">
                <div class="col-md-4 fw-bold">First Name</div>
                <div class="col-md-8">
                    <?=$this->Form->control('first_name', [
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Last Name</div>
                <div class="col-md-8">
                    <?=$this->Form->control('last_name', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Phone</div>
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
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-start mt-4 border-top">
                <div class="col-md-4 mt-2 fw-bold">Address</div>
                <div class="col-md-8">
                    <?=$this->Form->control('address', [
                        'class' => 'form-control mt-2',
                        'required' => true,
                        'label' => false
                    ])?>
                </div>
            </div>

            <div class="row justify-content-around">
                <div class="col-md-4">
                    <?= $this->Form->button('Cancel', ['class' => 'btn btn-primary btn-lg rounded-pill col-md-4 mt-4 w-100', 'type' => 'button', 'onclick' => 'history.back()']); ?>
                </div>
                <div class="col-md-4">
                    <?= $this->Form->button('Save', ['class' => 'btn btn-primary btn-lg rounded-pill col-md-4 mt-4 w-100']); ?>
                </div>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>