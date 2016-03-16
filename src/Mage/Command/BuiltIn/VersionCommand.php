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

/**
 * Command for displaying the Version of Magallanes
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
class VersionCommand extends AbstractCommand
{
    /**
     * Display the Magallanes Version
     * @see \Mage\Command\AbstractCommand::run()
     */
    public function run()
    {
        Console::output('Running <blue>Magallanes</blue> version <bold>' . MAGALLANES_VERSION . '</bold>', 0, 2);

        return 0;
    }
}
