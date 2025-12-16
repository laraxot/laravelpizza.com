<?php

declare(strict_types=1);

return [
    /*
     * |--------------------------------------------------------------------------
     * | Base Paths
     * |--------------------------------------------------------------------------
     * |
     * | These constants define the base paths for different parts of the application.
     * | Using these constants instead of hardcoded paths helps prevent path-related errors.
     * |
     */
    'paths' => [
        'base' => '/var/www/html/exa/base_orisbroker_fila3',
        'laravel' => '/var/www/html/exa/base_orisbroker_fila3/laravel',
        'modules' => '/var/www/html/exa/base_orisbroker_fila3/laravel/Modules',
        'docs' => '/var/www/html/exa/base_orisbroker_fila3/docs',
    ],
    /*
     * |--------------------------------------------------------------------------
     * | Module Paths
     * |--------------------------------------------------------------------------
     * |
     * | These paths are automatically generated based on the base modules path
     * | and should be used when referencing module-specific directories.
     * |
     */
    'module_paths' => [
        'xot' => '/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Xot',
        'broker' => '/var/www/html/exa/base_orisbroker_fila3/laravel/Modules/Broker',
    ],
];
