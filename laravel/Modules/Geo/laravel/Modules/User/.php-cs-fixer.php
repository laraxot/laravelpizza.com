<?php

declare(strict_types=1);

// Includi l'autoloader di Composer per accedere alle classi PhpCsFixer
$vendorDir = __DIR__ . '/vendor';
if (!file_exists($vendorDir)) {
    $vendorDir = dirname(__DIR__, 3) . '/vendor';
}
require_once $vendorDir . '/autoload.php';

$finder = PhpCsFixer\Finder::create()
    ->notPath('bootstrap/cache')
    ->notPath('storage')
    ->notPath('vendor')
    ->in(__DIR__)
    ->name('*.php')
    ->notName('*.blade.php')
    ->ignoreDotFiles(true)
    ->ignoreVCS(true);

$config = new PhpCsFixer\Config();
$config->setRules([
    '@Symfony' => true,
    'array_indentation' => true,
    'function_typehint_space' => true,
    'declare_equal_normalize' => true,
    'declare_strict_types' => true,
    'combine_consecutive_unsets' => true,
    //'binary_operator_spaces' => ['align_double_arrow' => false],
    'array_syntax' => ['syntax' => 'short'],
    'linebreak_after_opening_tag' => true,
    'not_operator_with_successor_space' => true,
    'ordered_imports' => true,
    'phpdoc_order' => true,
    'php_unit_construct' => false,
    'braces' => [
        'position_after_functions_and_oop_constructs' => 'same',
    ],
    'function_declaration' => true,
    'blank_line_after_namespace' => true,
    'class_definition' => true,
    'elseif' => true,
])->setFinder($finder);

return $config;
