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
    __DIR__ . '/../vendor/autoload.php',
    __DIR__ . '/../../vendor/autoload.php',
    __DIR__ . '/../../../../vendor/autoload.php',
];

try {
    foreach ($paths as $path) {
        if (is_file($path)) {
            require $path;

            if (class_exists('Mage\\Mage')) {
                $mage = new Mage\Mage();
                exit((int)$mage->run());
            }
        }
    }

    throw new \RuntimeException('Cannot load magallanes. Make sure dependencies are installed!');

} catch (\Exception $ex) {
    $msg = $ex->getMessage();

    if ((DIRECTORY_SEPARATOR === '\\'
         && (false !== getenv('ANSICON') || 'ON' === getenv('ConEmuANSI') || 'xterm' === getenv('TERM')))
        || (function_exists('posix_isatty') && @posix_isatty(STDERR))) {
        $parts = [
            str_repeat(' ', strlen($msg) + 4),
            '  ' . $msg . '  ',
            str_repeat(' ', strlen($msg) + 4),
        ];
        $msg   = implode(
            PHP_EOL,
            array_map(function ($line) {
                return "    \033[41;1;37m$line\e[49;22;39m";
            }, $parts)
        );
    }

    fwrite(STDERR, PHP_EOL . $msg . PHP_EOL . PHP_EOL);
    exit(1);
}
