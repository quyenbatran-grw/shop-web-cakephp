<div class="menu-link-list">
<?=$this->Html->link(
    '<i class="bi bi-caret-left"></i>Category',
    ['controller' => 'Pages', 'action' => 'index'],
    ['escape' => false, 'escapeTitle' => false]
);?>
</div>
<div class="content mt-3">
    <?php
    if(!$auth && !$continue) {
    ?>
    <div>If you have an account. You can login to continue shopping</div>

    <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'cart-confirm']]);?>
    <div class="d-flex justify-content-center mt-5">
        <?=$this->Html->link('Login to continue', [ 'controller' => 'Shops', 'action' => 'login' ],
        [
            'class' => 'btn btn-primary m-1',
        ]);?>
        <?=$this->Form->button('Continue', [
            'class' => 'btn btn-primary m-1',
        ]);?>
        <?=$this->Form->hidden('shopping_continue', ['value' => 1]);?>
    </div>
        <?=$this->Form->end();?>
    <?php
    } else {
    ?>
    <div>Please fill all below information before purchase</div>
    <div >
        <?=$this->Form->create(null, ['url' => ['controller' => 'Shops', 'action' => 'order-info']]);?>
        <?=$this->Form->control('name', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => 'Contact Name',
            'required' => true
        ]);?>
        <?=$this->Form->control('address', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => 'Contact address',
            'required' => true
        ]);?>
        <?=$this->Form->control('tel', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => 'Contact tel',
            'required' => true
        ]);?>
        <?=$this->Form->control('memo', [
            'type' => 'textarea',
            'class' => 'form-control',
            'label' => 'Descriptions',
        ]);?>
        <div class="d-flex justify-content-center">
            <?=$this->Form->button('Regist', [
                'class' => 'btn btn-primary mt-5'
            ]);?>
        </div>
        <?=$this->Form->end();?>
    </div>

    <?php
    }
    ?>




</div>
