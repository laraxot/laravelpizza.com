<?php

declare(strict_types=1);

return [
    /*
    |--------------------------------------------------------------------------
    | Module Identity
    |--------------------------------------------------------------------------
    |
    | Basic information about the Meetup module.
    |
    */
    'name' => 'Meetup',
    'description' => 'Modulo per la gestione eventi e meetup',
    'icon' => 'heroicon-o-calendar-days',

    /*
    |--------------------------------------------------------------------------
    | Navigation Configuration
    |--------------------------------------------------------------------------
    |
    | Controls how the module appears in the admin navigation menu.
    |
    */
    'navigation' => [
        'enabled' => true,
        'sort' => 50,
        'group' => 'Content',
    ],

    /*
    |--------------------------------------------------------------------------
    | Routes Configuration
    |--------------------------------------------------------------------------
    |
    | Controls module route registration and middleware.
    |
    */
    'routes' => [
        'enabled' => true,
        'middleware' => ['web'],
        'prefix' => null,
    ],

    /*
    |--------------------------------------------------------------------------
    | Service Providers
    |--------------------------------------------------------------------------
    |
    | Service providers registered by this module.
    | These are automatically loaded by Laravel Modules.
    |
    */
    'providers' => [
        'Modules\\Meetup\\Providers\\MeetupServiceProvider',
        'Modules\\Meetup\\Providers\\EventServiceProvider',
        'Modules\\Meetup\\Providers\\Filament\\AdminPanelProvider',
    ],
];
