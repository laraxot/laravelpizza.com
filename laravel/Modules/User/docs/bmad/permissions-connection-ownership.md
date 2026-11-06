---
title: "permissions: ownership connessione user"
type: bug-audit
module: User
status: active
created: 2026-10-18
updated: 2026-10-18
tags: [bmad, second-brain, filament-blueprint, permissions, connection, spatie]
qmd: "permissions fixcity_user connection user ownership spatie"
related:
  - ./decision-log.md
  - ./authentication-logs-connection-ownership.md
  - ./stories/permissions-tables-fix.story.md
  - ../permissions.md
  - ../../../Fixcity/docs/second-brain.md
---

# permissions vive su `fixcity_user`

## Decisione

Sì: `permissions` (e il cluster Spatie `roles`, `model_has_permission`,
`model_has_role`, `role_has_permission`) appartiene al modulo **User**,
connessione Eloquent `user`, database `DB_DATABASE_USER` (in FixCity:
`fixcity_user`). Non va creata né letta su `fixcity_data`.

## Perché

- Identity/authorization è dominio User, non dominio civico Fixcity.
- `Modules\User\Models\Permission` e `Role` dichiarano `$connection = 'user'`.
- Spatie `PermissionRegistrar` fa `select * from permissions` a ogni
  `$user->can(...)`: se la tabella manca o la connessione punta al DB dati,
  anche una pagina pubblica (dettaglio ticket) esplode in HTTP 500.
- Filament blueprint: `PermissionResource` / `RoleResource` nel panel User.
- Stesso confinamento di `users`, `devices`, `authentication_logs`, OAuth.

## Sintomo produzione (fixcity.eu)

```
GET /it/tickets/1
Connection: user, Database: fixcity_data
Table 'fixcity_data.permissions' doesn't exist
BuildTicketTimelineAction → $viewer->can(...)
```

La connessione si chiama `user` ma punta a `fixcity_data`: tipicamente
`DB_DATABASE_USER` errato (uguale a `DB_DATABASE`) oppure cache config stale,
oppure migrazioni User non eseguite sul DB utente.

## Deploy corretto

1. `.env`: `DB_DATABASE_USER=fixcity_user` (distinto da `DB_DATABASE=fixcity_data`).
2. `php artisan config:clear` (obbligatorio se la cache aveva `user → fixcity_data`).
3. Migrare il modulo User: le tabelle vengono create dalle rispettive migration
   canoniche `create_*` idempotenti (`roles`, `permissions`, pivots).
4. Verificare:
   `Schema::connection('user')->hasTable('permissions') === true`
   e `DB::connection('user')->getDatabaseName() === 'fixcity_user'`.

Il fail-safe in `config/local/fixcity/database.php` e
`Modules/Fixcity/config/database.php` riporta `user` a `fixcity_user` se
`DB_DATABASE_USER === DB_DATABASE`. Non sostituisce la correzione del `.env`.

## Codice

- Model: `Modules\User\Models\Permission` (`$connection = 'user'`).
- Config Spatie: `config('permission.models.permission')` → model User.
- Migration canonica: `database/migrations/2023_01_22_000007_create_permissions_table.php`.
- Soft-guard frontoffice: `BuildTicketTimelineAction` salta il check operatore
  se `permissions` manca sulla connessione `user` (pagina ticket non 500).

## Filament Blueprint

Resource già presente: `Modules\User\Filament\Resources\PermissionResource`
(e `RoleResource`). Nessuna Resource Fixcity: i permessi non sono dominio civico.
