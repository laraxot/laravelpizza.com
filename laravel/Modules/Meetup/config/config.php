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
    'description' => 'Event and Meetup Management Module - Gestione eventi e meetup per community Laravel',
    'icon' => 'heroicon-o-calendar-days',
    'version' => '1.0.0',

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
        'sort' => 40,
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
        'middleware' => ['web', 'auth'],
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
