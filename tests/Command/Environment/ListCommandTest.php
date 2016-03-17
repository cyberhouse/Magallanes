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

use Pimple\Container;

/**
 * Class ListCommandTest
 */
class ListCommandTest extends \MageTest\Command\BaseCommandTest
{
    /** @var \Mage\Command\Environment\ListCommand */
    private $listCommand;
    /** @var PHPUnit_Framework_MockObject_MockObject */
    private $environmentHelperMock;

    protected function setUp()
    {
        parent::setUp();

        $container = new Container();

        $this->environmentHelperMock = $this->getMockBuilder('EnvironmentHelper')
            ->setMethods(['getAvailableEnvironments'])
            ->getMock();

        $container['environmentHelper'] = $this->environmentHelperMock;
        $this->listCommand              = new \Mage\Command\Environment\ListCommand($container);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithNoEnvironmentsShowsWarning()
    {
        $arguments        = [];
        $expectedExitCode = 0;
        $expectedMessage  = '[WARNING] There are no environment configurations available';

        $this->environmentHelperMock->method('getAvailableEnvironments')->willReturn([]);

        $this->executeAndAssert($this->listCommand, 'environment:list', $arguments, $expectedExitCode, $expectedMessage);
    }

    /**
     * @covers Mage\Command\Environment\ListCommand::execute
     */
    public function testExecuteWithExistingEnvironments()
    {
        $arguments        = [];
        $expectedExitCode = 0;

        $this->environmentHelperMock->method('getAvailableEnvironments')->willReturn(['foo', 'bar']);

        $this->executeAndAssert($this->listCommand, 'environment:list', $arguments, $expectedExitCode);
    }
}
