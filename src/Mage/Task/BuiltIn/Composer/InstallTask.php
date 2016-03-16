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

use Mage\Task\ErrorWithMessageException;

class InstallTask extends ComposerAbstractTask
{
    /**
     * Returns the Title of the Task
     * @return string
     */
    public function getName()
    {
        return 'Install vendors via Composer [built-in]';
    }

    /**
     * Runs the task
     *
     * @throws ErrorWithMessageException
     * @return bool
     */
    public function run()
    {
        $dev = $this->getParameter('dev', true);
        return $this->runCommand($this->getComposerCmd() . ' install' . ($dev ? ' --dev' : ' --no-dev'));
    }
}
