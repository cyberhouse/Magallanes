<?php
namespace Mage\Command\BuiltIn;

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

use Mage\Command\AbstractCommand;
use Mage\Console;
use Mage\Task\Factory;

/**
 * Updates the SCM Base Code
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
class UpdateCommand extends AbstractCommand
{
    /**
     * Updates the SCM Base Code
     * @see \Mage\Command\AbstractCommand::run()
     */
    public function run()
    {
        $exitCode = 200;

        $task = Factory::get('scm/update', $this->getConfig());
        $task->init();

        Console::output('Updating application via ' . $task->getName() . ' ... ', 1, 0);
        $result = $task->run();

        if ($result === true) {
            Console::output('<green>OK</green>' . PHP_EOL, 0);
            $exitCode = 0;
        } else {
            Console::output('<red>FAIL</red>' . PHP_EOL, 0);
        }

        return $exitCode;
    }
}
