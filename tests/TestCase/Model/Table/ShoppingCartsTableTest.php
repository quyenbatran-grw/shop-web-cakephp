<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\ShoppingCartsTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\ShoppingCartsTable Test Case
 */
class ShoppingCartsTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\ShoppingCartsTable
     */
    protected $ShoppingCarts;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.ShoppingCarts',
        'app.Users',
        'app.DeviceTokens',
        'app.Categories',
        'app.Products',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('ShoppingCarts') ? [] : ['className' => ShoppingCartsTable::class];
        $this->ShoppingCarts = $this->getTableLocator()->get('ShoppingCarts', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->ShoppingCarts);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\ShoppingCartsTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }

    /**
     * Test buildRules method
     *
     * @return void
     * @uses \App\Model\Table\ShoppingCartsTable::buildRules()
     */
    public function testBuildRules(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
