<?php
namespace Mage\Console;

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

use Mage\Config;

/**
 * Parses the different colors available for the Terminal or Console.
 *
 * @author Andrés Montañez <andres@andresmontanez.com>
 * @deprecated since version 2.0
 */
class Colors
{
    /**
     * List of Colors and they Terminal/Console representation.
     * @var array
     */
    private static $foregroundColors = [
        'black'        => '0;30',
        'bold'         => '1',
        'blue'         => '0;34',
        'light_blue'   => '1;34',
        'green'        => '0;32',
        'light_green'  => '1;32',
        'cyan'         => '0;36',
        'light_cyan'   => '1;36',
        'red'          => '0;31',
        'light_red'    => '1;31',
        'purple'       => '0;35',
        'light_purple' => '1;35',
        'brown'        => '0;33',
        'yellow'       => '1;33',
        'light_gray'   => '0;37',
        'white'        => '1;37',

    ];

    /**
     * Parses a Text to represent Colors in the Terminal/Console.
     *
     * @param string $string
     * @param Config $config
     * @return string
     */
    public static function color($string, Config $config)
    {
        $disabled = $config->getParameter('no-color', !$config->general('colors', true));

        if ($disabled) {
            $string = strip_tags($string);
            return $string;
        }

        foreach (self::$foregroundColors as $key => $code) {
            $replaceFrom = [
                '<' . $key . '>',
                '</' . $key . '>',
            ];

            $replaceTo = [
                "\033[" . $code . 'm',
                "\033[0m",
            ];

            $string = str_replace($replaceFrom, $replaceTo, $string);
        }

        return $string;
    }
}
