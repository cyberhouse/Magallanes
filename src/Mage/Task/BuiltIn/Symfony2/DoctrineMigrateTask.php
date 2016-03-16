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

class DoctrineMigrateTask extends SymfonyAbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Symfony v2 - Migrate doctrine entities [built-in]';
    }

    /**
     * Migrates Doctrine entities
     *
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $env = $this->getParameter('env', 'dev');

        $command = $this->getAppPath() . ' doctrine:migrations:migrate -n --env=' . $env;

        return $this->runCommand($command);
    }
}
