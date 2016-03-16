<?php
namespace Mage\Task\BuiltIn\Symfony2;

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

class AssetsInstallTask extends SymfonyAbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Symfony v2 - Assets Install [built-in]';
    }

    /**
     * Installs Assets
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        // Options
        $target   = $this->getParameter('target', 'web');
        $symlink  = $this->getParameter('symlink', false);
        $relative = $this->getParameter('relative', false);
        $env      = $this->getParameter('env', 'dev');

        if ($relative) {
            $symlink = true;
        }

        $command = $this->getAppPath() . ' assets:install ' . ($symlink ? '--symlink' : '') . ' ' .
                   ($relative ? '--relative' : '') .
                   ' --env=' . $env . ' ' . $target;
        $result  = $this->runCommand($command);

        return $result;
    }
}
