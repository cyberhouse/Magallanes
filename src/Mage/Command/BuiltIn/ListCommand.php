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

use Exception;
use Mage\Command\AbstractCommand;
use Mage\Console;

/**
 * Adds elements to the Configuration.
 * Currently elements allowed to add:
 *   - environments
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 * @see Mage\Command\Environment\ListCommand
 */
class ListCommand extends AbstractCommand
{
    /**
     * Command for Listing Configuration Elements
     * @see \Mage\Command\AbstractCommand::run()
     * @throws Exception
     */
    public function run()
    {
        $exitCode   = 221;
        $subCommand = $this->getConfig()->getArgument(1);

        try {
            switch ($subCommand) {
                case 'environments':
                    $exitCode = $this->listEnvironments();
                    break;

                default:
                    throw new Exception('The Type of Elements to List is needed.');
                    break;
            }
        } catch (Exception $e) {
            Console::output('<red>' . $e->getMessage() . '</red>', 1, 2);
        }

        return $exitCode;
    }

    /**
     * Lists the Environments
     */
    protected function listEnvironments()
    {
        $exitCode     = 220;
        $environments = [];
        $content      = scandir(getcwd() . '/.mage/config/environment/');
        foreach ($content as $file) {
            if (strpos($file, '.yml') !== false) {
                $environments[] = str_replace('.yml', '', $file);
            }
        }
        sort($environments);

        if (count($environments) > 0) {
            Console::output('<bold>These are your configured environments:</bold>', 1, 1);
            foreach ($environments as $environment) {
                Console::output('* <light_red>' . $environment . '</light_red>', 2, 1);
            }
            Console::output('', 1, 1);
            $exitCode = 0;
        } else {
            Console::output('<bold>You don\'t have any environment configured.</bold>', 1, 2);
        }

        return $exitCode;
    }
}
