<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Master> $masters
 */
?>
<div class="masters index content">
    <div class="border rounded p-2">
        <div class="row">
            <div class="col col-md-11">
                <div class="d-flex">
                    <div class="">Nhà phân phối</div>
                    <div class="ms-3">
                    <?=$this->element('master-edit', ['title' => 'Nhà phân phối', 'type' => 1, 'id' => null])?>
                    </div>
                </div>
            </div>
            <div class="col col-md-1">
                <a class="" data-bs-toggle="collapse" href="#sponsorMaster" role="button" aria-expanded="false" aria-controls="sponsorMaster"><i class="bi bi-caret-down"></i></a>
            </div>
        </div>
        <div class="collapse table-responsive mt-2" id="sponsorMaster">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Tên</th>
                        <th>Sắp xếp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A1</td>
                        <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('<i class="bi bi-chevron-down"></i>'), ['action' => 'view', 1], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-chevron-up"></i>'), ['action' => 'edit', 2], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        
                        </td>
                        <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', 1], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', 1],
                        ['confirm' => __('Are you sure you want to delete # {0}?', 1), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="border rounded p-2 mt-3">
        <div class="row">
            <div class="col col-md-11">
                <div class="d-flex">
                    <div class="">Xuất xứ</div>
                    <div class="ms-3">
                    <?=$this->Form->button('<i class="bi bi-plus-lg"></i> Thêm', [
                        'class' => 'btn btn-primary',
                        'escapeTitle' => false
                    ])?>
                    </div>
                </div>
            </div>
            <div class="col col-md-1">
                <a class="" data-bs-toggle="collapse" href="#madeInMaster" role="button" aria-expanded="false" aria-controls="madeInMaster"><i class="bi bi-caret-down"></i></a>
            </div>
        </div>
        <div class="collapse table-responsive mt-2" id="madeInMaster">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Tên</th>
                        <th>Sắp xếp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>A1</td>
                        <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('<i class="bi bi-chevron-down"></i>'), ['action' => 'view', 1], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-chevron-up"></i>'), ['action' => 'edit', 2], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        
                        </td>
                        <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', 1], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', 1],
                        ['confirm' => __('Are you sure you want to delete # {0}?', 1), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>



    <br>
    <?php if($this->Paginator->param('pageCount') > 1) { ?>
    <div class="paginator">
        <ul class="pagination justify-content-center">
            <?= $this->Paginator->first('<< ') ?>
            <?= $this->Paginator->prev('< ') ?>
            <?= $this->Paginator->numbers() ?>
            <?= $this->Paginator->next(' >') ?>
            <?= $this->Paginator->last(' >>') ?>
        </ul>
    </div>
    <?php } ?>
</div>
