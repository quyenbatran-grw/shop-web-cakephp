<?php
/**
 * @var \App\View\AppView $this
 * @var \App\Model\Entity\Order $order
 */
?>
<div class="row">
    <aside class="column">
        <div class="side-nav">
            <h4 class="heading"><?= __('Actions') ?></h4>
            <?= $this->Html->link(__('List Orders'), ['action' => 'index'], ['class' => 'side-nav-item']) ?>
        </div>
    </aside>
    <div class="column-responsive column-80">
        <div class="orders form content">
            <legend><?= __('Add Order') ?></legend>
            <?= $this->Form->create($order) ?>
            <table class="table">
                <tr>
                    <th><?= __('Order Name') ?></th>
                    <td><?=$this->Form->control('order_number', [
                            'class' => 'form-control',
                            'label' => false,
                            'multiple' => false,
                        ])?></td>
                </tr>

                <tr>
                    <th><?= __('Order Status') ?></th>
                    <td><?=$this->Form->control('status', [
                            'class' => 'form-select w-25',
                            'options' => $status_list,
                            'label' => false,
                            'multiple' => false,
                            'onChange' => 'changeStatusConfirm'
                        ])?></td>
                </tr>
            </table>
            <fieldset>
                <?php
                    echo $this->Form->control('order_number');
                    echo $this->Form->control('status');
                    echo $this->Form->control('order_name');
                    echo $this->Form->control('order_address');
                    echo $this->Form->control('order_tel');
                    echo $this->Form->control('order_amount');
                    echo $this->Form->control('memo');
                ?>
            </fieldset>
            <?= $this->Form->button(__('Submit')) ?>
            <?= $this->Form->end() ?>
        </div>
    </div>
</div>
