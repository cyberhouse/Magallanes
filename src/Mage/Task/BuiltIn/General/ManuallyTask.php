<?php
namespace Mage\Task\BuiltIn\General;

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

use Mage\Task\AbstractTask;

/**
 * Task for running multiple custom commands setting them manually
 *
 * Example of usage:
 *
 * tasks:
 *    on-deploy:
 *       - scm/force-update
 *       - general/manually:
 *          - find . -type d -exec chmod 755 {} \;
 *          - find . -type f -exec chmod 644 {} \;
 *          - chmod +x bin/console
 *          - find var/logs -maxdepth 1 -type f -name '*.log' -exec chown apache:apache {} \;
 *       - symfony2/cache-clear
 *
 * @author Samuel Chiriluta <samuel4x4@gmail.com>
 */
class ManuallyTask extends AbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Manually multiple custom tasks';
    }

    /**
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $result = true;

        $commands = $this->getParameters();

        foreach ($commands as $command) {
            $result = $result && $this->runCommand($command);
        }

        return $result;
    }
}
