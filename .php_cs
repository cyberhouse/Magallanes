<?php
$fixers = array(
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
    'short_array_syntax',
    'single_quote',
    'extra_empty_lines',
    'hash_to_slash_comment',
    'method_argument_default_value',
    'lowercase_cast',
    'duplicate_semicolon',
    'phpdoc_no_package',
    'phpdoc_scalar',
);

$excludes = array(
    'bin',
    'docs',
    'tests',
    'vendor'
);

$finder = Symfony\CS\Finder\DefaultFinder::create()
    ->exclude($excludes)
    ->in(__DIR__);

return Symfony\CS\Config\Config::create()
    ->level(Symfony\CS\FixerInterface::PSR2_LEVEL)
    ->fixers($fixers)
    ->finder($finder);