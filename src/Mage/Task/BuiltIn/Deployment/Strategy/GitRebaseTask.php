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

use Mage\Task\Releases\IsReleaseAware;

/**
 * Task for using Git Working Copy as the Deployed Code
 *
 * @author Oscar Reales <oreales@gmail.com>
 */
class GitRebaseTask extends BaseStrategyTaskAbstract implements IsReleaseAware
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Deploy via Git Rebase [built-in]';
    }

    /**
     * Rebases the Git Working Copy as the Deployed Code
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $this->checkOverrideRelease();

        if ($this->getConfig()->release('enabled', false) === true) {
            $releasesDirectory = $this->getConfig()->release('directory', 'releases');

            $deployToDirectory = rtrim($this->getConfig()->deployment('to'), '/')
                . '/' . $releasesDirectory
                . '/' . $this->getConfig()->getReleaseId();
            $this->runCommandRemote('mkdir -p ' . $deployToDirectory);
        }

        $branch = $this->getParameter('branch', 'master');
        $remote = $this->getParameter('remote', 'origin');

        // Fetch Remote
        $command = $this->getReleasesAwareCommand('git fetch ' . $remote);
        $result  = $this->runCommandRemote($command);

        if ($result === false) {
            $repository = $this->getConfig()->deployment('repository');
            if ($repository) {
                $command = $this->getReleasesAwareCommand('git clone ' . $repository . ' .');
                $result  = $this->runCommandRemote($command);

                $command = $this->getReleasesAwareCommand('git fetch ' . $remote);
                $result  = $this->runCommandRemote($command) && $result;
            }
        }

        // Checkout
        $command = $this->getReleasesAwareCommand('git checkout ' . $branch);
        $result  = $this->runCommandRemote($command) && $result;

        // Check Working Copy status
        $stashed = false;
        $status  = '';
        $command = $this->getReleasesAwareCommand('git checkout ' . $branch);
        $result  = $this->runCommandRemote($command) && $result;

        // Stash if Working Copy is not clean
        if (!$status) {
            $stashResult = '';
            $command     = $this->getReleasesAwareCommand('git stash');
            $result      = $this->runCommandRemote($command, $stashResult) && $result;
            if ($stashResult != 'No local changes to save') {
                $stashed = true;
            }
        }

        // Rebase
        $command = $this->getReleasesAwareCommand('git rebase ' . $remote . '/' . $branch);
        $result  = $this->runCommandRemote($command) && $result;

        // If Stashed, restore.
        if ($stashed) {
            $command = $this->getReleasesAwareCommand('git stash pop');
            $result  = $this->runCommandRemote($command) && $result;
        }

        return $result;
    }
}
