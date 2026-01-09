<?php

declare(strict_types=1);

use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenNormalClassesSniff;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenSetterSniff;
use NunoMaduro\PhpInsights\Domain\Sniffs\ForbiddenTraitsSniff;

return [
    /*
    |--------------------------------------------------------------------------
    | Default Preset
    |--------------------------------------------------------------------------
    |
    | This option controls the default preset that will be used by PHP Insights
    | to make your code reliable, simple, and maintainable. Please make sure
    | the preset you select does not conflict with your project's requirements.
    |
    */

    'preset' => 'laravel',

    /*
    |--------------------------------------------------------------------------
    | IDE
    |--------------------------------------------------------------------------
    |
    | This option allows to add hyperlinks in your terminal to quickly open
    | files in your favorite IDE while browsing your PhpInsights report.
    |
    */

    'ide' => null,

    /*
    |--------------------------------------------------------------------------
    | Configuration
    |--------------------------------------------------------------------------
    |
    | Here you may adjust all the various settings that are maintained by the
    | package. You can either add, remove or configure `Insights`. Keep in
    | mind that all added `Insights` must belong to a specific `Metric`.
    |
    */

    'exclude' => [
        'vendor',
        'node_modules',
        'storage',
        'bootstrap/cache',
        'tests',
        'database/seeders',
        'database/factories',
        'config',
        'resources/lang',
    ],

    'add' => [
        // Additional insights to be added
    ],

    'remove' => [
        ForbiddenNormalClassesSniff::class,
        ForbiddenTraitsSniff::class,
        ForbiddenSetterSniff::class,
    ],

    'config' => [
        /*
        |--------------------------------------------------------------------------
        | Excluded Files
        |--------------------------------------------------------------------------
        |
        | Here you may exclude files from being analyzed by PHP Insights. You
        | can either exclude specific files or entire directories.
        |
        */

        'exclude' => [
            'vendor',
            'node_modules',
            'storage',
            'bootstrap/cache',
            'tests',
            'database/seeders',
            'database/factories',
            'config',
            'resources/lang',
        ],

        /*
        |--------------------------------------------------------------------------
        | Add Sniffs
        |--------------------------------------------------------------------------
        |
        | Here you can add your own custom sniffs to the analyzer. These sniffs
        | will be added to the default preset that you have selected.
        |
        */

        'add' => [
            // Additional insights to be added
        ],

        /*
        |--------------------------------------------------------------------------
        | Remove Sniffs
        |--------------------------------------------------------------------------
        |
        | Here you can remove sniffs from the analyzer. These sniffs will be
        | removed from the default preset that you have selected.
        |
        */

        'remove' => [
            ForbiddenNormalClassesSniff::class,
            ForbiddenTraitsSniff::class,
            ForbiddenSetterSniff::class,
        ],

        /*
        |--------------------------------------------------------------------------
        | Configuration for insights
        |--------------------------------------------------------------------------
        |
        | Configuration for insights
        |
        */
    ],

    /*
    |--------------------------------------------------------------------------
    | Requirements
    |--------------------------------------------------------------------------
    |
    | Here you may define a level you want to reach per `Insights` category.
    | When a score is lower than the minimum level defined, then an error
    | code will be returned. This is optional and individually defined.
    |
    */

    'requirements' => [
        'min-quality' => 80,
        'min-complexity' => 80,
        'min-architecture' => 80,
        'min-style' => 80,
    ],

    /*
    |--------------------------------------------------------------------------
    | Threads
    |--------------------------------------------------------------------------
    |
    | Here you may adjust how many threads (core) PHPInsights can use to perform
    | the analyse. This is optional, don't provide it and the tool will guess
    | the max core number available. It accepts null value or integer > 0.
    |
    */

    'threads' => null,
];
