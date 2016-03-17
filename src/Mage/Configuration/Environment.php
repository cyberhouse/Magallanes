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
 * Class Environment
 */
class Environment extends Configuration
{
    const ENVIRONMENT_DIR = '/.mage/config/environment';

    public static function getConfigurationDirectory()
    {
        return getcwd() . self::ENVIRONMENT_DIR;
    }

    /**
     * initialize a new configuration object
     *
     * @param $arguments array list of all necessary arguments to initialize the configuration
     */
    public function initialize($arguments)
    {
        $withReleases = empty($arguments) || !array_key_exists('enableReleases', $arguments) ? false : $arguments['enableReleases'];

        $baseConfig = [];

        $baseConfig['deployment'] = [
            'user'     => 'dummy',
            'from'     => './',
            'to'       => '/var/www/vhosts/example.com/www',
            'excludes' => [],
        ];

        if ($withReleases) {
            $baseConfig['releases'] = [
                'enabled'   => true,
                'max'       => 10,
                'symlink'   => 'current',
                'directory' => 'releases',
            ];
        }

        $baseConfig['hosts'] = [];
        $baseConfig['tasks'] = [
            'pre-deploy' => [],
            'on-deploy'  => [],
        ];

        if ($withReleases) {
            $baseConfig['tasks']['post-release'] = [];
        }

        $baseConfig['tasks']['post-deploy'] = [];

        $this->setConfigurationData($baseConfig);
    }
}
