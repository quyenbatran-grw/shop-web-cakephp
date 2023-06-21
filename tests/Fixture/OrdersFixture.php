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
                'product_id' => 1,
                'user_id' => 1,
                'order_number' => 1,
                'status' => 1,
                'order_name' => 'Lorem ipsum dolor sit amet',
                'order_address' => 'Lorem ipsum dolor sit amet',
                'order_tel' => 'Lorem ipsum d',
                'quantity' => 'Lorem ipsum dolor sit amet',
                'unit_price' => 1.5,
                'total_price' => 1.5,
                'memo' => 'Lorem ipsum dolor sit amet, aliquet feugiat. Convallis morbi fringilla gravida, phasellus feugiat dapibus velit nunc, pulvinar eget sollicitudin venenatis cum nullam, vivamus ut a sed, mollitia lectus. Nulla vestibulum massa neque ut et, id hendrerit sit, feugiat in taciti enim proin nibh, tempor dignissim, rhoncus duis vestibulum nunc mattis convallis.',
                'created' => '2023-06-06 08:55:50',
                'modified' => '2023-06-06 08:55:50',
            ],
        ];
        parent::init();
    }
}
