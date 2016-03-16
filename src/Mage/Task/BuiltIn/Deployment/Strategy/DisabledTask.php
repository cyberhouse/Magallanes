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
use Mage\Task\SkipException;

/**
 * Deployment Strategy is Disabled
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class DisabledTask extends AbstractTask implements IsReleaseAware
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Disabled Deployment [built-in]';
    }

    /**
     * Deployment Strategy is Disabled
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        throw new SkipException;
    }
}
