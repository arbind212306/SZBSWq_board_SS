<?php
/**
 * CakePHP(tm) : Rapid Development Framework (https://cakephp.org)
 * Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 *
 * Licensed under The MIT License
 * For full copyright and license information, please see the LICENSE.txt
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright (c) Cake Software Foundation, Inc. (https://cakefoundation.org)
 * @link          https://cakephp.org CakePHP(tm) Project
 * @since         3.0.0
 * @license       https://opensource.org/licenses/mit-license.php MIT License
 */
namespace Cake\Test\TestCase\View\Form;

use Cake\Form\Form;
use Cake\Http\ServerRequest;
use Cake\TestSuite\TestCase;
use Cake\Validation\Validator;
use Cake\View\Form\FormContext;

/**
 * Form context test case.
 */
class FormContextTest extends TestCase
{
    /**
     * The request object.
     *
     * @var \Cake\Http\ServerRequest
     */
    protected $request;

    /**
     * setup method.
     *
     * @return void
     */
    public function setUp()
    {
        parent::setUp();
        $this->request = new ServerRequest();
    }

    /**
     * Test getting the primary key.
     *
     * @return void
     */
    public function testPrimaryKey()
    {
        $context = new FormContext($this->request, ['entity' => new Form()]);
        $this->assertEquals([], $context->primaryKey());
    }

    /**
     * Test isPrimaryKey.
     *
     * @return void
     */
    public function testIsPrimaryKey()
    {
        $context = new FormContext($this->request, ['entity' => new Form()]);
        $this->assertFalse($context->isPrimaryKey('id'));
    }

    /**
     * Test the isCreate method.
     *
     * @return void
     */
    public function testIsCreate()
    {
        $context = new FormContext($this->request, ['entity' => new Form()]);
        $this->assertTrue($context->isCreate());
    }

    /**
     * Test reading values from the request & defaults.
     */
    public function testValPresent()
    {
        $this->request = $this->request->withParsedBody([
            'Articles' => [
                'title' => 'New title',
                'body' => 'My copy',
            ]
        ]);
        $context = new FormContext($this->request, ['entity' => new Form()]);
        $this->assertEquals('New title', $context->val('Articles.title'));
        $this->assertEquals('My copy', $context->val('Articles.body'));
        $this->assertNull($context->val('Articles.nope'));
    }

    /**
     * Test getting values when the request and defaults are missing.
     *
     * @return void
     */
    public function testValMissing()
    {
        $context = new FormContext($this->request, ['entity' => new Form()]);
        $this->assertNull($context->val('Comments.field'));
    }

    /**
     * Test getting default value
     *
     * @return void
     */
    public function testValDefault()
    {
        $form = new Form();
        $form->schema()->addField('name', ['default' => 'schema default']);
        $context = new FormContext($this->request, ['entity' => $form]);

        $result = $context->val('title');
        $this->assertNull($result);

        $result = $context->val('title', ['default' => 'default default']);
        $this->assertEquals('default default', $result);

        $result = $context->val('name');
        $this->assertEquals('schema default', $result);

        $result = $context->val('name', ['default' => 'custom default']);
        $this->assertEquals('custom default', $result);

        $result = $context->val('name', ['schemaDefault' => false]);
        $this->assertNull($result);
    }

    /**
     * Test isRequired
     *
     * @return void
     */
    public function testIsRequired()
    {
        $form = new Form();
        $form->getValidator()
            ->requirePresence('name')
            ->add('email', 'format', ['rule' => 'email']);

        $context = new FormContext($this->request, [
            'entity' => $form
        ]);
        $this->assertTrue($context->isRequired('name'));
        $this->assertTrue($context->isRequired('email'));
        $this->assertFalse($context->isRequired('body'));
        $this->assertFalse($context->isRequired('Prefix.body'));
    }

    /**
     * Test the type method.
     *
     * @return void
     */
    public function testType()
    {
        $form = new Form();
        $form->schema()
            ->addField('email', 'string')
            ->addField('user_id', 'integer');

        $context = new FormContext($this->request, [
            'entity' => $form
        ]);
        $this->assertNull($context->type('undefined'));
        $this->assertEquals('integer', $context->type('user_id'));
        $this->assertEquals('string', $context->type('email'));
        $this->assertNull($context->type('Prefix.email'));
    }

    /**
     * Test the fieldNames method.
     *
     * @return void
     */
    public function testFieldNames()
    {
        $form = new Form();
        $context = new FormContext($this->request, [
            'entity' => $form
        ]);
        $expected = [];
        $result = $context->fieldNames();
        $this->assertEquals($expected, $result);

        $form->schema()
            ->addField('email', 'string')
            ->addField('password', 'string');
        $context = new FormContext($this->request, [
            'entity' => $form
        ]);

        $expected = ['email', 'password'];
        $result = $context->fieldNames();
        $this->assertEquals($expected, $result);
    }

    /**
     * Test fetching attributes.
     *
     * @return void
     */
    public function testAttributes()
    {
        $form = new Form();
        $form->schema()
            ->addField('email', [
                'type' => 'string',
                'length' => 10,
            ])
            ->addField('amount', [
                'type' => 'decimal',
                'length' => 5,
                'precision' => 2,
            ]);
        $context = new FormContext($this->request, [
            'entity' => $form
        ]);
        $this->assertEquals([], $context->attributes('id'));
        $this->assertEquals(['length' => 10, 'precision' => null], $context->attributes('email'));
        $this->assertEquals(['precision' => 2, 'length' => 5], $context->attributes('amount'));
    }

    /**
     * Test fetching errors.
     *
     * @return void
     */
    public function testError()
    {
        $nestedValidator = new Validator();
        $nestedValidator
            ->add('password', 'length', ['rule' => ['minLength', 8]])
            ->add('confirm', 'length', ['rule' => ['minLength', 8]]);
        $form = new Form();
        $form->getValidator()
            ->add('email', 'format', ['rule' => 'email'])
            ->add('name', 'length', ['rule' => ['minLength', 10]])
            ->addNested('pass', $nestedValidator);
        $form->validate([
            'email' => 'derp',
            'name' => 'derp',
            'pass' => [
                'password' => 'short',
                'confirm' => 'long enough',
            ],
        ]);

        $context = new FormContext($this->request, ['entity' => $form]);
        $this->assertEquals([], $context->error('empty'));
        $this->assertEquals(['The provided value is invalid'], $context->error('email'));
        $this->assertEquals(['The provided value is invalid'], $context->error('name'));
        $this->assertEquals(['The provided value is invalid'], $context->error('pass.password'));
        $this->assertEquals([], $context->error('Alias.name'));
        $this->assertEquals([], $context->error('nope.nope'));

        $validator = new Validator();
        $validator->requirePresence('key', true, 'should be an array, not a string');
        $form->setValidator('default', $validator);
        $form->validate([]);
        $context = new FormContext($this->request, ['entity' => $form]);
        $this->assertEquals(
            ['should be an array, not a string'],
            $context->error('key'),
            'This test should not produce a PHP warning from array_values().'
        );
    }

    /**
     * Test checking errors.
     *
     * @return void
     */
    public function testHasError()
    {
        $nestedValidator = new Validator();
        $nestedValidator
            ->add('password', 'length', ['rule' => ['minLength', 8]])
            ->add('confirm', 'length', ['rule' => ['minLength', 8]]);
        $form = new Form();
        $form->getValidator()
            ->add('email', 'format', ['rule' => 'email'])
            ->add('name', 'length', ['rule' => ['minLength', 10]])
            ->addNested('pass', $nestedValidator);
        $form->validate([
            'email' => 'derp',
            'name' => 'derp',
            'pass' => [
                'password' => 'short',
                'confirm' => 'long enough',
            ],
        ]);

        $context = new FormContext($this->request, ['entity' => $form]);
        $this->assertTrue($context->hasError('email'));
        $this->assertTrue($context->hasError('name'));
        $this->assertFalse($context->hasError('nope'));
        $this->assertFalse($context->hasError('nope.nope'));
        $this->assertTrue($context->hasError('pass.password'));
    }
}
