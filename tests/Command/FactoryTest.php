<?php
namespace MageTest\Command;

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

use Mage\Command\Factory;
use PHPUnit_Framework_TestCase;

/**
 * @group Mage_Command
 * @group Mage_Command_Factory
 *
 * @group issue-167
 */
class FactoryTest extends PHPUnit_Framework_TestCase
{
    private $config;

    protected function setUp()
    {
        $this->config = $this->getMock('Mage\Config');
    }

    public function testGet()
    {
        $command = Factory::get('add', $this->config);
        $this->assertInstanceOf('Mage\\Command\\BuiltIn\\AddCommand', $command);
    }

    /**
     * @expectedException \Exception
     */
    public function testGetClassNotFoundException()
    {
        $command = Factory::get('commanddoesntexist', $this->config);
    }

    public function testGetCustomCommand()
    {
        $this->getMockBuilder('Mage\\Command\\AbstractCommand')
            ->setMockClassName('MyCommand')
            ->getMock();

        /**
         * current workaround
         * @link https://github.com/sebastianbergmann/phpunit-mock-objects/issues/134
         */
        class_alias('MyCommand', 'Command\\MyCommand');

        $command = Factory::get('my-command', $this->config);
        $this->assertInstanceOf('Command\\MyCommand', $command);
    }

    /**
     * @expectedException \Exception
     * @expectedExceptionMessage The command MyInconsistentCommand must be an instance of Mage\Command\AbstractCommand.
     */
    public function testGetInconsistencyException()
    {
        $this->getMock('Command\\MyInconsistentCommand');

        $command = Factory::get('my-inconsistent-command', $this->config);
    }
}
