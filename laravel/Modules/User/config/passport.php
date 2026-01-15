<?php

declare(strict_types=1);

/**
 * Configurazione Laravel Passport per il modulo User.
 *
 * Questa configurazione centralizza tutte le impostazioni di Passport,
 * permettendo una gestione semplice e coerente dell'autenticazione OAuth2.
 */
return [
    /*
    |--------------------------------------------------------------------------
    | Token Expiration
    |--------------------------------------------------------------------------
    |
    | Configurazione delle scadenze dei token OAuth2.
    | I valori sono in giorni o mesi (usando CarbonInterval).
    |
    */
    'tokens' => [
        'access_token' => env('PASSPORT_ACCESS_TOKEN_EXPIRATION_DAYS', 15),
        'refresh_token' => env('PASSPORT_REFRESH_TOKEN_EXPIRATION_DAYS', 30),
        'personal_access_token' => env('PASSPORT_PERSONAL_ACCESS_TOKEN_EXPIRATION_MONTHS', 6),
    ],

    /*
    |--------------------------------------------------------------------------
    | OAuth Scopes
    |--------------------------------------------------------------------------
    |
    | Definizione degli scope OAuth2 disponibili.
    | Ogni scope ha una descrizione che viene mostrata durante l'autorizzazione.
    |
    */
    'scopes' => [
        'view-user' => 'View user information',
        'core-technicians' => 'Access to core technician features',
    ],

    /*
    |--------------------------------------------------------------------------
    | Password Grant
    |--------------------------------------------------------------------------
    |
    | Abilita il password grant (username/password) per OAuth2.
    | Utile per applicazioni mobile o SPA che necessitano di autenticazione diretta.
    |
    */
    'enable_password_grant' => env('PASSPORT_ENABLE_PASSWORD_GRANT', true),

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Configurazione delle rotte Passport.
    | Se false, le rotte non vengono registrate automaticamente.
    |
    */
    'register_routes' => env('PASSPORT_REGISTER_ROUTES', true),

    /*
    |--------------------------------------------------------------------------
    | Client Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazione del modello Client personalizzato.
    |
    */
    'client_model' => Modules\User\Models\OauthClient::class,

    /*
    |--------------------------------------------------------------------------
    | Token Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazione dei modelli token personalizzati.
    |
    */
    'models' => [
        'token' => Modules\User\Models\OauthToken::class,
        'refresh_token' => Modules\User\Models\OauthRefreshToken::class,
        'auth_code' => Modules\User\Models\OauthAuthCode::class,
        'personal_access_client' => Modules\User\Models\OauthPersonalAccessClient::class,
        'device_code' => Modules\User\Models\OauthDeviceCode::class,
    ],
];
