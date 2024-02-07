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
        <div class="col col-md-1">First Name</div>
        <div class="col col-md-2">
            <?=$this->Form->control('first_name', [
                'class' => 'form-control',
                'label' => false,
                'placeholder' => 'User',
                'value' => isset($searchParam['first_name']) ? $searchParam['first_name'] : ''
            ])?>
        </div>

        <div class="col col-md-1">Last Name</div>
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
            <?=$this->Form->button('Search', [
                'class' => 'btn btn-primary w-100'
            ])?>
        </div>
        <div class="col col-md-2"></div>
        <div class="col col-md-2">
            <?=$this->Html->link('Clear', ['action' => ''], [
                'class' => 'btn btn-primary w-100'
            ])?>
        </div>
    </div>
    <?=$this->Form->end()?>

    <div class="row pb-3">
        <div class="col col-md-2"><h3><?= __('User List') ?></h3></div>
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
                    <th><?= $this->Paginator->sort('id') ?></th>
                    <th><?= $this->Paginator->sort('username') ?></th>
                    <th><?= $this->Paginator->sort('first_name') ?></th>
                    <th><?= $this->Paginator->sort('last_name') ?></th>
                    <th><?= $this->Paginator->sort('email') ?></th>
                    <th><?= $this->Paginator->sort('tel') ?></th>
                    <th><?= $this->Paginator->sort('point') ?></th>
                    <th class="actions"><?= __('Actions') ?></th>
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
                        <!-- <?= $this->Html->link(__('View'), ['action' => 'view', $user->id]) ?> -->
                        <?= $this->Html->link(__('Edit'), ['action' => 'edit', $user->id]) ?>
                        <?= $this->Form->postLink(__('Delete'), ['action' => 'delete', $user->id], ['confirm' => __('Are you sure you want to delete # {0}?', $user->id)]) ?>
                    </td>
                </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>
