<?php
declare(strict_types=1);

namespace App\Test\TestCase\Form;

use App\Form\UploadfileForm;
use Cake\TestSuite\TestCase;

/**
 * App\Form\UploadfileForm Test Case
 */
class UploadfileFormTest extends TestCase
{
    /**
     * Test subject
     *
     * @var \App\Form\UploadfileForm
     */
    protected $Uploadfile;

    /**
     * setUp method
     *
     * @return void
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->Uploadfile = new UploadfileForm();
    }

    /**
     * tearDown method
     *
     * @return void
     */
    protected function tearDown(): void
    {
        unset($this->Uploadfile);

        parent::tearDown();
    }

    /**
     * Test validationDefault method
     *
     * @return void
     * @uses \App\Form\UploadfileForm::validationDefault()
     */
    public function testValidationDefault(): void
    {
        $this->markTestIncomplete('Not implemented yet.');
    }
}
