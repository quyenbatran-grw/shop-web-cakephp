<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrderDetailsFixture
 */
class OrderDetailsFixture extends TestFixture
{
    /**
     * Init method
     *
     * @return void
     */
    public function init(): void
    {
        $this->records = [
            [
                'id' => 1,
                'order_id' => 1,
                'product_id' => 1,
                'quantity' => 1,
                'unit_price' => 1.5,
                'amount' => 1.5,
                'created' => '2023-06-22 01:15:40',
                'modified' => '2023-06-22 01:15:40',
            ],
        ];
        parent::init();
    }
}
