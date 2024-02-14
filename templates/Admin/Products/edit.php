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
            <?= $this->Form->create($product, ['enctype' => 'multipart/form-data', 'id' => 'js-validate-form']) ?>
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
                            'value' => 'Cosmetic product 01',
                            'class' => 'form-control',
                            'label' => false
                        ]);?>
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
                    <th class="w-25"><?=__('Xuất xứ*')?></th>
                    <td>
                        <?=$this->Form->control('made_in', [
                            'options' => ProductsTable::$sponsors,
                            'class' => 'form-select',
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Nhà phân phối')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_name', [
                            'class' => 'form-control',
                            'maxLength' => 255,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('Địa chỉ nhà PP')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_address', [
                            'class' => 'form-control',
                            'maxLength' => 255,
                            'label' => false
                        ]);?>
                    </td>
                </tr>

                <tr>
                    <th class="w-25"><?=__('SĐT nhà PP*')?></th>
                    <td>
                        <?=$this->Form->control('sponsor_tel', [
                            'class' => 'form-control',
                            'maxLength' => 15,
                            'label' => false
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
