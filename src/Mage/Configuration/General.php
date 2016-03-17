<?php
namespace Mage\Configuration;

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

use Mage\Configuration;

/**
 * Class General
 */
class General extends Configuration
{
    const GENERAL_DIR = '/.mage';

    public static function getConfigurationDirectory()
    {
        return getcwd() . self::GENERAL_DIR;
    }

    /**
     * initialize a new configuration object
     *
     * @param $arguments array list of all necessary arguments to initialize the configuration
     */
    public function initialize($arguments)
    {
        $name  = $arguments['name'];
        $email = array_key_exists('email', $arguments) ? $arguments['email'] : '';

        $generalConfig = [
            'name'          => $name,
            'email'         => $email,
            'notifications' => !empty($email),
            'logging'       => true,
            'maxlogs'       => 30,
            'ssh_needs_tty' => false,
        ];

        $this->setConfigurationData($generalConfig);
    }
}
