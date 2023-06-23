<?php
declare(strict_types=1);

use Migrations\AbstractMigration;

class InitAllMigration extends AbstractMigration
{
    /**
     * Change Method.
     *
     * More information on this method is available here:
     * https://book.cakephp.org/phinx/0/en/migrations.html#the-change-method
     * @return void
     */
    public function change(): void
    {
        // ユーザー
        $this->table('users', ['comment' => 'ユーザー'])
            ->addColumn('username', 'string', [
                'null' => false,
                'limit' => 255,
                'comment' => ''
            ])
            ->addColumn('password', 'string', [
                'null' => false,
                'limit' => 60,
                'comment' => ''
            ])
            ->addColumn('email', 'string', [
                'null' => true,
                'limit' => 100,
                'comment' => ''
            ])
            ->addColumn('role', 'boolean', [
                'null' => false,
                'comment' => '',
                'default' => 0,
            ])
            ->addColumn('last_name', 'string', [
                'null' => true,
                'limit' => 30,
                'comment' => ''
            ])
            ->addColumn('created', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => true,
                'comment' => ''
            ])
            ->addColumn('updated', 'datetime', [
                'default' => 'CURRENT_TIMESTAMP',
                'null' => true,
                'comment' => ''
            ])
            ->addIndex(['username'], ['unique' => true])
            ->create();

        //マスター
        $this->table('masters', ['comment' => 'マスター'])
            ->addColumn('type', 'integer', [
                'default' => null,
                'null' => false,
                'limit' => 11,
                'comment' => '種別'
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 255,
                'comment' => '名称'
            ])
            ->addColumn('rank', 'integer', [
                'default' => 1,
                'null' => false,
                'limit' => 11,
                'comment' => '種別ごとに並び順'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => true,
                'comment' => '更新日1'
            ])
            ->create();

        //カテゴリー
        $this->table('categories', ['comment' => 'カテゴリー'])
            ->addColumn('name', 'string', [
                'default' => null,
                'limit' => 255,
                'null' => false,
                'comment' => '名称'
            ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => false,
                'comment' => '詳細'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->create();

        // Product
        $this->table('products')
            ->addColumn('category_id', 'integer', [
                'default' => null,
                'null' => false,
                'limit' => 11,
                'comment' => 'id of categories table'
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
                'comment' => 'name of product'
            ])
            ->addColumn('made_in', 'integer', [
                'default' => 0,
                'null' => false,
                'comment' => 'where product is made'
            ])
            ->addColumn('sponsor_name', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'comment' => 'name of sponsor'
            ])
            ->addColumn('sponsor_address', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 255,
                'comment' => 'address of sponsor'
            ])
            ->addColumn('sponsor_tel', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 15,
                'comment' => 'name of sponsor'
            ])
            // ->addColumn('quantity', 'biginteger', [
            //     'default' => 0,
            //     'null' => false,
            //     'limit' => 20,
            //     'comment' => 'quantity of product'
            // ])
            // ->addColumn('unit_price', 'decimal', [
            //     'default' => null,
            //     'null' => false,
            //     'precision' => 11,
            //     'scale' => 0,
            //     'comment' => 'price of each product'
            // ])
            ->addColumn('description', 'text', [
                'default' => null,
                'null' => false,
                'comment' => '詳細'
            ])
            ->addColumn('deleted', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => 'delete'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->addIndex(['category_id'])
            ->create();

        // Product Stocks
        $this->table('product_inventories')
            ->addColumn('product_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of product'
            ])
            ->addColumn('date', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => 'id of product'
            ])
            ->addColumn('unit_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 11,
                'scale' => 0,
                'comment' => 'price of each product'
            ])
            ->addColumn('quantity', 'biginteger', [
                'default' => 0,
                'null' => false,
                'limit' => 20,
                'comment' => 'quantity of product'
            ])
            ->addColumn('memo', 'text', [
                'default' => null,
                'null' => true,
                'comment' => 'memo'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->addIndex(['product_id'])
            ->create();

        // Product images
        $this->table('image_products')
            ->addColumn('product_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of product'
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
                'comment' => 'name of image'
            ])
            ->addColumn('file_name', 'string', [
                'default' => null,
                'null' => false,
                'comment' => 'saved image name'
            ])
            ->addColumn('file_type', 'string', [
                'default' => null,
                'null' => false,
                'comment' => 'image type'
            ])
            ->addColumn('file_size', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'image size'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->addIndex(['product_id'])
            // ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            ->create();

        // DeviceTokens
        // $this->table('device_tokens')
        //     ->addColumn('device_token', 'string', [
        //         'default' => null,
        //         'null' => false,
        //         'comment' => 'device token'
        //     ])
        //     ->addColumn('created', 'datetime', [
        //         'default' => null,
        //         'null' => false,
        //         'comment' => '作成日'
        //     ])
        //     ->addColumn('modified', 'datetime', [
        //         'default' => null,
        //         'null' => false,
        //         'comment' => '更新日'
        //     ])
        //     ->create();

        // Orders
        $this->table('orders')
            ->addColumn('order_number', 'string', [
                'default' => null,
                'null' => true,
                'limit' => 20,
                'comment' => 'id of user'
            ])
            ->addColumn('status', 'integer', [
                'default' => 0,
                'null' => false,
                'limit' => 11,
                'comment' => 'delivery status(0:preparing, 1: delivering, 2: deliveried, 3: cancel)'
            ])
            ->addColumn('order_name', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 255,
                'comment' => 'order name'
            ])
            ->addColumn('order_address', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 255,
                'comment' => 'order address'
            ])
            ->addColumn('order_tel', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 15,
                'comment' => 'order tel'
            ])
            ->addColumn('order_amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 11,
                'scale' => 0,
                'comment' => 'total price of order exclusive tax'
            ])
            ->addColumn('memo', 'text', [
                'default' => null,
                'null' => true,
                'comment' => 'memo'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->addIndex('order_number', ['unique' => true])
            ->create();


            // OrderDetails
        $this->table('order_details')
            ->addColumn('order_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of order'
            ])
            ->addColumn('product_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of product'
            ])
            ->addColumn('user_id', 'biginteger', [
                'default' => 0,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of user'
            ])
            ->addColumn('quantity', 'string', [
                'default' => null,
                'null' => false,
                'limit' => 255,
                'comment' => 'order name'
            ])
            ->addColumn('unit_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 11,
                'scale' => 0,
                'comment' => 'price of each product'
            ])
            ->addColumn('amount', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 11,
                'scale' => 0,
                'comment' => 'total price of order product exclusive tax'
            ])
            ->addColumn('memo', 'text', [
                'default' => null,
                'null' => true,
                'comment' => 'memo'
            ])
            ->addColumn('created', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '作成日'
            ])
            ->addColumn('modified', 'datetime', [
                'default' => null,
                'null' => false,
                'comment' => '更新日'
            ])
            ->addIndex(['order_id', 'product_id', 'user_id'])
            ->addIndex(['order_id', 'product_id'], ['unique' => true])
            // ->addForeignKey('product_id', 'products', 'id', ['delete' => 'CASCADE', 'update' => 'CASCADE'])
            // ->addForeignKey('user_id', 'users', 'id')
            ->create();



        // ShoppingCarts
        $this->table('shopping_carts')
            ->addColumn('user_id', 'biginteger', [
                'default' => null,
                'null' => true,
                'limit' => 20,
                'comment' => 'id of user'
            ])
            ->addColumn('category_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of category'
            ])
            ->addColumn('product_id', 'biginteger', [
                'default' => null,
                'null' => false,
                'limit' => 20,
                'comment' => 'id of product'
            ])
            ->addColumn('quantity', 'integer', [
                'default' => null,
                'null' => false,
                'comment' => 'order quantity'
            ])
            ->addIndex(['user_id', 'category_id', 'product_id'], ['unique' => true])
            // ->addForeignKey('user_id', 'users', 'id')
            // ->addForeignKey('category_id', 'categories', 'id')
            // ->addForeignKey('product_id', 'products', 'id')
            ->create();
    }
}
