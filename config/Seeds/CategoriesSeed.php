<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Categories seed.
 */
class CategoriesSeed extends AbstractSeed
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
                'name' => 'Mỹ phẩm',
                'description' => 'cosmetic production',
                'created' => '2023-05-22 04:02:23',
                'modified' => '2023-05-22 04:02:23',
            ],
            [
                'id' => 2,
                'name' => 'Đồ sinh hoạt',
                'description' => 'Life production',
                'created' => '2023-05-22 04:11:27',
                'modified' => '2023-05-22 04:11:27',
            ],
            [
                'id' => 3,
                'name' => 'Bánh kẹo',
                'description' => 'candy production',
                'created' => '2023-05-22 04:11:45',
                'modified' => '2023-05-22 04:11:45',
            ],
        ];

        $table = $this->table('categories');
        $table->insert($data)->save();
    }
}
