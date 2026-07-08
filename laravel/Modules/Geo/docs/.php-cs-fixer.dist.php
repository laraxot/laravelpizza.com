<?php

declare(strict_types=1);

use PhpCsFixer\Config;
use PhpCsFixer\Finder;

$finder = Finder::create()
    ->in(__DIR__)
    ->exclude([
        'bootstrap/cache',
        'storage',
        'vendor',
        'node_modules',
    ])
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new Config();

return $config
    ->setRiskyAllowed(true)
    ->setFinder($finder)
    ->setRules([
        // Base ruleset
        '@Symfony' => true,
        '@Symfony:risky' => true,

        // PHP basics
        'declare_strict_types' => true,
        'declare_equal_normalize' => true,
        'strict_param' => true,

        // Arrays
        'array_syntax' => ['syntax' => 'short'],
        'array_indentation' => true,
        'trailing_comma_in_multiline' => ['elements' => ['arrays']],

        // Operators & spacing
        'binary_operator_spaces' => ['default' => 'single_space'],
        'not_operator_with_successor_space' => true,

        // Imports
        'ordered_imports' => [
            'imports_order' => ['class', 'function', 'const'],
            'sort_algorithm' => 'alpha',
        ],

        // Functions & methods
        'function_typehint_space' => true,
        'function_declaration' => true,
        'php_unit_construct' => false,

        // Classes
        'class_definition' => true,
        'braces' => [
            'position_after_functions_and_oop_constructs' => 'same',
        ],

        // Control structures
        'elseif' => true,
        'combine_consecutive_unsets' => true,

        // Formatting
        'blank_line_after_namespace' => true,
        'linebreak_after_opening_tag' => true,

        // PHPDoc
        'phpdoc_order' => true,
    ]);
