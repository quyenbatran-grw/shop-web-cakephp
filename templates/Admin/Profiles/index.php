<?php
/**
 * @var \App\View\AppView $this
 * @var iterable<\App\Model\Entity\User> $users
 */
?>
<div class="users index content">
    <h3><?= __('Admin Home Page') ?></h3>

    <?php
    echo $this->Html->link('Add Master', 'admin/masters', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Categories', 'admin/categories', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Products', 'admin/products', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Inventories', 'admin/inventory', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage Order', 'admin/orders', [
        'class' => 'btn btn-primary'
    ]);
    ?>

    <?php
    echo $this->Html->link('Manage User', 'admin/list', [
        'class' => 'btn btn-primary'
    ]);
    ?>
</div>
