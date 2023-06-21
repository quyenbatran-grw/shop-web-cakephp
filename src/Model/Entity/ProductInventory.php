<?php
declare(strict_types=1);

namespace App\Model\Entity;

use Cake\ORM\Entity;

/**
 * ProductInventory Entity
 *
 * @property int $id
 * @property int $product_id
 * @property \Cake\I18n\FrozenTime $date
 * @property string $unit_price
 * @property int $quantity
 * @property string|null $memo
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Product $product
 */
class ProductInventory extends Entity
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
        'date' => true,
        'unit_price' => true,
        'quantity' => true,
        'memo' => true,
        'created' => true,
        'modified' => true,
        'product' => true,
    ];

    /**
     * 単価のフォマット
     *
     * @return string
     */
    protected function _getPrice()
    {
        return number_format((float)$this->unit_price);
    }

    /**
     * 単価の1000単位のフォマット
     *
     * @return string
     */
    protected function _getPriceK()
    {
        return number_format((float)$this->unit_price / 1000);
    }

    /**
     * 数量のフォマット
     *
     * @return string
     */
    protected function _getQuantityFormat()
    {
        return number_format((float)$this->quantity);
    }
}