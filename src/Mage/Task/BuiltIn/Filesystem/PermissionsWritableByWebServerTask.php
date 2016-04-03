<?php
namespace Mage\Task\BuiltIn\Filesystem;

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

use Mage\Task\SkipException;

/**
 * Task for giving web server write permissions on given paths.
 *
 * Usage :
 *   pre-deploy:
 *     - filesystem/permissions-writable-by-web-server:
 *         paths:
 *             - /var/www/myapp/app/cache
 *             - /var/www/myapp/app/logs
 *         recursive: false
 *         checkPathsExist: true
 *
 * @author Jérémy Huet <jeremy.huet@gmail.com>
 */
class PermissionsWritableByWebServerTask extends PermissionsTask
{
    /**
     * Set group with web server user and give group write permissions.
     */
    public function init()
    {
        parent::init();

        $this->setGroup($this->getParameter('group') ? $this->getParameter('group') : $this->getWebServerUser())
             ->setRights('g+w');
    }

    /**
     * @return string
     */
    public function getName()
    {
        return 'Giving write permissions to web server user for given paths [built-in]';
    }

    /**
     * Tries to guess the web server user by going thru the running processes.
     *
     * @throws SkipException
     * @return string
     */
    protected function getWebServerUser()
    {
        $this->runCommand(
            "ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1",
            $webServerUser
        );

        if (empty($webServerUser)) {
            throw new SkipException(
                "Can't guess web server user. Please check if it is running or force it by setting the group parameter"
            );
        }

        return $webServerUser;
    }
}
