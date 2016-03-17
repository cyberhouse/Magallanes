<?php
namespace Task;

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
 * @author Muhammad Surya Ihsanuddin <surya.kejawen@gmail.com>
 */
class FrontControllerCleanTask extends AbstractTask
{
    public function getName()
    {
        return 'Cleaning Project';
    }

    public function run()
    {
        $command = 'rm -rf web/app_*.php';
        $result  = $this->runCommandRemote($command);

        return $result;
    }
}
