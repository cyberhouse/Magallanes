<?php
namespace Mage\Task\BuiltIn\Magento;

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
 * Task for Clearing Full Page Cache
 *
 * @author Oscar Reales <oreales@gmail.com>
 */
class ClearFullPageCacheTask extends AbstractTask
{
    /**
     * (non-PHPdoc)
     * @see \Mage\Task\AbstractTask::getName()
     */
    public function getName()
    {
        return 'Magento - Clean Full Page Cache [built-in]';
    }

    /**
     * Clears Full Page Cache
     * @see \Mage\Task\AbstractTask::run()
     */
    public function run()
    {
        $command = 'rm -rf var/full_page_cache/*';
        $result  = $this->runCommand($command);

        return $result;
    }
}
