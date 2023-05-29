<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ShoppingCart $shoppingCart
 * @var string[]|\Cake\Collection\CollectionInterface $users
 * @var string[]|\Cake\Collection\CollectionInterface $deviceTokens
 * @var string[]|\Cake\Collection\CollectionInterface $categories
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $shoppingCart->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $shoppingCart->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Shopping Carts'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="shoppingCarts form content">
            <?= $this->Form->create($shoppingCart) ?>
            <fieldset>
                <legend><?= __('Edit Shopping Cart') ?></legend>
                <?php
                    echo $this->Form->control('user_id', ['options' => $users, 'empty' => true]);
                    echo $this->Form->control('device_token_id', ['options' => $deviceTokens, 'empty' => true]);
                    echo $this->Form->control('category_id', ['options' => $categories]);
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('quantity');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>