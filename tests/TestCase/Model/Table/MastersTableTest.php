<?php
declare(strict_types=1);

namespace App\Test\TestCase\Model\Table;

use App\Model\Table\MastersTable;
use Cake\TestSuite\TestCase;

/**
 * App\Model\Table\MastersTable Test Case
 */
class MastersTableTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Model\Table\MastersTable
     */
    protected $Masters;

    /**
     * Fixtures
     *
     * @var array<string>
     */
    protected $fixtures = [
        'app.Masters',
    ];

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $config = $this->getTableLocator()->exists('Masters') ? [] : ['className' => MastersTable::class];
        $this->Masters = $this->getTableLocator()->get('Masters', $config);
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Masters);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Model\Table\MastersTable::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
