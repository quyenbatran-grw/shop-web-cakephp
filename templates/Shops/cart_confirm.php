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
    <?=$this->Html->link('Login to continue', [ 'controller' => 'Shops', 'action' => 'login', '?' => ['redirect' => 'shops/cart-confirm'] ],
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
            'label' => 'Contact Name※',
            'required' => true,
            'value' => $customer && $customer['full_name'] ? $customer['full_name'] : ''
        ]);?>
        <?=$this->Form->control('address', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => 'Contact address※',
            'required' => true,
            'value' => $customer && $customer['address'] ? $customer['address'] : ''
        ]);?>
        <?=$this->Form->control('tel', [
            'type' => 'text',
            'class' => 'form-control',
            'label' => 'Contact tel※',
            'required' => true,
            'value' => $customer && $customer['tel'] ? $customer['tel'] : ''
        ]);?>
        <?=$this->Form->control('memo', [
            'type' => 'textarea',
            'class' => 'form-control',
            'label' => 'Descriptions',
            'value' => $customer && $customer['memo'] ? $customer['memo'] : ''
        ]);?>
        <div class="row justify-content-around mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button('Next', ['class' => 'btn btn-primary col-3']); ?>
        </div>
        <?=$this->Form->end();?>
    </div>

    <?php
    }
    ?>




</div>
