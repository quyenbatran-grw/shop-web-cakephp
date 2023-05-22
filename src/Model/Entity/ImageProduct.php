<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ImageProduct Entity
 *
 * @property int $id
 * @property int $product_id
 * @property string $name
 * @property string $file_name
 * @property string $file_type
 * @property int $file_size
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Product $product
 */
class ImageProduct extends Entity
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
        'name' => true,
        'file_name' => true,
        'file_type' => true,
        'file_size' => true,
        'created' => true,
        'modified' => true,
        'product' => true,
    ];
}
