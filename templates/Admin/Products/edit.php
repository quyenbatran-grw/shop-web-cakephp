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
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="products form content">
            <?= $this->Form->create($product, ['enctype' => 'multipart/form-data', 'class' => 'js-validate-form']) ?>
            <fieldset>
                <legend><?= __('Sửa thông tin sản phẩm') ?></legend>
            </fieldset>

            <table class="table">
                <tr>
                    <th class="w-25"><?=__('Danh mục*')?></th>
                    <td>
                        <?=$this->Form->control('category_id', [
                        'options' => $categories,
                        'class' => 'form-select',
                        'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Tên sản phẩm*')?></th>
                    <td>
                        <?=$this->Form->control('name', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?= __('Ngày nhập*') ?></th>
                    <td>
                        <?=$this->Form->dateTime('import_date', [
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
                    <th class="w-25"><?=__('Mã vạch')?></th>
                    <td>
                        <?=$this->Form->control('barcode', [
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Số lượng*')?></th>
                    <td>
                        <?=$this->Form->control('quantity', [
                            'class' => 'form-control',
                            'required' => false,
                            'type' => 'number',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Giá nhập*')?></th>
                    <td>
                        <?=$this->Form->control('unit_price', [
                            'class' => 'form-control',
                            'required' => false,
                            'type' => 'number',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Giá bán lẻ*')?></th>
                    <td>
                        <?=$this->Form->control('sell_price', [
                            'class' => 'form-control',
                            'required' => false,
                            'type' => 'number',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Giá bán buôn')?></th>
                    <td>
                        <?=$this->Form->control('sell_price_2', [
                            'class' => 'form-control',
                            'required' => false,
                            'type' => 'number',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Trọng lượng/đơn vị')?></th>
                    <td>
                        <div class="d-flex">
                        <?=$this->Form->control('wet', [
                            'class' => 'form-control',
                            'required' => false,
                            'type' => 'number',
                            'label' => false
                        ]);?>
                        <?=$this->Form->control('unit', [
                            'class' => 'form-select ms-2',
                            'label' => false
                        ]);?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Hình ảnh')?></th>
                    <td>
                        <?=$this->Form->button('<i class="bi bi-plus-lg fs-4"></i>Thêm ảnh', [
                            'type' => 'button',
                            'id' => 'add-image-button',
                            'class' => 'btn btn-primary btn-lg',
                            'escapeTitle' => false
                        ]);?>
                        <div class="image_list mt-4 row row-cols-2 row-cols-lg-2 g-2 g-lg-3">
                            <input type="hidden" name="deleted_img">
                            <?php foreach ($product->image_products as $key => $value) { ?>
                            <div class="col img-group col-mb-2">
                                <div class="show-image w-75 d-flex">
                                    <div class="image"><img src="/img/products/<?=$value['file_name']?>" alt=""></div>

                                    <button type="button" class="btn-danger delete-image-button" delete-id="<?=$value['id']?>"><i class="bi bi-x-lg"></i></button>
                                </div>

                            </div>

                            <?php } ?>
                        </div>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Xuất xứ')?></th>
                    <td>
                        <?=$this->Form->control('original_id', [
                            'options' => $originals,
                            'required' => false,
                            'class' => 'form-select',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Nhà phân phối')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_id', [
                            'options' => $sponsors,
                            'required' => false,
                            'class' => 'form-select',
                            'label' => false,
                        ]);?>
                    </td>
                </tr>

                

                <tr>
                    <th class="w-25"><?=__('Mô tả')?></th>
                    <td>
                        <?=$this->Form->control('description', [
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
