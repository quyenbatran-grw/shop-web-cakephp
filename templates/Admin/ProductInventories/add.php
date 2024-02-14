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
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="productInventories form content">
            <?= $this->Form->create($productInventory) ?>
            <fieldset>
                <legend><?= __('Nhập kho') ?></legend>
            </fieldset>

            <table class="table">
                <tr>
                    <th class="w-25"><?= __('Sản phẩm') ?></th>
                    <td>
                        <?=$this->Form->control('product_id', [
                            'options' => $products,
                            'class' => 'form-select',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Ngày nhập') ?></th>
                    <td>
                        <?=$this->Form->dateTime('date', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Ngày hết hạn') ?></th>
                    <td>
                        <?=$this->Form->date('expired_date', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Đơn giá') ?></th>
                    <td>
                        <?=$this->Form->control('unit_price', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Số Lượng') ?></th>
                    <td>
                        <?=$this->Form->control('quantity', [
                            'type' => 'number',
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Mô tả') ?></th>
                    <td>
                        <?=$this->Form->control('memo', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>
            </table>

            <div class="d-flex justify-content-between mx-9 my-4">
            <?= $this->Form->button(__('Quay lại'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-4', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button('Lưu', ['type' => 'submit', 'id' => 'save-product-button', 'class' => 'btn btn-primary btn-lg col-4']); ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
