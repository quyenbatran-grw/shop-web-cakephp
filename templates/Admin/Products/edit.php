<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 * @var string[]|\Cake\Collection\CollectionInterface $categories
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
            <?= $this->Form->create($product) ?>
            <fieldset>
                <legend><?= __('Edit Product') ?></legend>
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
                        <div class="input file">
                            <div class="row align-items-start">
                                <?php foreach ($product->image_products as $key => $value) { ?>

                                <div class="col col-md-4">
                                    <img src="/img/products/<?=$value['file_name']?>" alt="">
                                </div>
                                <?php } ?>
                            </div>
                        </div>
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
                            'label' => false
                        ]);?>
                    </td>
                </tr>
            </table>

            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Back'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Submit'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
