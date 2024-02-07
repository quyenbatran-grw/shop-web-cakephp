<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <div class="row justify-content-around mt-2">
        <h3 class="col col-md-4"><?= __('Admin Users') ?></h3>
        <div class="col col-md-8 text-end">
            <a href="/shops/logout/" class="btn btn-primary">Logout</a>
        </div>
    </div>
    <table class="table">
        <tr>
            <th class="w-25">Username</th>
            <td><?=$profile->username?></td>
        </tr>

        <tr>
            <th class="w-25">First Name</th>
            <td><?=$profile->first_name?></td>
        </tr>

        <tr>
            <th class="w-25">Last Name</th>
            <td><?=$profile->last_name?></td>
        </tr>

        <tr>
            <th class="w-25">Email</th>
            <td><?=$profile->email?></td>
        </tr>

        <tr>
            <th class="w-25">TEL</th>
            <td><?=$profile->tel?></td>
        </tr>

        <tr>
            <th class="w-25">Address</th>
            <td><?=$profile->address?></td>
        </tr>
    </table>

    <div class="row justify-content-around mt-5">
        <?= $this->Html->link(__('Back'), ['controller' => 'Profiles', 'action' => 'index'], ['class' => 'btn btn-secondary col-3']) ?>
        <?= $this->Html->link(__('Next'), ['controller' => 'Profiles', 'action' => 'edit', $profile->id], ['class' => 'btn btn-primary col-3']) ?>
    </div>
</div>
