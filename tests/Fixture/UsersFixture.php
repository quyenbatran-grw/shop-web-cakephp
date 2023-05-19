<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * UsersFixture
 */
class UsersFixture extends TestFixture
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
                'username' => 'Lorem ipsum dolor sit amet',
                'password' => 'Lorem ipsum dolor sit amet',
                'email' => 'Lorem ipsum dolor sit amet',
                'role' => 1,
                'last_name' => 'Lorem ipsum dolor sit amet',
                'created' => '2023-05-18 07:52:32',
                'updated' => '2023-05-18 07:52:32',
            ],
        ];
        parent::init();
    }
}
