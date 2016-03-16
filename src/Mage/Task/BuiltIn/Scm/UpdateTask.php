<?php
namespace Mage\Task\BuiltIn\Scm;

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
use Mage\Task\SkipException;

/**
 * Task for Updating a Working Copy
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class UpdateTask extends AbstractTask
{
    /**
     * Name of the Task
     * @var string
     */
    private $name = 'SCM Update [built-in]';

    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::init()
     */
    public function init()
    {
        switch ($this->getConfig()->general('scm')) {
            case 'git':
                $this->name = 'SCM Update (GIT) [built-in]';
                break;
        }
    }

    /**
     * Updates the Working Copy
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = 'cd ' . $this->getConfig()->deployment('from', './') . '; ';
        switch ($this->getConfig()->general('scm')) {
            case 'git':
                $command .= 'git pull';
                break;

            default:
                throw new SkipException;
                break;
        }

        $result = $this->runCommandLocal($command);
        $this->getConfig()->reload();

        return $result;
    }
}
