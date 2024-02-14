<?php
/**
 * @var \App\View\AppView $this
 * @var string $label
 * @var string $title
 */

?>
<!-- Button trigger modal -->
<!-- <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal"><?=isset($label) ? $label : 'Button'?></button> -->

<!-- Modal -->
<div class="modal fade" id="searchProduct" tabindex="-1" aria-labelledby="searchProductLabel" aria-hidden="true">
<div class="modal-dialog fix-w-80">
    <div class="modal-content">
    <div class="modal-header">
        <h5 class="modal-title" id="searchProductLabel"><?=isset($title) ? $title : 'Modal Title'?></h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
    </div>
    <div class="modal-body">
        <div class="row">
            <div class="col col-md-2">Mã sản phẩm</div>
            <div class="col col-md-3">
                <?=$this->Form->control('name', [
                    'class' => 'form-control',
                    'label' => false
                ])?>
            </div>
        </div>
    </div>
    <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
        <button class="btn btn-primary">OK</button>
    </div>
    </div>
</div>
</div>
