<?php
/**
 * @var \App\View\AppView $this
 * @var string $title
 * @var string $action
 * @var string $id
 */
if(isset($type)) $id = $type;
if(isset($master)) {
    $id = $master->id;
    $action = 'edit';
}
if(empty($id)) $id = 0;
?>
<!-- Button trigger modal -->
<?php if($action == 'add') { ?>
<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#masterModal<?=$action.$id?>"><i class="bi bi-plus-lg"></i> Thêm</button>
<?php } else { ?>
<button type="button" class="btn btn-outline-primary text-primary" data-bs-toggle="modal" data-bs-target="#masterModal<?=$action.$id?>"><i class="bi bi-pen-fill"></i></button>
<?php } ?>
<?php if(isset($delete)) {?>
<button type="button" class="btn btn-outline-primary text-danger" data-bs-toggle="modal" data-bs-target="#masterDelete<?=$id?>"><i class="bi bi-trash3"></i></button>
<?=$this->Form->create(null, ['url' => ['controller' => 'Masters', 'action' => 'delete', $id], 'class' => ''])?>
<div class="modal fade" id="masterDelete<?=$id?>" tabindex="-1" aria-labelledby="masterDelete<?=$id?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="masterDelete<?=$id?>Label">Xoa</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="text-center">
                Bạn chắc chắn muốn xoá [<?=isset($master) ? $master->name : ''?>]
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Đóng</button>
            <?=$this->Form->button('OK', [
                'class' => 'btn btn-primary w-25',
            ])?>
        </div>
        </div>
    </div>
</div>
<?=$this->Form->end()?>
<?php }?>
<!-- Modal -->
<?=$this->Form->create(null, ['url' => ['controller' => 'Masters', 'action' => $action, $id], 'class' => 'js-validate-form'])?>
<div class="modal fade" id="masterModal<?=$action.$id?>" tabindex="-1" aria-labelledby="masterModal<?=$action.$id?>Label" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="masterModal<?=$action.$id?>Label"><?=isset($title) ? $title : 'Modal Title'?></h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <div class="modal-body">
            <div class="row">
                <div class="col col-md-3">Tên</div>
                <div class="col col-md-8">
                    <?=$this->Form->control('name', [
                        'class' => 'form-control',
                        'label' => false,
                        'required' => true,
                        'error' => true,
                        'autofocus' => true,
                        'value' => isset($master) ? $master['name'] :''
                    ])?>
                </div>
            </div>
        </div>
        <div class="modal-footer justify-content-center">
            <!-- <button type="button" class="btn btn-secondary w-25" data-bs-dismiss="modal">Đóng</button> -->
            <?=$this->Form->button('Lưu', [
                'class' => 'btn btn-primary w-25',
            ])?>
        </div>
        </div>
    </div>
</div>
<?=$this->Form->end()?>
