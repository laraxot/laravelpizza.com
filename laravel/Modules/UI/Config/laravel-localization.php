<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Languages
     * |--------------------------------------------------------------------------
     * |
     * | This is the array for the languages.
     * |
     */
    'languages' => [
        'it' => [
            'name' => 'Italiano',
            'script' => 'Latn',
            'native' => 'Italiano',
            'regional' => 'it_IT',
        ],
        'en' => [
            'name' => 'English',
            'script' => 'Latn',
            'native' => 'English',
            'regional' => 'en_GB',
        ],
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Language Detection
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language detection.
     * |
     */
    'detect' => [
        'browser' => true,
        'session' => true,
        'cookie' => true,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Language Selection
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the language selection.
     * |
     */
    'selection' => [
        'default' => 'it',
        'fallback' => 'en',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | URL Configuration
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the URL.
     * |
     */
    'url' => [
        'prefix' => true,
        'hide_default' => false,
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Route Configuration
     * |--------------------------------------------------------------------------
     * |
     * | This is the configuration for the routes.
     * |
     */
    'route' => [
        'prefix' => '{locale}',
        'middleware' => [
            'web',
            'localize',
        ],
    ],
];
