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
use Mage\Task\Factory;

/**
 * This is an Alias of "release rollback"
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
class RollbackCommand extends AbstractCommand implements RequiresEnvironment
{
    /**
     * Rollback a release
     * @see \Mage\Command\AbstractCommand::run()
     */
    public function run()
    {
        $exitCode  = 105;
        $releaseId = $this->getConfig()->getArgument(1);

        if (!is_numeric($releaseId)) {
            Console::output('<red>This release is mandatory.</red>', 1, 2);
            return 104;
        }

        $lockFile = getcwd() . '/.mage/' . $this->getConfig()->getEnvironment() . '.lock';
        if (file_exists($lockFile)) {
            Console::output('<red>This environment is locked!</red>', 1, 2);
            echo file_get_contents($lockFile);
            return 106;
        }

        // Run Tasks for Deployment
        $hosts = $this->getConfig()->getHosts();

        if (count($hosts) == 0) {
            Console::output('<light_purple>Warning!</light_purple> ' .
                            '<bold>No hosts defined, unable to get releases.</bold>', 1, 3);
        } else {
            $result = true;
            foreach ($hosts as $hostKey => $host) {
                // Check if Host has specific configuration
                $hostConfig = null;
                if (is_array($host)) {
                    $hostConfig = $host;
                    $host       = $hostKey;
                }

                // Set Host and Host Specific Config
                $this->getConfig()->setHost($host);
                $this->getConfig()->setHostConfig($hostConfig);

                $this->getConfig()->setReleaseId($releaseId);
                $task = Factory::get('releases/rollback', $this->getConfig());
                $task->init();
                $result = $task->run() && $result;
            }

            if ($result) {
                $exitCode = 0;
            }
        }

        return $exitCode;
    }
}
