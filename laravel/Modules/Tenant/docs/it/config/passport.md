# Laravel Passport Configuration (

## Overview
This file documents the configuration options for Laravel Passport in the Tenant module.

## Config File (`config/passport.php`)
```php
return [
    // Encryption keys used to sign access tokens
    'private_key' => env('PASSPORT_PRIVATE_KEY'),
    'public_key' => env('PASSPORT_PUBLIC_KEY'),

    // Use UUIDs for client IDs?
    'client_uuids' => false,

    // Personal access client credentials
    'personal_access_client' => [
        'id' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_ID'),
        'secret' => env('PASSPORT_PERSONAL_ACCESS_CLIENT_SECRET'),
    ],

    // Storage driver configuration
    'storage' => [
        'database' => [
            'connection' => env('DB_CONNECTION', 'mysql'),
        ],
    ],
];
```

## Updating to Version 13
- Run `composer require laravel/passport "^13.4"` to upgrade.
- Publish and run migrations if not already published:
  - `php artisan vendor:publish --tag=passport-migrations`
  - `php artisan migrate`
- Execute `php artisan passport:install --uuids` to generate new encryption keys and default clients.
- Review and adjust any custom scopes in the config file.

## Resources
- Official docs: https://laravel.com/docs/12.x/passport
- GitHub repo: https://github.com/laravel/passport
- OAuth2 Server library: https://github.com/thephpleague/oauth2-server
- Tutorial 1: https://dev.to/anashussain284/laravel-authentication-using-passport-1gkk
- Tutorial 2: https://adevait.com/laravel/api-authentication-with-laravel-passport
- Additional guide: https://medium.com/@mrcyna/laravel-passport-and-microservice-architecture-ef6be7fcc79f

---
*Documentation reflects Laravel Passport version 13 as of January 2026.*
