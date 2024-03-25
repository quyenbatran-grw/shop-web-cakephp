<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * MastersFixture
 */
class MastersFixture extends TestFixture
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
                'type' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'rank' => 1,
                'created' => '2024-02-24 00:24:20',
                'modified' => '2024-02-24 00:24:20',
            ],
        ];
        parent::init();
    }
}
