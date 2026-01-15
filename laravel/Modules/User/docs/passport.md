# Laravel Passport Documentation (Version 13.4.x)

## Overview
Laravel Passport provides a full OAuth2 server implementation for your Laravel application. It allows you to issue access tokens to your API clients and authenticate requests.  
In Laraxot/PTVX viene usato con Laravel 12 e versione `^13.4` di Passport.

## Installation

```bash
composer require laravel/passport "^13.4"

# publish Passport migrations (una sola volta per progetto)
php artisan vendor:publish --tag=passport-migrations
php artisan migrate

# prima installazione: chiavi e client di default
php artisan passport:install --uuids
```

## Configuration

### Auth Guard

Nel file `config/auth.php` assicurarsi che il guard API usi `passport`:

```php
'guards' => [
    'web' => [
        'driver' => 'session',
        'provider' => 'users',
    ],

    'api' => [
        'driver' => 'passport',
        'provider' => 'users',
    ],
],
```

### Config file (`config/passport.php`)

- Centralizzare le opzioni in `config/passport.php` (lifetime, scopes, personal access client, ecc.).
- È possibile configurare le scadenze sia via config sia via codice:

```php
use Laravel\Passport\Passport;
use Carbon\CarbonInterval;

Passport::tokensExpireIn(CarbonInterval::days(15));
Passport::refreshTokensExpireIn(CarbonInterval::days(30));
Passport::personalAccessTokensExpireIn(CarbonInterval::months(6));
```

### Chiavi

- In produzione è preferibile caricare le chiavi da un percorso sicuro:

```php
Passport::loadKeysFrom(base_path('oauth-keys'));
```

## Grant Types e Flussi supportati

- **Authorization Code + PKCE**: flusso raccomandato per SPA e applicazioni pubbliche.
- **Client Credentials**: per comunicazioni server‑to‑server tra servizi interni.
- **Personal Access Tokens (PAT)**: per operatori e script; gestiti tramite risorse Filament dedicate nel modulo User.
- **Password Grant**:
  - Nelle versioni recenti è disabilitato di default.
  - Va abilitato solo se strettamente necessario:

```php
use Laravel\Passport\Passport;

public function boot(): void
{
    Passport::enablePasswordGrant();
}
```

## Usage (high level)

- Protezione API con middleware:
  - `auth:api` + `scope` / `scopes` per restringere l’accesso.
- Scopes:
  - definire sempre `Passport::tokensCan([...])` e, se opportuno, `Passport::setDefaultScope([...])`;
  - documentare gli scope in `docs/` (User, Tenant, moduli che consumano API).
- Eventi:
  - utilizzare eventi come `AccessTokenCreated`, `RefreshTokenCreated`, `AccessTokenRevoked` per logging/audit.

## Resources

- [Administrative Actions in UI](./passport_admin_actions.md)
- Official docs: https://laravel.com/docs/12.x/passport  
- GitHub repo: https://github.com/laravel/passport  
- OAuth2 Server library: https://github.com/thephpleague/oauth2-server  
- Tutorial 1: https://dev.to/anashussain284/laravel-authentication-using-passport-1gkk  
- Tutorial 2: https://adevait.com/laravel/api-authentication-with-laravel-passport  
- Additional guide: https://medium.com/@mrcyna/laravel-passport-and-microservice-architecture-ef6be7fcc79f

## Migration Notes

- Se aggiorni da versioni più vecchie:
  - esegui le migrazioni pubblicate (`passport-migrations`);
  - verifica i client esistenti e, se necessario, ricrea i personal access client:

```bash
php artisan passport:client --personal
```

- Aggiorna eventuali scopes custom in `config/passport.php` e nelle policy.

---
*Questa documentazione riflette la versione stabile 13.4.x di Laravel Passport (stato: gennaio 2026).*
