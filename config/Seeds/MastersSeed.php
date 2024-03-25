<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Masters seed.
 */
class MastersSeed extends AbstractSeed
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
                'type' => 1,
                'name' => 'VN',
                'ranking' => 1,
                'created' => '2024-03-09 01:18:47',
                'modified' => '2024-03-09 01:18:47',
            ],
            [
                'id' => 2,
                'type' => 1,
                'name' => 'JP',
                'ranking' => 2,
                'created' => '2024-03-09 01:18:52',
                'modified' => '2024-03-09 01:18:52',
            ],
            [
                'id' => 3,
                'type' => 2,
                'name' => 'CTY A',
                'ranking' => 1,
                'created' => '2024-03-09 01:18:56',
                'modified' => '2024-03-09 01:18:56',
            ],
            [
                'id' => 4,
                'type' => 2,
                'name' => 'CTY B',
                'ranking' => 2,
                'created' => '2024-03-09 01:19:00',
                'modified' => '2024-03-09 01:19:00',
            ],
            [
                'id' => 5,
                'type' => 3,
                'name' => 'kg',
                'ranking' => 1,
                'created' => '2024-03-09 01:19:07',
                'modified' => '2024-03-09 01:19:07',
            ],
            [
                'id' => 6,
                'type' => 3,
                'name' => 'gram',
                'ranking' => 2,
                'created' => '2024-03-09 01:19:13',
                'modified' => '2024-03-09 01:19:13',
            ],
        ];

        $table = $this->table('masters');
        $table->insert($data)->save();
    }
}
