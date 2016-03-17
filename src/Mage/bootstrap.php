<?php


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

function includeAutoloadIfExists($path)
{
    if (file_exists($path)) {
        include $path;
        return true;
    }

    return false;
}

$autoload = __DIR__ . '/../../vendor/autoload.php';
if (!includeAutoloadIfExists($autoload)) {
    $autoload = __DIR__ . '/../../../../vendor/autoload.php';
    if (!includeAutoloadIfExists($autoload)) {
        echo "\033[31m[FATAL ERROR] you need to install the project dependencies!\033[0m\n";
        exit(1);
    }
}

use Mage\Mage;

return new Mage();
