<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <!-- <h4 class="heading"><?= __('Sửa danh mục') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item text-decoration-none']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="categories form content">
            <?= $this->Form->create($category) ?>
            <fieldset>
                <legend><?= __('Sửa danh mục') ?></legend>
            </fieldset>
            <table class="table">
                <tr>
                    <th class="w-25"><?=__('Tên danh mục*')?></th>
                    <td><?=$this->Form->control('name', [
                        'class' => 'form-control',
                        'required' => true,
                        'label' => false
                    ]);?></td>
                </tr>
                <tr>
                    <th class="w-25"><?=__('Mô tả')?></th>
                    <td><?=$this->Form->control('description', [
                        'class' => 'form-control',
                        'required' => false,
                        'label' => false
                    ]);?></td>
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
