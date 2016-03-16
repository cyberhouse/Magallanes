<?php
namespace Mage\Command;

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

use Mage\Config;

/**
 * Abstract Class for a Magallanes Command
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
abstract class AbstractCommand
{
    /**
     * Instance of the loaded Configuration.
     *
     * @var \Mage\Config
     */
    protected $config = null;

    /**
     * Runs the Command
     * @throws \Exception
     * @return int exit code
     */
    abstract public function run();

    /**
     * Sets the Loaded Configuration.
     *
     * @param Config $config
     */
    public function setConfig(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Gets the Loaded Configuration.
     *
     * @return Config
     */
    public function getConfig()
    {
        return $this->config;
    }
}
