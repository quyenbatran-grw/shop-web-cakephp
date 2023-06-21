<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ShoppingCart Entity
 *
 * @property int $id
 * @property int|null $user_id
 * @property int|null $device_token_id
 * @property int $category_id
 * @property int $product_id
 * @property int $quantity
 *
 * @property \App\Model\Entity\User $user
 * @property \App\Model\Entity\DeviceToken $device_token
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\Product $product
 */
class ShoppingCart extends Entity
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
        'user_id' => true,
        'device_token_id' => true,
        'category_id' => true,
        'product_id' => true,
        'quantity' => true,
        'user' => true,
        'device_token' => true,
        'category' => true,
        'product' => true,
    ];
}
