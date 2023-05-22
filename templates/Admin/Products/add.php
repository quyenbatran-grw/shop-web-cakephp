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
    <div class="column-responsive column-80">
        <div class="products form content">
            <?= $this->Form->create($product, ['enctype' => 'multipart/form-data']) ?>
            <fieldset>
                <legend><?= __('Add Product') ?></legend>
                <?=$this->Form->control('category_id', ['options' => $categories]);?>
                <?=$this->Form->control('name');?>
                <?=
                $this->Form->control('image_products[]', [
                        'type' => 'file',
                        'label' => 'Images',
                        'class' => 'file-0'
                    ]);
                ?>
                <?=$this->Form->button('Add Image', ['type' => 'button', 'id' => 'add-image-button']);?>
                <?=$this->Form->control('quantity');?>
                <?=$this->Form->control('unit_price');?>
                <?=$this->Form->control('description');?>
                <?php







                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
<?= $this->Html->scriptStart(['block' => true]);?>

<?=$this->Html->scriptEnd();?>
