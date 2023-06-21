<?php
declare(strict_types=1);

namespace App\Test\Fixture;

use Cake\TestSuite\Fixture\TestFixture;

/**
 * ImageProductsFixture
 */
class ImageProductsFixture extends TestFixture
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
                'product_id' => 1,
                'name' => 'Lorem ipsum dolor sit amet',
                'file_name' => 'Lorem ipsum dolor sit amet',
                'file_type' => 'Lorem ipsum dolor sit amet',
                'file_size' => 1,
                'created' => '2023-05-22 07:12:43',
                'modified' => '2023-05-22 07:12:43',
            ],
        ];
        parent::init();
    }
}
