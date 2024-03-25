<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * OrderDetails seed.
 */
class OrderDetailsSeed extends AbstractSeed
{
    /**
     * Run Method.
     *
     * Write your database seeder using this method.
     *
     * More information on writing seeds is available here:
     * https://book.cakephp.org/phinx/0/en/seeding.html
     *
     * @return void
     */
    public function run(): void
    {
        $data = [
            [
                'id' => 1,
                'order_id' => 1,
                'product_id' => 2,
                'quantity' => '20',
                'unit_price' => '32000',
                'amount' => '640000',
                'memo' => NULL,
                'created' => '2024-03-09 02:16:59',
                'modified' => '2024-03-09 02:16:59',
            ],
            [
                'id' => 2,
                'order_id' => 2,
                'product_id' => 2,
                'quantity' => '1',
                'unit_price' => '32000',
                'amount' => '32000',
                'memo' => NULL,
                'created' => '2024-03-09 15:08:12',
                'modified' => '2024-03-09 15:08:12',
            ],
            [
                'id' => 6,
                'order_id' => 6,
                'product_id' => 2,
                'quantity' => '1',
                'unit_price' => '32000',
                'amount' => '32000',
                'memo' => NULL,
                'created' => '2024-03-09 15:22:39',
                'modified' => '2024-03-09 15:22:39',
            ],
            [
                'id' => 7,
                'order_id' => 7,
                'product_id' => 2,
                'quantity' => '3',
                'unit_price' => '32000',
                'amount' => '96000',
                'memo' => NULL,
                'created' => '2024-03-09 15:25:22',
                'modified' => '2024-03-09 15:25:22',
            ],
            [
                'id' => 8,
                'order_id' => 8,
                'product_id' => 1,
                'quantity' => '1',
                'unit_price' => '60000',
                'amount' => '60000',
                'memo' => NULL,
                'created' => '2024-03-09 15:36:52',
                'modified' => '2024-03-09 15:36:52',
            ],
            [
                'id' => 9,
                'order_id' => 9,
                'product_id' => 2,
                'quantity' => '4',
                'unit_price' => '32000',
                'amount' => '128000',
                'memo' => NULL,
                'created' => '2024-03-09 15:37:21',
                'modified' => '2024-03-09 15:37:21',
            ],
            [
                'id' => 10,
                'order_id' => 9,
                'product_id' => 1,
                'quantity' => '1',
                'unit_price' => '60000',
                'amount' => '60000',
                'memo' => NULL,
                'created' => '2024-03-09 15:37:21',
                'modified' => '2024-03-09 15:37:21',
            ],
        ];

        $table = $this->table('order_details');
        $table->insert($data)->save();
    }
}
