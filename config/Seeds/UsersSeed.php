<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Users seed.
 */
class UsersSeed extends AbstractSeed
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
                'username' => 'user1',
                'password' => '$2y$10$mmwuMP32vCblYaB2P4Bi5u9AZMVnNx6uK',
                'email' => 'quyentb2710@gmail.com',
                'role' => 0,
                'last_name' => '',
                'created' => '2023-05-18 07:59:51',
                'updated' => '2023-05-18 07:59:51',
            ],
            [
                'id' => 2,
                'username' => 'user2',
                'password' => '$2y$10$uV/pBeAOwyIc0qmtNFt0uefupUEI3A6C0',
                'email' => '',
                'role' => 0,
                'last_name' => '',
                'created' => '2023-05-18 08:49:10',
                'updated' => '2023-05-18 08:49:10',
            ],
            [
                'id' => 3,
                'username' => 'user3',
                'password' => '$2y$10$AmVv3urYqG80puaLqWa/X.iyp2sL.U./BYuonxFKdmrpj63VtXexG',
                'email' => '',
                'role' => 0,
                'last_name' => '',
                'created' => '2023-05-18 08:56:06',
                'updated' => '2023-05-18 08:56:06',
            ],
            [
                'id' => 4,
                'username' => 'admin',
                'password' => '$2y$10$TupanaICCdWSE64q0bFEZeiYvpLWRToa2bj1hLT7UkrMyqGaomHuq',
                'email' => '',
                'role' => 1,
                'last_name' => '',
                'created' => '2023-05-19 05:36:45',
                'updated' => '2023-05-19 05:36:45',
            ],
        ];

        $table = $this->table('users');
        $table->insert($data)->save();
    }
}
