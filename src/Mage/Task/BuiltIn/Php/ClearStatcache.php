<?php
namespace Mage\Task\BuiltIn;

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

use Mage\Task\AbstractTask;
use Mage\Task\ErrorWithMessageException;
use Mage\Task\Releases\IsReleaseAware;

/**
 * Task for clearing the PHP Opcache
 *
 * @author Georg Großberger <georg.grossberger@cyberhouse.at>
 * @copyright (c) 2016 by Cyberhouse GmbH <www.cyberhouse.at>
 */
class ClearStatcache extends AbstractTask implements IsReleaseAware
{
    /**
     * Get the name of the task
     *
     * @return string
     */
    public function getName()
    {
        return 'Clear PHP OPcache [Built-In]';
    }

    public function run()
    {
        if ($this->getConfig()->release('enabled', false) === true) {
            $path = $this->getConfig()->release('directory', 'releases') . '/' . $this->getConfig()->getReleaseId();
        } else {
            $path = $this->getConfig()->deployment('to');
        }

        $path = $this->getParameter(
            'document-root',
            $this->getConfig()->deployment('document-root', $path)
        );
        $url = $this->getParameter('frontend-url', $this->getConfig()->deployment('frontend-url'));
        $url = rtrim($url, '/');

        if (empty($url)) {
            throw new ErrorWithMessageException('No frontend-url set');
        }

        $file = 'opcache-free-' . $this->getConfig()->getReleaseId() . '.php';

        $command = 'cd ' . $path . ' && ' .
                   'echo \'<?php clearstatcache(true);\' > ' . $file . ' && ' .
                   'curl -k -s ' . $url . '/' . $file . '; ' .
                   'rm -f ' . $file;

        $this->runCommandRemote($command, $output, false);
    }
}
