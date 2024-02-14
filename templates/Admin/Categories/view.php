<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Category $category
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <!-- <h4 class="heading"><?= __('Actions') ?></h4> -->
            <?= $this->Html->link(__('Quay lại'), ['action' => 'index'], ['class' => 'side-nav-item text-decoration-none']) ?>
        </div>
    </aside>
    <div class="column-responsive">
        <div class="categories view content">
            <h3><?= h($category->name) ?></h3>
            <table class="table">
                <tr>
                    <th><?= __('ID') ?></th>
                    <td><?= $this->Number->format($category->id) ?></td>
                </tr>
                <tr>
                    <th><?= __('Tên danh mục') ?></th>
                    <td><?= h($category->name) ?></td>
                </tr>
                <tr>
                    <th><?= __('Mô tả') ?></th>
                    <td>
                        <blockquote>
                            <?= $this->Text->autoParagraph(h($category->description)); ?>
                        </blockquote>
                    </td>
                </tr>
            </table>

            <?=$this->Form->create(null, ['url' => ['controller' => 'Categories', 'action' => 'edit', $category->id], 'type' => 'get']);?>
            <div class="row justify-content-between col-md-7 mx-auto mt-5">
            <?= $this->Form->button(__('Quay lại'), ['type' => 'button', 'class' => 'btn btn-secondary btn-lg col-3', 'onclick' => 'history.back()']) ?>
            <?= $this->Form->button(__('Sửa'), ['class' => 'btn btn-primary btn-lg col-3']) ?>
            </div>
            <?=$this->Form->end();?>
        </div>
    </div>
</div>
