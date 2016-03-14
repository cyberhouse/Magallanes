<?php


namespace Mage\Configuration;
use Mage\Configuration;


/**
 * Class General
 */
class General extends Configuration
{
    const GENERAL_DIR = '/.mage';

    public static function getConfigurationDirectory()
    {
        return getcwd() . self::GENERAL_DIR;
    }

    /**
     * initialize a new configuration object
     * @param $arguments array list of all necessary arguments to initialize the configuration
     */
    public function initialize($arguments)
    {
        $name = $arguments['name'];
        $email = array_key_exists('email', $arguments) ? $arguments['email'] : '';

        $generalConfig = array(
            'name' => $name,
            'email' => $email,
            'notifications' => !empty($email),
            'logging' => true,
            'maxlogs' => 30,
            'ssh_needs_tty' => false
        );

        $this->setConfigurationData($generalConfig);
    }
}