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
//             [
//                 'id' => 75,
//                 'category_id' => 1,
//                 'name' => 'CP001',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP001 Description',
//                 'created' => '2023-06-01 06:53:06',
//                 'modified' => '2023-06-01 06:53:06',
//             ],
//             [
//                 'id' => 76,
//                 'category_id' => 2,
//                 'name' => 'LP001',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'LP001 Description
// LP001 Description',
//                 'created' => '2023-06-01 06:57:24',
//                 'modified' => '2023-06-01 06:57:24',
//             ],
//             [
//                 'id' => 77,
//                 'category_id' => 2,
//                 'name' => 'LP002',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'LP002 Description
// LP002 Description',
//                 'created' => '2023-06-01 06:57:39',
//                 'modified' => '2023-06-01 06:57:39',
//             ],
//             [
//                 'id' => 78,
//                 'category_id' => 2,
//                 'name' => 'LP003',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'LP003 Description
// LP003 Description',
//                 'created' => '2023-06-01 06:57:49',
//                 'modified' => '2023-06-01 06:57:49',
//             ],
//             [
//                 'id' => 79,
//                 'category_id' => 2,
//                 'name' => 'LP004',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'LP004 Description
// LP004 Description',
//                 'created' => '2023-06-01 06:58:02',
//                 'modified' => '2023-06-01 06:58:02',
//             ],
//             [
//                 'id' => 80,
//                 'category_id' => 1,
//                 'name' => 'CP002',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP002 Description
// CP002 Description',
//                 'created' => '2023-06-01 06:58:58',
//                 'modified' => '2023-06-01 06:58:58',
//             ],
//             [
//                 'id' => 81,
//                 'category_id' => 1,
//                 'name' => 'CP003',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP003 Description
// CP003 Description',
//                 'created' => '2023-06-01 06:59:38',
//                 'modified' => '2023-06-01 06:59:38',
//             ],
//             [
//                 'id' => 82,
//                 'category_id' => 1,
//                 'name' => 'CP004',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP004 Description
// CP004 Description
// CP004 Description
// CP004 Description
// CP004 Description',
//                 'created' => '2023-06-01 06:59:57',
//                 'modified' => '2023-06-01 06:59:57',
//             ],
//             [
//                 'id' => 83,
//                 'category_id' => 1,
//                 'name' => 'CP005',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP005 Description
// CP005 Description
// CP005 Description
// CP005 Description
// CP005 Description
// CP005 Description
// CP005 Description
// CP005 Description',
//                 'created' => '2023-06-01 07:00:14',
//                 'modified' => '2023-06-01 07:00:14',
//             ],
//             [
//                 'id' => 84,
//                 'category_id' => 1,
//                 'name' => 'CP006',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description
// CP006 Description',
//                 'created' => '2023-06-01 07:00:49',
//                 'modified' => '2023-06-01 07:00:49',
//             ],
//             [
//                 'id' => 85,
//                 'category_id' => 1,
//                 'name' => 'CP007',
//                 'made_in' => 'VN',
//                 'sponsor_name' => 'VNP',
//                 'sponsor_address' => 'HN',
//                 'sponsor_tel' => '012356985',
//                 'description' => 'CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description
// CP007 Description',
//                 'created' => '2023-06-01 07:01:17',
//                 'modified' => '2023-06-01 07:01:17',
//             ],
        ];

        $table = $this->table('products');
        $table->insert($data)->save();
    }
}
