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
use Mage\Yaml;

/**
 * Command for Adding elements to the Configuration.
 * Currently elements allowed to add:
 *   - environments
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 * @see Mage\Command\Environment\AddCommand
 */
class AddCommand extends AbstractCommand
{
    /**
     * Adds new Configuration Elements
     * @see \Mage\Command\AbstractCommand::run()
     * @throws Exception
     */
    public function run()
    {
        $subCommand = $this->getConfig()->getArgument(1);

        if (strcmp($subCommand, 'environment') == 0) {
            $this->addEnvironment();
        } else {
            throw new Exception('The Type of Add is needed.');
        }
    }

    /**
     * Adds an Environment
     *
     * @throws Exception
     */
    protected function addEnvironment()
    {
        $withReleases    = $this->getConfig()->getParameter('enableReleases', false);
        $environmentName = strtolower($this->getConfig()->getParameter('name'));

        if (empty($environmentName)) {
            throw new Exception('You must specify a name for the environment.');
        }

        $environmentConfigFile = getcwd() . '/.mage/config/environment/' . $environmentName . '.yml';

        if (file_exists($environmentConfigFile)) {
            throw new Exception('The environment already exists.');
        }

        Console::output('Adding new environment: <bold>' . $environmentName . '</bold>');

        $config = $this->getDefaultConfiguration($withReleases);
        $result = Yaml::dump($config, $environmentConfigFile);

        if ($result) {
            Console::output('<light_green>Success!!</light_green> Environment config file for <bold>' .
                            $environmentName . '</bold> created successfully at <blue>' .
                            $environmentConfigFile . '</blue>');
            Console::output('<bold>So please! Review and adjust its configuration.</bold>', 2, 2);
        } else {
            Console::output('<light_red>Error!!</light_red> Unable to create config file for environment called <bold>'
                            . $environmentName . '</bold>', 1, 2);
        }
    }

    /**
     * Build up the array of default configurations for an environment
     *
     * @param bool $withReleases flag for adding the releases configuration section
     * @return array
     */
    protected function getDefaultConfiguration($withReleases)
    {
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

        return $baseConfig;
    }
}
