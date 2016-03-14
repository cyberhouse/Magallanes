<?php
namespace Mage\Helper;

use Pimple\Container;


/**
 * Class ContainerAwareHelper
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
 */
abstract class ContainerAwareHelper
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    /**
     * returns the available dependency injection container
     *
     * @return Container the DI container
     */
    protected function getContainer()
    {
        return $this->container;
    }
}