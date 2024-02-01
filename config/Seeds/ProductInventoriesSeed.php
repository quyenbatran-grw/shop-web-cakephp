<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * ProductInventories seed.
 */
class ProductInventoriesSeed extends AbstractSeed
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
                'product_id' => 1,
                'date' => '2023-06-21 08:26:38',
                'unit_price' => '150000',
                'quantity' => 150,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:26:42',
                'modified' => '2023-06-21 08:26:42',
            ],
            [
                'id' => 2,
                'product_id' => 2,
                'date' => '2023-06-21 08:26:44',
                'unit_price' => '152000',
                'quantity' => 15,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:26:52',
                'modified' => '2023-06-21 08:26:52',
            ],
            [
                'id' => 3,
                'product_id' => 3,
                'date' => '2023-06-21 08:26:54',
                'unit_price' => '153000',
                'quantity' => 150,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:27:02',
                'modified' => '2023-06-21 08:27:02',
            ],
            [
                'id' => 4,
                'product_id' => 1,
                'date' => '2023-06-22 08:27:03',
                'unit_price' => '155000',
                'quantity' => 150,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:27:20',
                'modified' => '2023-06-21 08:27:20',
            ],
            [
                'id' => 5,
                'product_id' => 6,
                'date' => '2023-06-21 08:27:22',
                'unit_price' => '150000',
                'quantity' => 150,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:27:26',
                'modified' => '2023-06-21 08:27:26',
            ],
            [
                'id' => 6,
                'product_id' => 7,
                'date' => '2023-06-21 08:27:27',
                'unit_price' => '157000',
                'quantity' => 130,
                'memo' => 'add inventory',
                'expired_date' => '2024-06-21 08:26:38',
                'created' => '2023-06-21 08:27:36',
                'modified' => '2023-06-21 08:27:36',
            ],
        ];

        $table = $this->table('product_inventories');
        $table->insert($data)->save();
    }
}
