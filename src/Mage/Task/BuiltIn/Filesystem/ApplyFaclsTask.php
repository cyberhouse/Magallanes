<?php
namespace Mage\Task\BuiltIn\Filesystem;

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
use Mage\Task\SkipException;

class ApplyFaclsTask extends AbstractTask implements IsReleaseAware
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Set file ACLs on remote system [built-in]';
    }

    /**
     * Runs the task
     *
     * @throws SkipException
     * @return bool
     */
    public function run()
    {
        $releasesDirectory = $this->getConfig()->release('directory', 'releases');
        $currentCopy       = $releasesDirectory . '/' . $this->getConfig()->getReleaseId();

        $aclParam = $this->getParameter('acl_param', '');
        if (empty($aclParam)) {
            throw new SkipException('Parameter acl_param not set.');
        }

        $folders   = $this->getParameter('folders', []);
        $recursive = $this->getParameter('recursive', false) ? ' -R ' : ' ';

        foreach ($folders as $folder) {
            $this->runCommandRemote("setfacl$recursive-m $aclParam $currentCopy/$folder", $output);
        }

        return true;
    }
}
