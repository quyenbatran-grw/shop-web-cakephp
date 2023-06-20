<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * Order Entity
 *
 * @property int $id
 * @property int $product_id
 * @property int|null $user_id
 * @property int|null $order_number
 * @property int $status
 * @property string $order_name
 * @property string $order_address
 * @property string $order_tel
 * @property string $quantity
 * @property string $unit_price
 * @property string $total_price
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Product $product
 * @property \App\Model\Entity\User $user
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
        'product_id' => true,
        'user_id' => true,
        'order_number' => true,
        'status' => true,
        'order_name' => true,
        'order_address' => true,
        'order_tel' => true,
        'quantity' => true,
        'unit_price' => true,
        'total_price' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'product' => true,
        'user' => true,
    ];
}
