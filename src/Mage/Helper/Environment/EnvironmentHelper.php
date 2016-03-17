<?php
namespace Mage\Helper\Environment;

/*
 * (c) 2011-2015 Andrés Montañez <andres@andresmontanez.com>
 * (c) 2016 by Cyberhouse GmbH <office@cyberhouse.at>
 *
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License (MIT)
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

use Mage\Configuration\Environment;
use Mage\Configuration\General;
use Mage\Helper\BaseHelper;

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
        $environments = [];

        $environmentDirectory = Environment::getConfigurationDirectory();

        if (file_exists($environmentDirectory)) {
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
        $environment->initialize(['enableReleases' => $enableReleases]);

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

        if (!empty($name)) {
            $lockMessage .= "Locked by $name ";
        }
        if (!empty($email)) {
            $lockMessage .= "($email)";
        }
        if (!empty($reason)) {
            $lockMessage .= "\nReason: $reason";
        }

        $lockMessage = 'Locked environment at date: ' . date('Y-m-d H:i:s') . "\n" . $lockMessage;

        $lockFile = $this->getLockFilename($environmentName);
        file_put_contents($lockFile, $lockMessage);
    }

    public function unlockEnvironment($environmentName)
    {
        $lockFile = $this->getLockFilename($environmentName);

        if (file_exists($lockFile)) {
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
