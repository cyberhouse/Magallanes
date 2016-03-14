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
    /**
     * returns the available dependency injection container
     *
     * @return Container the DI container
     */
    protected abstract function getContainer();
}