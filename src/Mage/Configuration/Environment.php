<?php
namespace Mage\Configuration;
use Mage\Configuration;

/**
 * Class Environment
 */
class Environment extends Configuration
{
    const ENVIRONMENT_DIR = '/.mage/config/environment';

    public static function getConfigurationDirectory()
    {
        return getcwd() . self::ENVIRONMENT_DIR;
    }

    /**
     * initialize a new configuration object
     *
     * @param $arguments array list of all necessary arguments to initialize the configuration
     */
    public function initialize($arguments)
    {
        $withReleases = empty($arguments) || !array_key_exists('enableReleases', $arguments) ? false : $arguments['enableReleases'];

        $baseConfig = array();

        $baseConfig['deployment'] = array(
            'user'     => 'dummy',
            'from'     => './',
            'to'       => '/var/www/vhosts/example.com/www',
            'excludes' => array(),
        );

        if ($withReleases) {
            $baseConfig['releases'] = array(
                'enabled'   => true,
                'max'       => 10,
                'symlink'   => 'current',
                'directory' => 'releases',
            );
        }

        $baseConfig['hosts'] = array();
        $baseConfig['tasks'] = array(
            'pre-deploy' => array(),
            'on-deploy'  => array(),
        );

        if ($withReleases) {
            $baseConfig['tasks']['post-release'] = array();
        }

        $baseConfig['tasks']['post-deploy'] = array();

        $this->setConfigurationData($baseConfig);
    }
}