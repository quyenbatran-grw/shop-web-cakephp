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
                'comment' => 'id of categories table'
            ])
            ->addColumn('name', 'string', [
                'default' => null,
                'null' => false,
                'comment' => 'name of product'
            ])
            ->addColumn('quantity', 'biginteger', [
                'default' => 0,
                'null' => false,
                'comment' => 'quantity of product'
            ])
            ->addColumn('unit_price', 'decimal', [
                'default' => null,
                'null' => false,
                'precision' => 5,
                'scale' => 2,
                'comment' => 'price of each product'
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
            ->addIndex(['category_id'])
            ->create();

        // Product images
        $this->table('image_products')
            ->addColumn('product_id', 'biginteger', [
                'default' => null,
                'null' => false,
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
            ->create();
    }
}
