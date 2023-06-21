<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductInventory $productInventory
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Form->postLink(
                __('Delete'),
                ['action' => 'delete', $productInventory->id],
                ['confirm' => __('Are you sure you want to delete # {0}?', $productInventory->id), 'class' => 'side-nav-item']
            ) ?>
            <?= $this->Html->link(__('List Product Inventories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="productInventories form content">
            <?= $this->Form->create($productInventory) ?>
            <fieldset>
                <legend><?= __('Edit Product Inventory') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('date');
                    echo $this->Form->control('unit_price');
                    echo $this->Form->control('quantity');
                    echo $this->Form->control('memo');
                ?>
            </fieldset>

            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
