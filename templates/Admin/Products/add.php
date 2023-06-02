<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var \Cake\Collection\CollectionInterface|string[] $categories
 */
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
                <?=$this->Form->control('name', ['value' => 'name']);?>
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
                <?=$this->Form->control('quantity', ['value' => 2]);?>
                <?=$this->Form->control('unit_price', ['value' => 10]);?>
                <?=$this->Form->control('description', ['value' => 'asbd']);?>
                <?php







                ?>
            </fieldset>

            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button('Submit', ['type' => 'submit', 'id' => 'save-product-button', 'class' => 'btn btn-primary btn-lg col-3']); ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?= $this->Html->scriptStart(['block' => true]);?>

<?=$this->Html->scriptEnd();?>
