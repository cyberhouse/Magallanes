<?php
namespace MageTest\Task;

/*
 * (c) 2011-2015 Andrés Montañez <andres@andresmontanez.com>
 * (c) 2016 by Cyberhouse GmbH <office@cyberhouse.at>
 *
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License (MIT)
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

use Mage\Task\Factory;
use PHPUnit_Framework_TestCase;

/**
 * @group MageTest_Task_Factory
 * @group MageTest_Task
 * @group issue-176
 *
 * @uses Mage\Task\AbstractTask
 * @coversDefaultClass Mage\Task\Factory
 */
class FactoryTest extends PHPUnit_Framework_TestCase
{
    private $config;

    protected function setUp()
    {
        $this->config = $this->getMock('Mage\\Config');
    }

    /**
     * @covers Mage\Task\Factory::get
     */
    public function testGet()
    {
        $task = Factory::get('composer/install', $this->config);
        $this->assertInstanceOf('\\Mage\\Task\\BuiltIn\\Composer\\InstallTask', $task);
    }

    /**
     * @covers Mage\Task\Factory::get
     */
    public function testGetTaskDataIsArray()
    {
        $taskData = [
            'name'       => 'composer/install',
            'parameters' => [],
        ];

        $task = Factory::get($taskData, $this->config);
        $this->assertInstanceOf('\\Mage\\Task\\BuiltIn\\Composer\\InstallTask', $task);
    }

    /**
     * @covers Mage\Task\Factory::get
     */
    public function testGetCustomTask()
    {
        $this->getMockBuilder('Mage\\Task\\AbstractTask')
            ->setConstructorArgs([$this->config])
            ->setMockClassName('MyTask')
            ->getMock();

        /*
         * current workaround
         * @link https://github.com/sebastianbergmann/phpunit-mock-objects/issues/134
         */
        class_alias('MyTask', 'Task\\MyTask');

        $task = Factory::get('my-task', $this->config);
        $this->assertInstanceOf('Task\\MyTask', $task);
    }

    /**
     * @covers Mage\Task\Factory::get
     */
    public function testGetWithOptionalParams()
    {
        $task = Factory::get('composer/install', $this->config, true, 'production');
        $this->assertInstanceOf('\\Mage\\Task\\BuiltIn\\Composer\\InstallTask', $task);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The Task MyInconsistentTask must be an instance of Mage\Task\AbstractTask.
     * @covers Mage\Task\Factory::get
     */
    public function testGetInconsistentException()
    {
        $this->getMock('Task\\MyInconsistentTask');
        Factory::get('my-inconsistent-task', $this->config);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage Task "Unknowntask" not found.
     * @covers Mage\Task\Factory::get
     */
    public function testGetClassDoesNotExist()
    {
        Factory::get('unknowntask', $this->config);
    }
}
