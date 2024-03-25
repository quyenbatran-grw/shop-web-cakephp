<?php
declare(strict_types=1);

namespace App\Model\Entity;

use App\Model\Table\ProductsTable;
use Cake\ORM\Entity;

/**
 * Product Entity
 *
 * @property int $id
 * @property int $category_id
 * @property string $name
 * @property int $imported_quantity
 * @property int $quantity
 * @property int $unit_price
 * @property int $sell_price
 * @property int $sell_price_2
 * @property string $unit_price
 * @property string $description
 * @property \Cake\I18n\FrozenTime $created
 * @property \Cake\I18n\FrozenTime $modified
 *
 * @property \App\Model\Entity\Category $category
 * @property \App\Model\Entity\ImageProduct[] $image_products
 */
class Product extends Entity
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
        'category_id' => true,
        'name' => true,
        'import_date' => true,
        'expired_date' => true,
        'barcode' => true,
        'original_id' => true,
        'sponsor_id' => true,
        'imported_quantity' => true,
        'quantity' => true,
        'unit_price' => true,
        'sell_price' => true,
        'sell_price_2' => true,
        'wet' => true,
        'unit' => true,
        'description' => true,
        'created' => true,
        'modified' => true,
        'category' => true,
        'originals_masters' => true,
        'sponsors_masters' => true,
        'image_products' => true,
    ];

    protected $_virtual = ['made_name'];

    protected function _getMadeName() {
        return $this->made_in != '' ? ProductsTable::$sponsors[$this->made_in] : '';
    }

    /**
     * 購入単価 
     * 
     * @return string
     */
    public function _getUnitPriceF() {
        $price = '0';
        if(preg_match('/\d/', $this->unit_price)) {
            $price = number_format((double)$this->unit_price);
        }
        return $price;
    }

    /**
     * 販売単価 
     * 
     * @return string
     */
    protected function _getSellPriceF() {
        $sell_price = '0';
        if(preg_match('/\d/', $this->sell_price)) {
            $sell_price = number_format((double)$this->sell_price);
        }
        return $sell_price;
    }


}
