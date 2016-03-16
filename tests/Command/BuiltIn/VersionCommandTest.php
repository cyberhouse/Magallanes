<?php
namespace MageTest\Command\BuiltIn;

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

use Mage\Command\BuiltIn\VersionCommand;
use MageTest\TestHelper\BaseTest;

/**
 * @coversDefaultClass Mage\Command\BuiltIn\VersionCommands
 * @group Mage_Command_BuildIn_VersionCommand
 * @uses Mage\Console
 * @uses Mage\Console\Colors
 */
class VersionCommandTest extends BaseTest
{
    /**
     * @group 175
     * @covers Mage\Command\BuiltIn\VersionCommand::run()
     */
    public function testRun()
    {
        $this->setUpConsoleStatics();
        $command = new VersionCommand();
        $command->run();

        $this->expectOutputString('Running Magallanes version 2' . str_repeat(PHP_EOL, 2));
    }
}
