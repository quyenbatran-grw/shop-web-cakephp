<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Products seed.
 */
class ProductsSeed extends AbstractSeed
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
                'id' => 17,
                'category_id' => 2,
                'name' => 'product life 1',
                'quantity' => 10,
                'unit_price' => '122.00',
                'description' => 'product life 1 description
product life 1 description
product life 1 description',
                'created' => '2023-05-23 00:30:16',
                'modified' => '2023-05-23 00:30:16',
            ],
            [
                'id' => 18,
                'category_id' => 2,
                'name' => 'life product 2',
                'quantity' => 10,
                'unit_price' => '100.00',
                'description' => 'life product 2 detail info
life product 2 detail info
life product 2 detail info
life product 2 detail info
life product 2 detail info
life product 2 detail info
life product 2 detail info',
                'created' => '2023-05-24 03:41:00',
                'modified' => '2023-05-24 03:41:00',
            ],
            [
                'id' => 19,
                'category_id' => 1,
                'name' => 'cosmetic product 1',
                'quantity' => 20,
                'unit_price' => '130.00',
                'description' => 'cosmetic product 1 description
cosmetic product 1 description
cosmetic product 1 description
cosmetic product 1 description
cosmetic product 1 description
cosmetic product 1 description
cosmetic product 1 description',
                'created' => '2023-05-24 03:41:44',
                'modified' => '2023-05-24 03:41:44',
            ],
            [
                'id' => 20,
                'category_id' => 1,
                'name' => 'cosmetic product 2',
                'quantity' => 100,
                'unit_price' => '999.99',
                'description' => 'cosmetic product 2 description cosmetic product 2 description
cosmetic product 2 description
cosmetic product 2 descriptioncosmetic product 2 description
cosmetic product 2 description
cosmetic product 2 description
cosmetic product 2 description',
                'created' => '2023-05-24 03:42:33',
                'modified' => '2023-05-24 03:42:33',
            ],
            [
                'id' => 21,
                'category_id' => 1,
                'name' => 'cosmetic product 3',
                'quantity' => 30,
                'unit_price' => '156.00',
                'description' => 'cosmetic product 3 description
cosmetic product 3 description
cosmetic product 3 description
cosmetic product 3 description
cosmetic product 3 descriptioncosmetic product 3 descriptioncosmetic product 3 description',
                'created' => '2023-05-24 03:43:58',
                'modified' => '2023-05-24 03:43:58',
            ],
            [
                'id' => 22,
                'category_id' => 1,
                'name' => 'cosmetic product 4',
                'quantity' => 90,
                'unit_price' => '180.00',
                'description' => 'cosmetic product 4 description
cosmetic product 4 descriptioncosmetic product 4 descriptioncosmetic product 4 descriptioncosmetic product 4 descriptioncosmetic product 4 description
cosmetic product 4 description
cosmetic product 4 description
cosmetic product 4 description',
                'created' => '2023-05-24 03:44:39',
                'modified' => '2023-05-24 03:44:39',
            ],
        ];

        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
