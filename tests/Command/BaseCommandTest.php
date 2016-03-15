<?php


namespace MageTest\Command;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;


/**
 * Class BaseCommandTest
 */
abstract class BaseCommandTest extends \PHPUnit_Framework_TestCase
{

    protected function executeTest($commandInstance, $commandName, $arguments, $expectedExitCode, $expectedMessage = null) {
        $application = new Application();
        $application->add($commandInstance);

        $command = $application->find($commandName);
        $commandTester = new CommandTester($command);
        $commandTester->execute($arguments);

        $this->assertEquals($expectedExitCode, $commandTester->getStatusCode());

        if(!is_null($expectedMessage)) {
            $output = $commandTester->getDisplay(true);
            $output = trim($output);

            $this->assertEquals($expectedMessage, $output);
        }
    }
}