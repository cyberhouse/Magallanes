<?php
namespace Mage\Helper\Environment;

use Mage\Helper\BaseHelper;
use Mage\Configuration\Environment;
use Mage\Configuration\General;

/**
 * Class EnvironmentHelper
 *
 * @author Johannes Pichler <johannes.pichler@cyberhouse.at>
 */
class EnvironmentHelper extends BaseHelper
{

    public function environmentExists($environmentName) 
    {
        $environment = new Environment($environmentName);

        return $environment->exists();
    }

    public function getAvailableEnvironments() 
    {
        $environments = array();

        $environmentDirectory = Environment::getConfigurationDirectory();

        if(file_exists($environmentDirectory)) {
            $pattern = $environmentDirectory . '/*.yml';

            $environmentFiles = glob($pattern);

            if (!empty($environmentFiles)) {
                foreach ($environmentFiles as $environmentFile) {
                    $environments[] = pathinfo($environmentFile, PATHINFO_FILENAME);
                }
            }
        }

        return $environments;
    }

    public function addEnvironment($environmentName, $enableReleases) 
    {
        $environment = new Environment($environmentName);
        $environment->initialize(array('enableReleases' => $enableReleases));

        return $environment->save();
    }

    public function removeEnvironment($environmentName) 
    {
        $environment = new Environment($environmentName);
        return $environment->remove();
    }

    public function lockEnvironment($environmentName, $name, $email, $reason) 
    {
        $lockMessage = '';

        if(!empty($name)) {
            $lockMessage .= "Locked by $name ";
        }
        if(!empty($email)) {
            $lockMessage .= "($email)";
        }
        if(!empty($reason)) {
            $lockMessage .= "\nReason: $reason";
        }

        $lockMessage = "Locked environment at date: " . date('Y-m-d H:i:s') . "\n" . $lockMessage;

        $lockFile = $this->getLockFilename($environmentName);
        file_put_contents($lockFile, $lockMessage);
    }

    public function unlockEnvironment($environmentName) 
    {
        $lockFile = $this->getLockFilename($environmentName);

        if(file_exists($lockFile)) {
            unlink($lockFile);
            return true;
        }

        return false;
    }

    private function getLockFilename($environmentName) 
    {
        return General::getConfigurationDirectory() . "/$environmentName.lock";
    }
}