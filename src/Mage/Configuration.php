<?php
namespace Mage;

use Symfony\Component\Yaml\Yaml;

/**
 * Class Configuration
 */
abstract class Configuration
{
    private $configurationName;
    private $configurationData = array();

    public static abstract function getConfigurationDirectory();

    /**
     * Configuration constructor
     *
     * @param $configurationName string the name of the configuration
     */
    public function __construct($configurationName)
    {
        $this->configurationName = $configurationName;

        if($this->exists()) {
            $this->load();
        }
    }

    /**
     * returns the value for the given config name
     *
     * if the given name is not found in the configuration
     * the specified default value is returned
     *
     * @param $name the name of the configuration option
     * @param $default the default return value
     * @return mixed the associated value
     */
    public function getOption($name, $default = null)
    {
        if(array_key_exists($name, $this->configurationData)) {
            return $this->configurationData[$name];
        }

        return $default;
    }

    /**
     * method for saving the current configuration data to the configuration file
     *
     * if the configuration data does not exist on disk a new configuration file
     * is created
     *
     * @return bool true if the save was successful
     */
    public function save()
    {
        $path = $this->getConfigurationFilepath();
        return file_put_contents($path, Yaml::dump($this->configurationData, 3, 2));
    }

    /**
     * method for removing the current configuration data from disk
     *
     * @return bool true if the removal was successful
     */
    public function remove()
    {
        $path = $this->getConfigurationFilepath();

        if(file_exists($path)) {
            unlink($path);
            return true;
        }

        return false;
    }

    /**
     * retreive the configurations full file path
     *
     * @return string the file path
     */
    public function getConfigurationFilepath() {
        return static::getConfigurationDirectory() . "/$this->configurationName.yml";
    }

    /**
     * check if the configuration exists on disk
     *
     * @return bool true if configuration exists on disk
     */
    public function exists() {
        return file_exists($this->getConfigurationFilepath());
    }

    /**4
     * load the configuration from disk
     */
    protected function load() {
        $this->configurationData = Yaml::parse($this->getConfigurationFilepath());
    }

    protected function getConfigurationData() {
        return $this->configurationData;
    }

    protected function setConfigurationData($onfigurationData) {
        $this->configurationData = $onfigurationData;
    }

    /**
     * initialize a new configuration object
     * @param $arguments array list of all necessary arguments to initialize the configuration
     * @return
     */
    public abstract function initialize($arguments);
}