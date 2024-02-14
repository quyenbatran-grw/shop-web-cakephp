<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Product $product
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="products view content">
            <h3><?= h($product->name) ?></h3>
            <table class="table">
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= number_format($product->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tên sản phẩm') ?></th>
                    <td><?= h($product->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Danh mục') ?></th>
                    <td><?= $product->has('category') ? $this->Html->link($product->category->name, ['controller' => 'Categories', 'action' => 'view', $product->category->id]) : '' ?></td>
                </tr>
                <tr>
                    <th><?= __('Xuất xứ') ?></th>
                    <td><?= $product->made_name ?></td>
                </tr>
                <tr>
                    <th><?= __('Nhà phân phối') ?></th>
                    <td><?= $product->sponsor_name ?></td>
                </tr>
                <tr>
                    <th><?= __('Mô tả') ?></th>
                    <td>
                        <blockquote>
                            <?= $this->Text->autoParagraph(h($product->description)); ?>
                        </blockquote>
                    </td>
                </tr>
            </table>
            <div class="related">
                <h4><?= __('Hình ảnh') ?></h4>
                <?php if (!empty($product->image_products)) : ?>
                <div class="row align-items-start">
                    <?php foreach ($product->image_products as $key => $value) { ?>

                    <div class="col col-md-4">
                        <img src="/img/products/<?=$value['file_name']?>" alt="">
                    </div>
                    <?php } ?>
                </div>
                <?php endif; ?>
            </div>

            <?=$this->Form->create(null, ['url' => ['controller' => 'Products', 'action' => 'edit', $product->id], 'type' => 'get']);?>
            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Quay lại'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Sửa'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?=$this->Form->end();?>
        </div>
    </div>
</div>
