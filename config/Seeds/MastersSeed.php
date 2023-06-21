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
                'type' => 0,
                'name' => 'master  type 1-1',
                'rank' => 1,
                'created' => '2023-05-22 03:35:02',
                'modified' => '2023-05-22 03:35:02',
            ],
            [
                'id' => 2,
                'type' => 0,
                'name' => 'master  type 1-2',
                'rank' => 2,
                'created' => '2023-05-22 03:37:51',
                'modified' => '2023-05-22 03:37:51',
            ],
            [
                'id' => 3,
                'type' => 1,
                'name' => 'master  type 2-1',
                'rank' => 1,
                'created' => '2023-05-22 03:38:09',
                'modified' => '2023-05-22 03:38:09',
            ],
            [
                'id' => 4,
                'type' => 0,
                'name' => 'master type 1-3',
                'rank' => 3,
                'created' => '2023-06-01 02:12:19',
                'modified' => '2023-06-01 02:12:19',
            ],
        ];

        $table = $this->table('masters');
        $table->insert($data)->save();
    }
}
