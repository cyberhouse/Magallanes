<?php


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

use Mage\Command\Environment\AddCommand;
use Pimple\Container;

/**
 * Class AddCommandTest
 */
class AddCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var AddCommand */
    private $addCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(['environmentExists', 'addEnvironment'])
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->addCommand               = new AddCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithoutNameOption()
    {
        $arguments        = [];
        $expectedExitCode = 1;
        $expectedMessage  = '[ERROR] the name parameter cannot be empty.';

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithExistingEnvironment()
    {
        $environmentName = 'foo';

        $arguments        = ['--name' => $environmentName];
        $expectedExitCode = 1;
        $expectedMessage  = "[ERROR] the environment \"$environmentName\" already exists.";

        $this->environmentHelperMock->method('environmentExists')->willReturn(true);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithoutEnabledReleases()
    {
        $arguments = [
            '--name'           => 'foo',
            '--enableReleases' => false,
        ];

        $expectedExitCode = 0;

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelperMock
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(true);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
    }

    /**
     * @covers Mage\Command\Environment\AddCommand::execute
     */
    public function testExecuteWithAddError()
    {
        $arguments = [
            '--name'           => 'foo',
            '--enableReleases' => false,
        ];

        $expectedExitCode = 1;

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->environmentHelperMock
            ->expects($this->any(), false)
            ->method('addEnvironment')
            ->willReturn(false);

        $this->executeTest($this->addCommand, 'environment:add', $arguments, $expectedExitCode);
    }
}
