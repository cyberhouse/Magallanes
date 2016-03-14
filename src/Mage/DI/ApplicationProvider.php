<?php
namespace Mage\DI;

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
        $pimple['generalConfiguration'] = function($c) {
            return new General('general');
        };

        $pimple['environmentHelper'] = function($c) {
            return new EnvironmentHelper($c);
        };
    }
}