<?php
namespace Mage\Command;

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
    protected function getContainer() {
        return $this->container;
    }
}