<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * ImageProducts seed.
 */
class ImageProductsSeed extends AbstractSeed
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
                'product_id' => 4001,
                'name' => 'DSC_0099.JPG',
                'file_name' => '65f5f7e6f622cfc2048b9b0a3692e825.png',
                'file_type' => 'image/png',
                'file_size' => 105197,
                'created' => '2024-03-09 16:40:34',
                'modified' => '2024-03-09 16:40:34',
            ],
        ];

        $table = $this->table('image_products');
        $table->insert($data)->save();
    }
}
