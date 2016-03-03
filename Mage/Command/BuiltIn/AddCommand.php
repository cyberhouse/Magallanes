<?php
/*
 * This file is part of the Magallanes package.
*
* (c) Andrés Montañez <andres@andresmontanez.com>
*
* For the full copyright and license information, please view the LICENSE
* file that was distributed with this source code.
*/

namespace Mage\Command\BuiltIn;

use Mage\Command\AbstractCommand;
use Mage\Console;
use Exception;
use Symfony\Component\Yaml\Yaml;

/**
 * Command for Adding elements to the Configuration.
 * Currently elements allowed to add:
 *   - environments
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 */
class AddCommand extends AbstractCommand
{
    /**
     * Adds new Configuration Elements
     * @see \Mage\Command\AbstractCommand::run()
     * @throws Exception
     */
    public function run()
    {
        $subCommand = $this->getConfig()->getArgument(1);

        if(strcmp($subCommand, 'environment') == 0) {
            $this->addEnvironment();
        } else {
            throw new Exception('The Type of Add is needed.');
        }
    }

    /**
     * Adds an Environment
     *
     * @throws Exception
     */
    protected function addEnvironment()
    {
        $withReleases = $this->getConfig()->getParameter('enableReleases', false);
        $environmentName = strtolower($this->getConfig()->getParameter('name'));

        if (empty($environmentName)) {
            throw new Exception('You must specify a name for the environment.');
        }

        $environmentConfigFile = getcwd() . '/.mage/config/environment/' . $environmentName . '.yml';

        if (file_exists($environmentConfigFile)) {
            throw new Exception('The environment already exists.');
        }

        Console::output('Adding new environment: <bold>' . $environmentName . '</bold>');

        $config = $this->getDefaultConfiguration($withReleases);

        $dumper = new Dumper();
        $result = file_put_contents($environmentConfigFile, Yaml::dump($config, 3, 2));

        if ($result) {
            Console::output('<light_green>Success!!</light_green> Environment config file for <bold>' . $environmentName . '</bold> created successfully at <blue>' . $environmentConfigFile . '</blue>');
            Console::output('<bold>So please! Review and adjust its configuration.</bold>', 2, 2);
        } else {
            Console::output('<light_red>Error!!</light_red> Unable to create config file for environment called <bold>' . $environmentName . '</bold>', 1, 2);
        }
    }

    /**
     * Build up the array of default configurations for an environment
     *
     * @param $withReleases flag for adding the releases configuration section
     */
    protected function getDefaultConfiguration($withReleases) {
        $baseConfig = array();

        $baseConfig['deployment'] = array(
            'user' => 'dummy',
            'from' => './',
            'to' => '/var/www/vhosts/example.com/www',
            'excludes' => null
        );

        if($withReleases) {
            $baseConfig['releases'] = array(
                'enabled' => true,
                'max' => 10,
                'symlink' => 'current',
                'directory' => 'releases'
            );
        }

        $baseConfig['hosts'] = null;
        $baseConfig['tasks'] = array(
            'pre-deploy' => null,
            'on-deploy' => null
        );

        if($withReleases) {
            $baseConfig['tasks']['post-release'] = null;
        }

        $baseConfig['tasks']['post-deploy'] = null;

        return $baseConfig;
    }
}
