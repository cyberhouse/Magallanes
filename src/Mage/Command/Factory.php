<?php
namespace Mage\Command;

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
use Mage\Config;

/**
 * Loads a Magallanes Command.
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
class Factory
{
    /**
     * Gets an instance of a Command.
     *
     * @param string $commandName
     * @param Config $config
     * @throws Exception
     * @return AbstractCommand
     */
    public static function get($commandName, Config $config)
    {
        $instance    = null;
        $commandName = ucwords(str_replace('-', ' ', $commandName));
        $commandName = str_replace(' ', '', $commandName);

        $commandName = str_replace(' ', '_', ucwords(str_replace('/', ' ', $commandName)));
        $className   = 'Mage\\Command\\BuiltIn\\' . $commandName . 'Command';

        if (!class_exists($className)) {
            // try a custom command
            $className = 'Command\\' . $commandName;

            if (!class_exists($className)) {
                throw new Exception('Command "' . $commandName . '" not found.');
            }
        }

        /** @var AbstractCommand $instance */
        $instance = new $className;
        if (! $instance instanceof AbstractCommand) {
            throw new Exception('The command ' . $commandName .
                                ' must be an instance of Mage\Command\AbstractCommand.');
        }

        $instance->setConfig($config);

        return $instance;
    }
}
