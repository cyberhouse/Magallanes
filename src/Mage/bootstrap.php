<?php

function includeAutoloadIfExists($path) {
    if(file_exists($path)) {
        include $path;
        return true;
    }

    return false;
}

$autoload = __DIR__ . '/../vendor/autoload.php';
if(!includeAutoloadIfExists($autoload)) {
    $autoload = __DIR__ . '/../../../vendor/autoload.php';
    if(!includeAutoloadIfExists($autoload)) {
        echo "\033[31m[FATAL ERROR] you need to install the project dependencies!\033[0m\n";
        exit(1);
    }
}

use Mage\Mage;
return new Mage();