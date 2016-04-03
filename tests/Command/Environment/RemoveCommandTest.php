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

use Mage\Command\Environment\RemoveCommand;
use Pimple\Container;

/**
 * Class RemoveCommandTest
 *
 * @coversDefaultClass Mage\Command\Environment\RemoveCommand
 */
class RemoveCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var RemoveCommand */
    private $removeCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(['environmentExists', 'removeEnvironment'])
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->removeCommand            = new RemoveCommand($container);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithoutNameOption()
    {
        $arguments        = [];
        $expectedExitCode = 1;
        $expectedMessage  = '[ERROR] The name parameter cannot be empty.';

        $this->executeAndAssert($this->removeCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteWithNotExistingEnvironment()
    {
        $environmentName = 'foobar';

        $arguments        = ['--name' => $environmentName];
        $expectedExitCode = 1;
        $expectedMessage  = "[ERROR] The environment \"$environmentName\" does not exist.";

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(false);

        $this->executeAndAssert($this->removeCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers ::execute
     */
    public function testExecuteFailsOnRemoval()
    {
        $environmentName = 'foobar';

        $arguments        = ['--name' => $environmentName];
        $expectedExitCode = 1;
        $expectedMessage  = "[ERROR] The environment \"$environmentName\" cannot be removed.";

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(true);

        $this->environmentHelperMock
            ->method('removeEnvironment')
            ->willReturn(false);

        $this->executeAndAssert($this->removeCommand, 'environment:remove', $arguments, $expectedExitCode, $expectedMessage);
    }

    public function testExecuteSuccess()
    {
        $environmentName = 'foobar';

        $arguments        = ['--name' => $environmentName];
        $expectedExitCode = 0;

        $this->environmentHelperMock
            ->method('environmentExists')
            ->willReturn(true);

        $this->environmentHelperMock
            ->method('removeEnvironment')
            ->willReturn(true);

        $this->executeAndAssert($this->removeCommand, 'environment:remove', $arguments, $expectedExitCode);
    }
}
