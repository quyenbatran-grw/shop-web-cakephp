<?php
use App\Model\Table\MastersTable;
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\Master> $masters
 */
?>
<div class="masters index content">

    <?php
    foreach ($types as $key => $type) {
    ?>
    <div class="border rounded p-2 mt-3">
        <div class="row">
            <div class="col col-md-11">
                <div class="d-flex">
                    <div class=""><?=$type?></div>
                    <div class="ms-3">
                    <?=$this->element('master-edit', ['title' => $type, 'action' => 'add', 'type' => $key])?>
                    </div>
                </div>
            </div>
            <div class="col col-md-1">
                <a class="" data-bs-toggle="collapse" href="#collapseModal<?=$key?>" role="button" aria-expanded="false" aria-controls="madeInMaster"><i class="bi bi-caret-<?=$mode == $key ? 'up' : 'down'?>"></i></a>
            </div>
        </div>
        <div class="collapse table-responsive mt-2 <?=$mode == $key ? 'show' : ''?>" id="collapseModal<?=$key?>">
            <table class="table table-striped table-hover table-bordered">
                <thead>
                    <tr class="text-center">
                        <th>Tên</th>
                        <th>Sắp xếp</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($masters as $master) {
                        if($master->type == $key) {
                    ?>
                    <tr>
                        <td><?=$master->name?></td>
                        <td class="actions w-25 text-center">
                        <?= $this->Html->link(__('<i class="bi bi-chevron-down"></i>'), ['action' => 'moveDown', $master->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Html->link(__('<i class="bi bi-chevron-up"></i>'), ['action' => 'moveUp', $master->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        
                        </td>
                        <td class="actions w-25 text-center">
                        <?=$this->element('master-edit', ['title' => $type, 'master' => $master, 'delete' => true])?>
                        <!-- <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', 1], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?> -->
                        <!-- <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', 1],
                        ['confirm' => __('Are you sure you want to delete # {0}?', 1), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                        </td> -->
                    </tr>
                    <?php
                        }
                    } ?>
                </tbody>
            </table>
        </div>
    </div>
    <?php
    }
    ?>



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
