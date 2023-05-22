<?php
declare(strict_types=1);

namespace App\Test\TestCase\Middleware;

use App\Middleware\AdminMiddleware;
use Cake\TestSuite\TestCase;

/**
 * App\Middleware\AdminMiddleware Test Case
 */
class AdminMiddlewareTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Middleware\AdminMiddleware
     */
    protected $Admin;

    /**
     * Test process method
     *
     * @return void
     * @uses \App\Middleware\AdminMiddleware::process()
     */
    public function testProcess(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
