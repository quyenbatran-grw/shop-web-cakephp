<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\ProductInventory $productInventory
 * @var string[]|\Cake\Collection\CollectionInterface $products
 */

use App\Model\Entity\ProductInventory;

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
                <legend><?= __('Sửa thông tin') ?></legend>
            </fieldset>
            <table class="table">
                <tr>
                    <th class="w-25"><?= __('Sản phẩm*') ?></th>
                    <td>
                        <?=$this->Form->control('product_id', [
                            'options' => $products,
                            'class' => 'form-select',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Ngày nhập*') ?></th>
                    <td>
                        <?=$this->Form->date('date', [
                            'class' => 'form-control',
                            'required' => true,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Ngày hết hạn') ?></th>
                    <td>
                        <?=$this->Form->date('expired_date', [
                            'class' => 'form-control',
                            'required' => false,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Đơn giá*') ?></th>
                    <td>
                        <?=$this->Form->control('unit_price', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Số lượng*') ?></th>
                    <td>
                        <?=$this->Form->control('quantity', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Đơn vị*') ?></th>
                    <td>
                        <?=$this->Form->control('unit', [
                            'class' => 'form-select',
                            'label' => false,
                            'options' => ProductInventory::$units
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

            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Quay lại'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Lưu'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
