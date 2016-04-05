<?php

/*
 *
 *  * This file is (c) 2016 by Cyberhouse GmbH
 *  *
 *  * It is free software; you can redistribute it and/or
 *  * modify it under the terms of the MIT License
 *  *
 *  * For the full copyright and license information see
 *  * the file LICENSE.md
 *
 */

$dir  = dirname(__DIR__);
$file = $dir . DIRECTORY_SEPARATOR . 'mage.phar';

if (is_file($file)) {
    unlink($file);
}

$phar = new Phar(
    $file,
    FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME,
    'mage.phar'
);

$phar->setSignatureAlgorithm(Phar::SHA512);

$phar->buildFromIterator(
    new RegexIterator(
        new RecursiveIteratorIterator(
            new RecursiveDirectoryIterator(
                $dir,
                RecursiveDirectoryIterator::SKIP_DOTS
            )
        ),
        '/^' . preg_quote($dir . DIRECTORY_SEPARATOR, '/') . '(src|vendor)/'
    ),
    $dir
);

$stub = <<<EOF
<?php
require 'vendor/autoload.php';
\$mage = new \Mage\Mage();
exit((int) \$mage->run());
__halt_compiler();

?>
EOF;

$phar->setStub(trim($stub));
