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
            </fieldset>
            <table class="table">
                <tr>
                    <th class="w-25"><?=__('Category')?></th>
                    <td>
                        <?=$this->Form->control('category_id', [
                        'options' => $categories,
                        'class' => 'form-select',
                        'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Name')?></th>
                    <td>
                        <?=$this->Form->control('name', [
                            'value' => 'Cosmetic product 01',
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Images')?></th>
                    <td>
                        <?=$this->Form->button('<i class="bi bi-plus-lg fs-4"></i>Add Image', [
                            'type' => 'button',
                            'id' => 'add-image-button',
                            'class' => 'btn btn-primary btn-lg',
                            'escapeTitle' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Madein')?></th>
                    <td>
                        <?=$this->Form->control('made_in', [
                            'options' => ProductsTable::$sponsors,
                            'class' => 'form-select',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Sponsor')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_name', [
                            'class' => 'form-control',
                            'value' => 'VNSP',
                            'maxLength' => 255,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Sponsor Address')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_address', [
                            'class' => 'form-control',
                            'value' => 'VP',
                            'maxLength' => 255,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Sponsor TEL')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_tel', [
                            'class' => 'form-control',
                            'value' => '03-0636-6365',
                            'maxLength' => 15,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Description')?></th>
                    <td>
                        <?=$this->Form->control('description', [
                            'class' => 'form-control',
                            'value' => 'product description',
                            'label' => false
                        ]);?>
                    </td>
                </tr>
            </table>

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
