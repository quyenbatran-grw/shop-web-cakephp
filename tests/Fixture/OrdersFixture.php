<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * OrdersFixture
 */
class OrdersFixture extends TestFixture
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
                'order_number' => 'Lorem ipsum dolor sit amet',
                'status' => 1,
                'order_name' => 'Lorem ipsum dolor sit amet',
                'order_address' => 'Lorem ipsum dolor sit amet',
                'order_tel' => 'Lorem ipsum dolor sit amet',
                'order_amount' => 1.5,
                'memo' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-06-22 01:15:36',
                'modified' => '2023-06-22 01:15:36',
            ],
        ];
        parent::init();
    }
}
