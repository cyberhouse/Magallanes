<?php
namespace Mage;

use Mage\Command\Environment\LockCommand;
use Mage\Command\Environment\UnlockCommand;
use Mage\DI\ApplicationProvider;
use Pimple\Container;
use Symfony\Component\Console\Application;

use Mage\Command\Environment\AddCommand;
use Mage\Command\Environment\RemoveCommand;
use Mage\Command\Environment\ListCommand;
use Mage\Command\General\InitCommand;

/**
 * Class Mage
 */
class Mage extends Application
{
    /** @var Container */
    private $container;

    public function __construct($provider = null)
    {
        parent::__construct('Magallanes', '2.0.0');

        $this->container = new Container();

        if (is_null($provider)) {
            $provider = new ApplicationProvider();
        }

        $this->container->register($provider);

        $this->registerCommands();
    }

    public function getContainer()
    {
        return $this->container;
    }

    /**
     * Register the available console commands
     */
    private function registerCommands()
    {
        $this->addCommands(
            array(
            new AddCommand(),
            new RemoveCommand(),
            new ListCommand(),
            new LockCommand(),
            new UnlockCommand(),
            new InitCommand()
            )
        );
    }
}
