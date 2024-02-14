<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\User $user
 */
?>

<div class="row">
    <aside class="column">

    </aside>
    <div class="column-responsive column-80">
        <div class="menu-link-list">
        <?=$this->Html->link(
            '<i class="bi bi-caret-left"></i>Quay Lại',
            ['controller' => 'Profiles', 'action' => 'order-list'],
            ['escape' => false, 'escapeTitle' => false, 'class' => 'text-decoration-none']
        );?>
        </div>
        <div class="form content">
        <h3 class="text-center"><?=__(MSG_1002)?></h3>
        </div>
    </div>
</div>
