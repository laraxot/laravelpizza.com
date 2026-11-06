<?php

declare(strict_types=1);
use Modules\User\Models\OauthAuthCode;
use Modules\User\Models\OauthClient;
use Modules\User\Models\OauthDeviceCode;
use Modules\User\Models\OauthPersonalAccessClient;
use Modules\User\Models\OauthRefreshToken;
use Modules\User\Models\OauthToken;

/*
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
        'access_token' => 15,
        'refresh_token' => 30,
        'personal_access_token' => 6,
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
    'enable_password_grant' => true,

    /*
    |--------------------------------------------------------------------------
    | Routes
    |--------------------------------------------------------------------------
    |
    | Configurazione delle rotte Passport.
    | Se false, le rotte non vengono registrate automaticamente.
    |
    */
    'register_routes' => true,

    /*
    |--------------------------------------------------------------------------
    | Client Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazione del modello Client personalizzato.
    |
    */
    'client_model' => OauthClient::class,

    /*
    |--------------------------------------------------------------------------
    | Token Model Configuration
    |--------------------------------------------------------------------------
    |
    | Configurazione dei modelli token personalizzati.
    |
    */
    'models' => [
        'token' => OauthToken::class,
        'refresh_token' => OauthRefreshToken::class,
        'auth_code' => OauthAuthCode::class,
        'personal_access_client' => OauthPersonalAccessClient::class,
        'device_code' => OauthDeviceCode::class,
    ],
];
