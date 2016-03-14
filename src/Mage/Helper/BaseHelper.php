<?php
namespace Mage\Helper;

use Pimple\Container;

/**
 * Class BaseHelper
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
 */
abstract class BaseHelper extends ContainerAwareHelper
{
    protected $container;

    public function __construct(Container $container)
    {
        $this->container = $container;
    }

    function getContainer() {
        return $this->container;
    }
}