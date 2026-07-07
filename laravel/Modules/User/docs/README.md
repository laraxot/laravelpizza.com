# Modulo User - Documentazione Completa

## Overview

Il modulo **User** gestisce l'autenticazione, l'autorizzazione e la gestione utenti completa nel sistema Laraxot Quaeris.

## Funzionalità Principali

### Autenticazione
- Login multi-tenant
- Gestione sessioni sicure
- Two-factor authentication (opzionale)

### Autorizzazione
- RBAC (Role-Based Access Control) via Spatie Permission
- Teams e Tenant isolation
- Policy Filament integrate

### Modelli

```php
// User base model
Modules\User\Models\User extends BaseModel

// Team management
Modules\User\Models\Team

// Tenant isolation  
Modules\User\Models\Tenant
```

## Trait Disponibili

| Trait | Scopo | Requisiti |
|-------|-------|-----------|
| `HasTeams` | Gestione team multipli | `HasRoles` |
| `HasTenants` | Multi-tenancy Filament | `HasRoles` |
| `HasAuthenticationLogTrait` | Logging autenticazioni | - |

## Collegamenti

- [Documentazione Root](../../../docs/USER_MODULE.md)
- [Regole Trait](./traits.md)
- [Filament Resources](./filament/)

## Backlinks

- [Xot Base](../Xot/docs/)
- [Tenant Module](../Tenant/docs/)
- [UI Components](../UI/docs/)

## Architectural Rules — Violations Fixed

<<<<<<< HEAD
=======
### Module Directory Structure Standard
In compliance with the [Global Rule](../../../docs/wiki/rules/module-root-php-folders-forbidden.md), all root-level capitalized directories (`Actions/`, `Application/`, `Database/`, `Events/`, `Listeners/`) have been moved into `app/` or renamed to lowercase `database/`. 
- **app/**: Home for all PHP functional code (mapped via PSR-4).
- **database/**: Strictly lowercase for migrations/factories/seeders.

### PHPStan Memory Management
Per evitare crash dei parallel workers su analisi massive, usare sempre:
`php -d memory_limit=-1 ./vendor/bin/phpstan analyse [target] --memory-limit=-1`

### Profiles migration governance
- La tabella `profiles` deve avere sia `id` sia `uuid`.
- Il modulo User usa **una sola migrazione autorevole** per `profiles`: `*_create_profiles_table.php`.
- Se manca una colonna come `uuid`, si corregge quella migrazione e si aggiorna il timestamp del file; non si crea una migrazione `add_uuid_to_profiles`.
- Riferimento canonico: [wiki/concepts/profile-migration-uuid-contract.md](./wiki/concepts/profile-migration-uuid-contract.md)

>>>>>>> 6d3760fe (.)
### No Log calls in production code
`Log::info()`, `Log::debug()`, `Log::error()` are forbidden in Actions, Models, Services, and Widgets.
Found and removed from `RegisterWidget`. Laravel logs unhandled exceptions automatically.
See: [no-log-in-production.md](./no-log-in-production.md)

### Git merge conflicts in migrations
46 migration files in `database/migrations/` had unresolved conflict markers (`<<<<<<< HEAD`, `=======`, `>>>>>>>`).
These break PHP syntax and halt PHPStan entirely. All were resolved.
Rule: never commit files with conflict markers. Fix immediately when found.

## Requisiti

- PHP 8.3+
- Laravel 11/12
- Spatie Laravel Permission
- Filament v5
