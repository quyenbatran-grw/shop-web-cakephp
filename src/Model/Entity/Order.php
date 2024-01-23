<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property string|null $order_number
 * @property int $status
 * @property string $order_name
 * @property string $order_address
 * @property string $order_tel
 * @property string $order_amount
 * @property string $payment_type
 * @property string|null $memo
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
    const PREPARING_STATUS = 0;
    const PAID_STATUS = 1;
    const DELIVERING_STATUS = 2;
    const DELIVERED_STATUS = 3;
    const CANCELED_STATUS = 4;
    public static $statusList = [
        self::PREPARING_STATUS => 'PREPARING'
    ,   self::PAID_STATUS => 'PAID'
    ,   self::DELIVERING_STATUS => 'DELIVERING'
    ,   self::DELIVERED_STATUS => 'DELIVERED'
    ,   self::CANCELED_STATUS => 'CANCELED'
    ];
    protected $_accessible = [
        'order_number' => true,
        'status' => true,
        'order_name' => true,
        'order_address' => true,
        'order_tel' => true,
        'order_amount' => true,
        'payment_type' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'order_details' => true,
    ];

    protected function _getStatusName() {
        return self::$statusList[$this->status];
    }
}
