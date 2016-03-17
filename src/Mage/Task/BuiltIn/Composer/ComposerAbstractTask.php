<?php
namespace Mage\Task\BuiltIn\Composer;

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
 * Abstract Task for Composer
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
abstract class ComposerAbstractTask extends AbstractTask
{
    protected function getComposerCmd()
    {
        $composerCmd = $this->getParameter(
            'composer_cmd',
            $this->getConfig()->general('composer_cmd', 'php composer.phar')
        );
        return $this->getConfig()->general('composer_cmd', $composerCmd);
    }
}
