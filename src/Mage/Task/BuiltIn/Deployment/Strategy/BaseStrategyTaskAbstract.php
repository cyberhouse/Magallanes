<?php
namespace Mage\Task\BuiltIn\Deployment\Strategy;

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
use Mage\Task\Releases\IsReleaseAware;

/**
 * Abstract Base task to concentrate common code for Deployment Tasks
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
abstract class BaseStrategyTaskAbstract extends AbstractTask implements IsReleaseAware
{
    /**
     * Checks if there is an override underway
     *
     * @return bool
     */
    protected function checkOverrideRelease()
    {
        $overrideRelease = $this->getParameter('overrideRelease', false);
        $symlink         = $this->getConfig()->release('symlink', 'current');

        if ($overrideRelease === true) {
            $releaseToOverride = false;
            $resultFetch       = $this->runCommandRemote('ls -ld ' . $symlink . ' | cut -d"/" -f2', $releaseToOverride);
            if ($resultFetch && is_numeric($releaseToOverride)) {
                $this->getConfig()->setReleaseId($releaseToOverride);
            }
        }

        return $overrideRelease;
    }

    /**
     * Gathers the files to exclude
     *
     * @return array
     */
    protected function getExcludes()
    {
        $excludes = [
            '.git',
            '.svn',
            '.mage',
            '.gitignore',
            '.gitkeep',
            'nohup.out',
        ];

        // Look for User Excludes
        $userExcludes = $this->getConfig()->deployment('excludes', []);

        return array_merge($excludes, $userExcludes);
    }
}
