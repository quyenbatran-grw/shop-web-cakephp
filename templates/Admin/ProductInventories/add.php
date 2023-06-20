<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductInventory $productInventory
 * @var \Cake\Collection\CollectionInterface|string[] $products
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Product Inventories'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="productInventories form content">
            <?= $this->Form->create($productInventory) ?>
            <fieldset>
                <legend><?= __('Add Product Inventory') ?></legend>
                <?php
                    echo $this->Form->control('product_id', ['options' => $products]);
                    echo $this->Form->control('date', ['value' => date('Y/m/d H:i:s')]);
                    echo $this->Form->control('unit_price', ['value' => 150000]);
                    echo $this->Form->control('quantity', ['value' => 150]);
                    echo $this->Form->control('memo', ['value' => 'add inventory']);
                ?>
            </fieldset>

            <div class="d-flex justify-content-between mx-9 my-4">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-4', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button('Submit', ['type' => 'submit', 'id' => 'save-product-button', 'class' => 'btn btn-primary btn-lg col-4']); ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
