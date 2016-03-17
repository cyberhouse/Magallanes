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

use Pimple\Container;
use Symfony\Component\Console\Command\Command;

/**
 * Class ContainerAwareCommand
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
 */
abstract class ContainerAwareCommand extends Command
{
    private $container;

    public function __construct(Container $container = null)
    {
        parent::__construct(null);
        $this->container = $container;
    }

    /**
     * retreive the dependency injection container from application
     *
     * @return Container the DI container
     */
    protected function getContainer()
    {
        return $this->container;
    }
}
