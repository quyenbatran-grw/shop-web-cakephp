<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Table\OrdersTable;
use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string|null $order_number
 * @property int $status
 * @property int $payment_status
 * @property string $order_name
 * @property string $order_address
 * @property string $order_tel
 * @property string $order_amount
 * @property string $paid_amount
 * @property int $payment_point
 * @property string $payment_type
 * @property string|null $memo
 * @property boolean $immediate
 * @property int $delivery_type
 * @property \Cake\I18n\FrozenTime $delivery_start_time
 * @property \Cake\I18n\FrozenTime $delivery_end_time
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\OrderDetail[] $order_details
 */
class Order extends Entity
{
    /**
     * Fields that can be mass assigned using newEntity() or patchEntity().
     *
     * Note that when '*' is set to true, this allows all unspecified fields to
     * be mass assigned. For security purposes, it is advised to set '*' to false
     * (or remove it), and explicitly make individual fields accessible as needed.
     *
     * @var array<string, bool>
     */
    protected $_accessible = [
        'order_number' => true,
        'user_id' => true,
        'status' => true,
        'status_name' => true,
        'payment_status' => true,
        'payment_status_name' => true,
        'order_name' => true,
        'order_address' => true,
        'order_tel' => true,
        'order_amount' => true,
        'paid_amount' => true,
        'payment_point' => true,
        'payment_type' => true,
        'memo' => true,
        'immediate' => true,
        'delivery_type' => true,
        'delivery_start_time' => true,
        'delivery_end_time' => true,
        'created' => true,
        'modified' => true,
        'order_details' => true,
    ];

    /**
     * ステータス名称を取得
     * @return string
     */
    protected function _getStatusName() {
        return OrdersTable::$statusList[$this->status];
    }
}
