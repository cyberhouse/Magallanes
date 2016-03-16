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

class CacheClearTask extends SymfonyAbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Symfony v2 - Cache Clear [built-in]';
    }

    /**
     * Clears the Cache
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        // Options
        $env      = $this->getParameter('env', 'dev');
        $optional = $this->getParameter('optional', '');

        $command = $this->getAppPath() . ' cache:clear --env=' . $env . ' ' . $optional;

        $result = $this->runCommand($command);

        return $result;
    }
}
