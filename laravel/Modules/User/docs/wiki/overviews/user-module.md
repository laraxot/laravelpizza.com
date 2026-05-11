---
type: overview
module: User
sources:
  - ../../../docs/models.md
  - ../../../docs/permissions.md
  - ../../../docs/architecture.md
  - ../../../docs/structure.md
confidence: high
updated: 2026-04-15
---

# User Module — Overview

> **Ruolo**: Gestione utenti, autenticazione, autorizzazione (Spatie Permission), team, multi-tenancy, social auth, OAuth.

## Responsabilità del Modulo

Il modulo User è il sistema centrale di **identity e access management**:

- Gestisce `User`, `Profile`, `Team`, `Role`, `Permission`, `Tenant`
- Integra `spatie/laravel-permission` per RBAC granulare
- Supporta social auth via `Socialite` (`SocialProvider`)
- Gestisce OAuth con cluster di risorse Passport (`OAuth*` models)
- Tracciamento dispositivi (`Device`) per sicurezza
- Multi-tenancy via modello `Tenant`

## Modelli Core

| Modello | Scopo | Note |
|---------|-------|------|
| `User` | Entità utente principale | Estende `XotBaseModel` |
| `Profile` | Profilo utente esteso | `id` = UUID |
| `Team` | Team collaborativi | HasTeams trait |
| `TeamUser` | Membership team | Pivot con ruolo nel team |
| `Role` | Ruoli applicazione | Spatie Permission |
| `Permission` | Permessi granulari | Spatie Permission |
| `Tenant` | Multi-tenancy | Isolamento per organizzazione |
| `SocialProvider` | Auth sociale | GitHub, Google, ecc. |
| `Authentication` | Tracciamento login | Audit trail |
| `Device` | Device management | Sicurezza sessioni |

## Sistema Permessi (Spatie RBAC)

Il modulo usa `spatie/laravel-permission` con guard `web`:

```php
// Controllo permesso
if ($user->hasPermissionTo('moderate_doctors')) { ... }

// Controllo ruolo
if ($user->hasRole('moderator')) { ... }

// Filament — visibilità condizionale
Forms\Components\View::make('...')
    ->visible(fn () => Auth::user()->hasPermissionTo('moderate_doctors'))
```

### Ruoli principali

| Ruolo | Permessi inclusi |
|-------|-----------------|
| `moderator` | `moderate_doctors`, `view_doctors` |
| `admin` | tutti |
| `user` | accesso base |

### Seeder permessi

```php
// PermissionsSeeder::run()
Permission::firstOrCreate(['name' => 'moderate_doctors', 'guard_name' => 'web']);
Role::firstOrCreate(['name' => 'moderator', 'guard_name' => 'web'])
    ->givePermissionTo(['moderate_doctors', 'view_doctors']);
```

### Interfaccia admin

- Lista: `/admin/permissions`
- Creazione: `/admin/permissions/create`
- Modifica: `/admin/permissions/{id}/edit`

## Autenticazione

| Meccanismo | Implementazione |
|-----------|----------------|
| Standard | Filament Auth pages (login/register/reset) |
| Social | Socialite + `SocialProvider` model |
| OAuth API | Laravel Passport — cluster di risorse |
| 2FA | Disponibile (vedi `docs/2fa.md`) |

### Socialite governance

- Niente colonne provider-specific su `users` (es. `google_id`).
- Mapping identita esterna su `SocialiteUser`.
- Configurazione provider social su `SocialProvider`.
- Configurazioni enterprise federate su `SsoProvider` quando necessario.

### Logout

Il logout segue una gestione speciale via Folio + Volt:
- Route Folio con `volt('logout')` — anti-pattern da evitare: gestione manuale redirect
- Usare `auth()->logout()` + `redirect(LaravelLocalization::localizeUrl('/'))` nel component

## Multi-Tenancy

`Tenant` isola dati per organizzazione. Il `User` appartiene a un `Tenant` (connection name auto-scopata via Xot).

## Architettura

Segue rigorosamente Laraxot:
- **DRY & KISS**: nessuna duplicazione
- **PHPStan Level 10**: obbligatorio
- **XotBase**: sempre estendere `XotBase*`, mai classi Filament direttamente
- **Lang**: nessun `->label()` esplicito — `LangServiceProvider` gestisce tutto

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBaseModel base
- [[../../../../../../laravel/Modules/Lang/docs/wiki/overviews/lang-module|Lang Module]] — LangBase per traduzioni
- [[../../../../../../laravel/Modules/Fixcity/docs/wiki/index|Fixcity Module]] — usa User per owner_id ticket
- [[../../../../../../laravel/Modules/Tenant/docs/wiki/index|Tenant Module]] — isolamento multi-tenant

## Raw Sources Prioritari

- `docs/models.md` — analisi modelli, copertura factory, architettura
- `docs/permissions.md` — Spatie RBAC, permessi, ruoli, seeder
- `docs/architecture.md` — regole Laraxot nel modulo
- `docs/structure.md` — struttura directory
- `docs/2fa.md` — autenticazione due fattori
- `docs/oauth-cluster-implementation.md` — OAuth/Passport cluster
- `docs/team-user-permissions.md` — permessi team granulari
- `docs/wiki/concepts/socialite-provider-governance.md` — governance Socialite/SSO
- `docs/wiki/concepts/socialite-backoffice-google-setup.md` — setup Google OAuth da backoffice
