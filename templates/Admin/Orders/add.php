<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
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
        <div class="orders form content">
            <legend><?= __('Thêm đơn hàng') ?></legend>
            <?= $this->Form->create($order) ?>
            <table class="table">
                <tr>
                    <th><?= __('Tên khách hàng*') ?></th>
                    <td class="">
                        <div class="row">
                            <div class="col col-md-8">
                            <?=$this->Form->control('order_name', [
                                'class' => 'form-control',
                                'label' => false,
                                'multiple' => false,
                                'required' => true
                            ])?>
                            </div>

                            <div class="col col-md-3">
                            <?=$this->Form->button('<i class="bi bi-search"></i>', [
                                'class' => 'btn btn-success',
                                'escapeTitle' => false,
                                'type' => 'button'
                            ])?>
                            </div>
                        </div>


                    </td>
                </tr>

                <tr>
                    <th><?= __('Địa chỉ*') ?></th>
                    <td class="row">
                        <div class="col">
                        <?=$this->Form->control('order_address', [
                            'class' => 'form-control',
                            'label' => false,
                            'multiple' => false,
                            'required' => true
                        ])?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th><?= __('SĐT*') ?></th>
                    <td class="row">
                        <div class="col col-md-8">
                        <?=$this->Form->control('order_tel', [
                            'class' => 'form-control',
                            'label' => false,
                            'multiple' => false,
                            'required' => true
                        ])?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th><?= __('Trạng thái') ?></th>
                    <td>
                        <div class="col col-md-4">
                        <?=$this->Form->control('status', [
                            'class' => 'form-select',
                            'options' => $status_list,
                            'label' => false,
                        ])?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th><?= __('Ghi chú') ?></th>
                    <td>
                        <div class="col col-md-4">
                        <?=$this->Form->control('memo', [
                            'class' => 'form-control',
                            'label' => false,
                        ])?>
                        </div>
                    </td>
                </tr>
            </table>

            <legend><?= __('Sản phẩm') ?></legend>
            <table class="table add-order">
                <thead>
                    <tr>
                        <th>Sản phẩm</th>
                        <th>Đơn vị</th>
                        <th>Đơn giá</th>
                        <th>Số lượng</th>
                        <th>Tổng tiền</th>
                    </tr>
                </thead>

                <tbody>
                    <tr row="1">
                        <td>
                            <?=$this->Form->control('product', [
                                'class' => 'form-control product-name',
                                'label' => false
                            ])?>
                        </td>

                        <td>
                            <?=$this->Form->control('unit', [
                                'class' => 'form-control',
                                'label' => false
                            ])?>
                        </td>

                        <td>
                            <?=$this->Form->control('unit_price', [
                                'class' => 'form-control',
                                'label' => false
                            ])?>
                        </td>

                        <td>
                            <?=$this->Form->control('quantity', [
                                'class' => 'form-control',
                                'label' => false
                            ])?>
                        </td>

                        <td>1234</td>
                    </tr>
                </tbody>
            </table>
            <?= $this->Form->end() ?>
        </div>

        <?=$this->element('search-product', ['label' => 'Hủy', 'title' => 'Tìm sản phẩm'])?>
    </div>
</div>
