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

use Mage\Task\AbstractTask;

/**
 * Abstract Task for Symfony2
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
abstract class SymfonyAbstractTask extends AbstractTask
{
    protected function getAppPath()
    {
        if ($this->getConfig()->general('symfony_version', '2') == '3') {
            $defaultAppPath = 'bin/console';
        } else {
            $defaultAppPath = 'app/console';
        }

        return $this->getConfig()->general('symfony_app_path', $defaultAppPath);
    }
}
