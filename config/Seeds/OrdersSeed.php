<?php
declare(strict_types=1);

use Migrations\AbstractSeed;

/**
 * Orders seed.
 */
class OrdersSeed extends AbstractSeed
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
                'order_number' => '2403090001',
                'user_id' => NULL,
                'status' => 0,
                'payment_status' => 0,
                'order_name' => 'quyen',
                'order_address' => 'vinh thinh',
                'order_tel' => '09099999',
                'order_amount' => '640000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => 'ksdjflsdf',
                'immediate' => 1,
                'delivery_type' => 0,
                'delivery_start_time' => NULL,
                'delivery_end_time' => NULL,
                'created' => '2024-03-09 02:16:59',
                'modified' => '2024-03-09 02:16:59',
            ],
            [
                'id' => 2,
                'order_number' => '2403090002',
                'user_id' => NULL,
                'status' => 0,
                'payment_status' => 0,
                'order_name' => 'quyen',
                'order_address' => 'vinh thinh',
                'order_tel' => '09099999',
                'order_amount' => '32000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => 'ksdjflsdf',
                'immediate' => 0,
                'delivery_type' => 0,
                'delivery_start_time' => '2024-03-09 16:00:00',
                'delivery_end_time' => '2024-03-09 17:00:00',
                'created' => '2024-03-09 15:08:12',
                'modified' => '2024-03-09 15:08:12',
            ],
            [
                'id' => 6,
                'order_number' => '2403090003',
                'user_id' => NULL,
                'status' => 0,
                'payment_status' => 0,
                'order_name' => 'quyen',
                'order_address' => 'vinh thinh',
                'order_tel' => '09099999',
                'order_amount' => '32000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => 'ksdjflsdf',
                'immediate' => 0,
                'delivery_type' => 0,
                'delivery_start_time' => '2024-03-09 16:00:00',
                'delivery_end_time' => '2024-03-09 17:00:00',
                'created' => '2024-03-09 15:22:39',
                'modified' => '2024-03-09 15:22:39',
            ],
            [
                'id' => 7,
                'order_number' => '2403090004',
                'user_id' => 3,
                'status' => 4,
                'payment_status' => 0,
                'order_name' => 'USER  C',
                'order_address' => 'ADRESSSAAAA',
                'order_tel' => '123333333',
                'order_amount' => '96000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => '',
                'immediate' => 0,
                'delivery_type' => 0,
                'delivery_start_time' => '2024-03-09 16:00:00',
                'delivery_end_time' => '2024-03-09 17:00:00',
                'created' => '2024-03-09 15:25:22',
                'modified' => '2024-03-09 15:35:43',
            ],
            [
                'id' => 8,
                'order_number' => '2403090005',
                'user_id' => 3,
                'status' => 0,
                'payment_status' => 0,
                'order_name' => 'USER  C',
                'order_address' => 'ADRESSSAAAA',
                'order_tel' => '123333333',
                'order_amount' => '60000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => '',
                'immediate' => 0,
                'delivery_type' => 0,
                'delivery_start_time' => '2024-03-09 16:00:00',
                'delivery_end_time' => '2024-03-09 17:00:00',
                'created' => '2024-03-09 15:36:52',
                'modified' => '2024-03-09 15:36:52',
            ],
            [
                'id' => 9,
                'order_number' => '2403090006',
                'user_id' => 3,
                'status' => 0,
                'payment_status' => 0,
                'order_name' => 'USER  C',
                'order_address' => 'ADRESSSAAAA',
                'order_tel' => '123333333',
                'order_amount' => '188000',
                'paid_amount' => NULL,
                'payment_point' => 0,
                'payment_type' => 0,
                'memo' => '',
                'immediate' => 0,
                'delivery_type' => 0,
                'delivery_start_time' => '2024-03-09 16:00:00',
                'delivery_end_time' => '2024-03-09 17:00:00',
                'created' => '2024-03-09 15:37:21',
                'modified' => '2024-03-09 15:37:21',
            ],
        ];

        $table = $this->table('orders');
        $table->insert($data)->save();
    }
}
