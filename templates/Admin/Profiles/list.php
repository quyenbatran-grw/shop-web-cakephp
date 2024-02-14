<?php
use App\Model\Table\UsersTable;
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <?=$this->Form->create()?>
    <div class="row mt-4 pb-2">
        <div class="col col-md-2">Họ</div>
        <div class="col col-md-3">
            <?=$this->Form->control('first_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'User',
                'value' => isset($searchParam['first_name']) ? $searchParam['first_name'] : ''
            ])?>
        </div>

        <div class="col col-md-2">Tên</div>
        <div class="col col-md-3">
            <?=$this->Form->control('last_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'User',
                'value' => isset($searchParam['last_name']) ? $searchParam['last_name'] : ''
            ])?>
        </div>
    </div>
    <div class="row justify-content-center mt-4 mb-3 border-bottom p-4">
        <div class="col col-md-2">
            <?=$this->Form->button('<i class="bi bi-search"></i> Tìm kiếm', [
                'class' => 'btn btn-success w-100',
                'escapeTitle' => false
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('<i class="bi bi-x-circle"></i> Xóa', ['action' => ''], [
                'class' => 'btn btn-primary w-100',
                'escapeTitle' => false
            ])?>
        </div>
    </div>
    <?=$this->Form->end()?>

    <div class="row pb-3">
        <div class="col col-md-2"><h3><?= __('Danh sách tài khoản') ?></h3></div>
        <!-- <div class="col col-md-10 text-end">
            <?=$this->Html->link('Point Rate', '/admin/profiles/point', [
                'class' => 'btn btn-primary'
            ])?>
        </div> -->
    </div>


    <div class="table-responsive">
        <table class="table table-striped table-hover table-bordered">
            <thead class="text-center">
                <tr>
                    <th><?= $this->Paginator->sort('id', 'ID') ?></th>
                    <th><?= $this->Paginator->sort('username', 'Tài khoản') ?></th>
                    <th><?= $this->Paginator->sort('first_name', 'Họ') ?></th>
                    <th><?= $this->Paginator->sort('last_name', 'Tên') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('tel', 'SĐT') ?></th>
                    <th><?= $this->Paginator->sort('point', 'Điểm tích lũy') ?></th>
                    <th class="actions"><?= __('') ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($users as $user) { ?>
                <tr>
                    <td><?=$user->id?></td>
                    <td><?=h($user->username)?></td>
                    <td><?=h($user->first_name)?></td>
                    <td><?=h($user->last_name)?></td>
                    <td><?=h($user->email)?></td>
                    <td><?=h($user->tel)?></td>
                    <td class="text-end"><?=number_format($user->point)?></td>
                    <td class="actions text-center">
                        <?= $this->Html->link(__('<i class="bi bi-pen-fill"></i>'), ['action' => 'edit', $user->id], ['escapeTitle' => false, 'class' => 'border border-primary rounded text-primary']) ?>
                        <?= $this->Form->postLink(__('<i class="bi bi-trash3"></i>'),
                        ['action' => 'delete', $user->id],
                        ['confirm' => __('Are you sure you want to delete # {0}?', $user->id), 'escapeTitle' => false, 'class' => 'border border-danger rounded text-danger']) ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
