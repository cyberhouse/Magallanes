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
use Mage\Command\RequiresEnvironment;
use Mage\Console;

/**
 * Command for Unlocking an Environment
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 * @see Mage\Command\Environment\UnlockCommand
 */
class UnlockCommand extends AbstractCommand implements RequiresEnvironment
{
    /**
     * Unlocks an Environment
     * @see \Mage\Command\AbstractCommand::run()
     */
    public function run()
    {
        $lockFile = getcwd() . '/.mage/' . $this->getConfig()->getEnvironment() . '.lock';
        if (file_exists($lockFile)) {
            @unlink($lockFile);
        }

        Console::output(
            'Unlocked deployment to <light_purple>'
            . $this->getConfig()->getEnvironment() . '</light_purple> environment',
            1,
            2
        );

        return 0;
    }
}
