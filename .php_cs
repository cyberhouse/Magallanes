<?php

/*
 * This is free software; you can redistribute it and/or
 * modify it under the terms of the MIT License
 *
 * For the full copyright and license information see
 * <https://opensource.org/licenses/MIT>
 */

use \Symfony\CS\Finder\DefaultFinder;
use \Symfony\CS\Config\Config;
use Symfony\CS\FixerInterface;

if (PHP_SAPI !== 'cli') {
    die('This script supports command line usage only. Please check your command.');
}

$finder = DefaultFinder::create()
    ->in(array(__DIR__ . '/src', __DIR__ . '/tests'));

return Config::create()
    ->setUsingCache(true)
    ->level(FixerInterface::PSR2_LEVEL)
    ->fixers([
        '-psr0',
        'remove_leading_slash_use',
        'single_array_no_trailing_comma',
        'ereg_to_preg',
        'spaces_before_semicolon',
        'unused_use',
        'ordered_use',
        'concat_with_spaces',
        'whitespacy_lines',
        'array_element_no_space_before_comma',
        'double_arrow_multiline_whitespaces',
        'no_blank_lines_before_namespace',
        'namespace_no_leading_whitespace',
        'native_function_casing',
        'no_empty_lines_after_phpdocs',
        'multiline_array_trailing_comma',
        'spaces_cast',
        'standardize_not_equal',
        'align_double_arrow',
        'align_equals',
        'long_array_syntax',
        'single_quote',
        'extra_empty_lines',
        'hash_to_slash_comment',
        'method_argument_default_value',
        'lowercase_cast',
        'duplicate_semicolon',
        'phpdoc_no_package',
        'phpdoc_scalar',
    ])
    ->finder($finder);
