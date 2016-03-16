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
use Mage\Task\ErrorWithMessageException;
use Mage\Task\Releases\IsReleaseAware;

/**
 * Create a deployment artifact
 *
 * @author Georg Großberger <georg.grossberger@cyberhouse.at>
 * @copyright (c) 2016 by Cyberhouse GmbH <www.cyberhouse.at>
 */
class ArtificeTask extends AbstractTask implements IsReleaseAware
{
    /**
     * Show the name of this task
     */
    public function getName()
    {
        return 'Creating deployment artifact [Built-In]';
    }

    public function run()
    {
        $path = $this->getParameter('to', '.mage/artifact/');
        $from = $this->getConfig()->environmentConfig('from');

        $excludes = [
            '.git*',
            '.travis.yml',
            '.coveralls.yml',
            '.editorconfig',
            'ruleset.xml',
            '.php*',
            'composer.lock',
            '*.md',
        ];
        $excludes = array_replace($excludes, $this->getParameter('excludes', []));

        $command = 'rsync -a -l --delete --force ' .
                   escapeshellarg($from) .
                   ' ' .
                   escapeshellarg($path) .
                   implode(' ', array_map(function ($exclude) {
                       return '--exclude=' . escapeshellarg($exclude);
                   }, $excludes));

        $this->runCommandLocal($command, $output);

        if (trim($output) !== '') {
            throw new ErrorWithMessageException($output);
        }

        $this->getConfig()->setFrom($path);

        return true;
    }
}
