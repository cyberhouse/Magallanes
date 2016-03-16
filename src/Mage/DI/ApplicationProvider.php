<?php
namespace Mage\DI;

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

use Mage\Configuration\General;
use Mage\Helper\Environment\EnvironmentHelper;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ApplicationProvider
 */
class ApplicationProvider implements ServiceProviderInterface
{
    /**
     * Registers services on the given container.
     *
     * This method should only be used to configure services and parameters.
     * It should not get services.
     *
     * @param Container $pimple A container instance
     */
    public function register(Container $pimple)
    {
        $pimple['generalConfiguration'] = function ($c) {
            return new General('general');
        };

        $pimple['environmentHelper'] = function ($c) {
            return new EnvironmentHelper($c);
        };
    }
}
