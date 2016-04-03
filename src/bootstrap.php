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


$timezone = ini_get('date.timezone');

if (empty($timezone)) {
    date_default_timezone_set('UTC');
}

define('MAGALLANES_VERSION', '2.0.0-dev');

$paths = [
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../../../vendor/autoload.php',
];

foreach ($paths as $path) {
    if (is_file($path)) {
        require $path;
        $mage = new Mage\Mage();
        exit($mage->run());
    }
}

echo "\033[31m[FATAL ERROR] you need to install the project dependencies!\033[0m\n";
exit(1);
