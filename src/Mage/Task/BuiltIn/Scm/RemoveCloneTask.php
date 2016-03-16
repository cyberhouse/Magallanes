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

/**
 * Task for Removing an used Cloned Repository
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class RemoveCloneTask extends AbstractTask
{
    /**
     * Name of the Task
     * @var string
     */
    private $name = 'SCM Remove Clone [built-in]';

    /**
     * Source of the Repo
     * @var string
     */
    private $source = null;

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
        $this->source = $this->getConfig()->deployment('source');
        switch ($this->source['type']) {
            case 'git':
                $this->name = 'SCM Remove Clone (GIT) [built-in]';
                break;
        }
    }

    public function run()
    {
        return $this->runCommandLocal('rm -rf ' . $this->source['temporal']);
    }
}
