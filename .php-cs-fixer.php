<?php

$rules = [
    '@Symfony' => true,
    'whitespace_after_comma_in_array' => ['ensure_single_space' => true],
    'cast_spaces' => ['space' => 'none'],
    'ordered_class_elements' => true,
    // 'method_argument_space' => true,
    'list_syntax' => true,
    'no_useless_return' => true,
    'explicit_string_variable' => true,
    'yoda_style' => false,
    'no_useless_else' => true,
    'global_namespace_import' => true,
    'combine_consecutive_unsets' => true,
    'declare_equal_normalize' => ['space' => 'single'],
    'concat_space' => ['spacing' => 'one'],
    'ternary_to_null_coalescing' => true,
    'multiline_whitespace_before_semicolons' => true,
    'array_indentation' => true,
    'blank_line_before_statement' => true,
    'method_chaining_indentation' => true,
    'phpdoc_to_comment' => false,
    'phpdoc_var_annotation_correct_order' => true,

    // 'phpdoc_add_missing_param_annotation' => true,
    // 'class_definition' => true,
];

$finder = PhpCsFixer\Finder::create();

// ignore laravel blade file
$finder->exclude(['vendor'])
    ->notName('*.blade.php');

return (new PhpCsFixer\Config())
    ->setRules($rules)
    ->setIndent('    ')
    ->setLineEnding("\n")
    ->setFinder($finder);