<?php
namespace Mage;

use Mage\Command\BaseCommand;
use Mage\DI\ApplicationProvider;
use Pimple\Container;
use Symfony\Component\Console\Application;
use Symfony\Component\Finder\Finder;

/**
 * Class Mage
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
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
     * by scanning the namespace Mage\Command for available commands
     */
    private function registerCommands()
    {
        $psr4Namespaces = include $this->getProjectRootDirectory() . 'vendor/composer/autoload_psr4.php';

        $namespacePaths = $psr4Namespaces['Mage\\'];

        foreach($namespacePaths as $path) {
            $basePath = $path . '/Command';
            $files = Finder::create()->files()->name('*Command.php')->in($basePath);

            foreach($files as $file) {
                $subPath = str_replace($basePath, '', $file->getPathName());
                $fullClasspath = str_replace('/', '\\', 'Mage\\Command' . $subPath);
                $fullClasspath = substr($fullClasspath, 0, -4);
                try {
                    $reflectionClass = new \ReflectionClass($fullClasspath);

                    if(!$reflectionClass->isAbstract() && $reflectionClass->newInstance() instanceof BaseCommand) {
                        $instance = $reflectionClass->newInstance($this->container);

                        $this->add($instance);
                    }
                }
                catch(\Exception $ignored) {}
            }
        }
    }

    /**
     * get the project root directory by finding the vendor autoloader
     *
     * @return string the project root directory path
     */
    private function getProjectRootDirectory() {
        $path = __DIR__ . '/../../';
        if(!file_exists($path . 'vendor/autoload.php')) {
            $path =  __DIR__ . '/../../../../';
            if(!file_exists($path . 'vendor/autoload.php')) {
                return __DIR__;
            }
        }

        return $path;
    }
}
