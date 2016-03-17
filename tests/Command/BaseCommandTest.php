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

use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

/**
 * Class BaseCommandTest
 */
abstract class BaseCommandTest extends \PHPUnit_Framework_TestCase
{

    protected function executeAndAssert($commandInstance, $commandName, $arguments, $expectedExitCode, $expectedMessage = null)
    {
        $application = new Application();
        $application->add($commandInstance);

        $command       = $application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments);

        $this->assertEquals($expectedExitCode, $commandTester->getStatusCode());

        if (!is_null($expectedMessage)) {
            $output = $commandTester->getDisplay(true);
            $output = trim($output);

            $this->assertEquals($expectedMessage, $output);
        }
    }
}
