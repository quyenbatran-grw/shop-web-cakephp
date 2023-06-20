<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */

use App\Model\Table\ProductsTable;

?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Products'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="products form content">
            <?= $this->Form->create($product, ['enctype' => 'multipart/form-data', 'id' => 'js-validate-form']) ?>
            <fieldset>
                <legend><?= __('Add Product') ?></legend>
                <?=$this->Form->control('category_id', ['options' => $categories]);?>
                <?=$this->Form->control('name', ['value' => 'Cosmetic product 01']);?>
                <div class="input file">
                    <label for="">Images</label>
                </div>
                <!-- <?=
                $this->Form->control('image_products[]', [
                        'type' => 'file',
                        'label' => 'Images',
                        'class' => 'file-0 d-none'
                    ]);
                ?> -->
                <?=$this->Form->button('<i class="bi bi-plus-lg fs-4"></i>Add Image', [
                    'type' => 'button',
                    'id' => 'add-image-button',
                    'class' => 'btn btn-primary btn-lg',
                    'escapeTitle' => false
                ]);?>
                <?=$this->Form->control('made_in', [
                    'options' => ProductsTable::$sponsors
                ]);?>
                <?=$this->Form->control('sponsor_name', [
                    'value' => 'VNSP',
                    'maxLength' => 255
                ]);?>
                <?=$this->Form->control('sponsor_address', [
                    'value' => 'VP',
                    'maxLength' => 255
                ]);?>
                <?=$this->Form->control('sponsor_tel', [
                    'value' => '03-0636-6365',
                    'maxLength' => 15
                ]);?>
                <?=$this->Form->control('description', ['value' => 'product description']);?>
                <?php







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
<?= $this->Html->scriptStart(['block' => true]);?>

<?=$this->Html->scriptEnd();?>
