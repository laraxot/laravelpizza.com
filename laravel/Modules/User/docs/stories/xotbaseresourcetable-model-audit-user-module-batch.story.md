---
title: "XotBaseResourceTable: audit \$model + verifica colonne (batch modulo User)"
type: story
module: User
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-user-module-batch
status: done
cold_gate: null
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_user_fila5.git"
github_issue: 91
github_discussion: null
estimated_effort: "2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/User/app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php"
  - "laravel/Modules/User/app/Filament/Resources/RoleResource/Tables/RolesTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SocialiteUserResource/Tables/SocialiteUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SocialProviderResource/Tables/SocialProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/SsoProviderResource/Tables/SsoProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamInvitationResource/Tables/TeamInvitationsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamPermissionResource/Tables/TeamPermissionsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamResource/Tables/TeamsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TeamUserResource/Tables/TeamUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantResource/Tables/CustomersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantResource/Tables/TenantsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/TenantUserResource/Tables/TenantUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/UserResource/Tables/UsersTable.php"
related: []
---

# XotBaseResourceTable: audit $model + verifica colonne (batch modulo User)

## Story

Come manutentore, voglio che ogni `*Table extends XotBaseResourceTable` del
modulo User dichiari esplicitamente `protected static string $model` (preso
dalla Resource sorella, mai indovinato dal nome file) e che `getTableColumns()`
sia verificato contro lo schema reale, così da eliminare ambiguità già
osservate altrove nel repo (es. `ActivitysTable` vs `ActivitiesTable`) e
intercettare colonne fantasma prima che arrivino in produzione.

## Contesto / Baseline

I 13 file avevano già `protected static string $model` popolato da una
sessione precedente (working tree condivisa, modifiche non committate — vedi
`git status` all'apertura di questo turno). Ho verificato ogni valore contro
la Resource sorella (property `$model` o `getModel()`, mai il filename) e
confermato che sono tutti corretti, incluso il caso non ovvio di
`TenantResource` che risolve dinamicamente `XotData::getTenantClass()` →
`config('xot.tenant_class')` → in questo progetto `Modules\Quaeris\Models\Customer`
(non `Modules\User\Models\Tenant`, che pure esiste con una propria migration
"tenants" mai attivata da config).

## Acceptance Criteria

<!-- LOCKED. -->

1. Tutti i 13 file hanno `protected static string $model = X::class;` con `X`
   verificato contro la Resource sorella (mai dal nome del file).
2. `getTableColumns()` di ognuno verificato contro lo schema reale — rispettando
   la connection DB del model (`Schema::connection('user')` per i model che
   dichiarano `protected $connection = 'user'`, DB fisico `quaeris_user`
   diverso dal default `quaeris_data`).
3. Colonne non verificabili (chiavi con relazione, es. `x.y`) saltate.
4. Colonne sospette segnalate con file:riga, NON rimosse salvo typo certo al
   100%.
5. Migliorie UX additive solo dove giustificate da un cast/tipo reale.
6. `php -l` pulito su tutti i file toccati; PHPStan pulito sui file toccati.
7. Lock/unlock rispettati per ogni file editato in questo turno.
8. Story + issue GitHub collegati e aggiornati.

## Tasks / Subtasks

<!-- LOCKED. -->

- [x] Verifica `$model` per i 13 file contro la Resource sorella (AC: 1)
- [x] Verifica schema reale per i 13 file, rispettando `$connection` per-model (AC: 2, 3)
- [x] Segnalazione colonne sospette con evidenza file:riga (AC: 4)
- [x] Migliorie UX additive minime (badge/sortable su 5 colonne enum-like già in schema) (AC: 5)
- [x] `php -l` + PHPStan sui file toccati (AC: 6)
- [x] Lock/unlock per ogni file editato in questo turno (AC: 7)
- [x] Issue #91 + questa story (AC: 8)

## Dev Notes

<!-- LOCKED. -->

### $model — tutti confermati corretti

| File | Model | Come verificato |
|---|---|---|
| ProfilesTable.php | `Modules\User\Models\Profile` | `ProfileResource::$model` |
| RolesTable.php | `Modules\User\Models\Role` | `RoleResource::$model` |
| SocialiteUsersTable.php | `Modules\User\Models\SocialiteUser` | `SocialiteUserResource::$model` |
| SocialProvidersTable.php | `Modules\User\Models\SocialProvider` | `SocialProviderResource::$model` |
| SsoProvidersTable.php | `Modules\User\Models\SsoProvider` | `SsoProviderResource::$model` |
| TeamInvitationsTable.php | `Modules\User\Models\TeamInvitation` | `TeamInvitationResource::$model` |
| TeamPermissionsTable.php | `Modules\User\Models\TeamPermission` | `TeamPermissionResource::$model` |
| TeamsTable.php | `Modules\User\Models\Team` | `TeamResource::getModel()` → `XotData::getTeamClass()` (default, nessun override in config) |
| TeamUsersTable.php | `Modules\User\Models\TeamUser` | `TeamUserResource::$model` |
| CustomersTable.php | `Modules\Quaeris\Models\Customer` | `TenantResource::getModel()` → `getTenantClass()` → `config('xot.tenant_class')` (override attivo in tutti gli env `config/*/xra.php`) |
| TenantsTable.php | `Modules\Quaeris\Models\Customer` | idem — stessa Resource di CustomersTable, valore confermato coerente |
| TenantUsersTable.php | `Modules\User\Models\TenantUser` | `TenantUserResource::$model` |
| UsersTable.php | `Modules\Quaeris\Models\User` | `UserResource::getModel()` → `XotData::getUserClass()` → `config('auth.providers.users.model')` = `Modules\Quaeris\Models\User` |

### Colonne verificate — esito per file

**OK, nessuna colonna sospetta** (tutte le chiavi dirette esistono in schema
reale o in una migration owner non ancora applicata a questo DB dev):
ProfilesTable, RolesTable, SocialiteUsersTable, SocialProvidersTable (model
Sushi, verificato contro `$schema`/`$form` invece che DB), SsoProvidersTable
(tabella non ancora migrata in questo DB — verificato contro la migration),
TeamPermissionsTable, CustomersTable, UsersTable.

**Colonne sospette segnalate (NON toccate)**:

1. `TenantsTable.php:28-30` — `domain`, `is_active`, `trial_ends_at`. Queste tre
   colonne esistono solo su `Modules\User\Models\Tenant` / tabella `tenants`
   (vedi `database/migrations/2026_09_01_150110_create_tenants_table.php`),
   NON sul model realmente attivo per questa Resource
   (`Modules\Quaeris\Models\Customer` / tabella `customers`, migration
   `Modules/Quaeris/database/migrations/2023_01_01_000012_create_customers_table.php`:
   id, email, mobile_phone, timestamps, created_by/updated_by, name, team_id,
   user_id, slug — niente domain/is_active/trial_ends_at). Ipotesi: il file è
   stato scritto quando `tenant_class` puntava ancora al model `Tenant`
   nativo del modulo, poi il config è cambiato verso `Customer` (Quaeris) senza
   aggiornare le colonne. Verificato via `Schema::connection('quaeris_data')`
   diretto sulla tabella `customers` (esiste live, colonne confermate assenti).
2. `TenantUsersTable.php:27` (`role`) e `:29` (`uuid`) — nessuna migration di
   `tenant_user` (2 file duplicati trovati, `2023_01_01_000003` e
   `2026_01_01_000002`, identici) definisce queste colonne: `role` è
   letteralmente commentata nel codice sorgente della migration
   (`// $table->string('role')->nullable();`). Confermato anche via
   `Schema::connection('user')->getColumnListing('tenant_user')` (DB fisico
   `quaeris_user`, che è la connection dichiarata dal model `TenantUser`):
   `id,tenant_id,user_id,created_at,updated_at,updated_by,created_by,deleted_at,deleted_by`
   — né `role` né `uuid` presenti.
3. `TeamUsersTable.php:29` (`uuid`) — non esiste in nessuna delle 4 migration
   `team_user` trovate, né nello schema live
   (`Schema::connection('user')->getColumnListing('team_user')` →
   `id,team_id,user_id,role,created_at,updated_at,updated_by,created_by,deleted_at,deleted_by,permissions,joined_at`).
   Il model `TeamUser` dichiara `@property string $uuid` nel docblock ma senza
   backing reale (nessun accessor, nessuna colonna). `joined_at` invece è
   confermato presente live — non è sospetto.
4. `TeamsTable.php:27,29,32` (`slug`, `description`, `uuid`) — non presenti
   nello schema live (`teams`: `id,user_id,name,personal_team,created_at,updated_at`)
   ma DEFINITE nella migration owner più recente
   (`2026_08_06_142100_create_teams_table.php` /
   `2026_09_01_150109_create_teams_table.php`, blocco `tableUpdate`) — DB dev
   dietro rispetto alle migration, non un errore nel codice Table. Non
   modificato, solo annotato per completezza.
5. `TeamInvitationsTable.php:28-29` (`accepted_at`, `declined_at`) — stessa
   categoria: definite nella migration (
   `2023_01_01_000002_create_team_invitations_table.php`, sia nel blocco
   CREATE che UPDATE) ma assenti nello schema live via connection `user`
   (`id,team_id,email,role,created_at,updated_at,updated_by,created_by,deleted_at,deleted_by`).
   `deleted_at` invece è presente — coerente con `updateTimestamps($table, true)`.

**Nota ambientale**: il DB dev di questa sessione (connection default
`quaeris_data` + connection `user` = `quaeris_user`, entrambe su
`127.0.0.1`) risulta significativamente indietro rispetto alle migration più
recenti su più tabelle (`teams`, `team_invitations`, `roles`, `profiles`
erano tutte nello stesso stato prima di essere verificate — le prime tre
però hanno confermato le colonne referenziate esistere via schema live
sulla connection corretta). Non ho eseguito alcuna migration (vietato dal
mandato) — solo lettura schema.

### Migliorie UX applicate (additive, basso rischio)

- `ProfilesTable.php`: `phone` → aggiunto `->searchable()` (campo di ricerca
  naturale, colonna testo confermata in schema).
- `RolesTable.php`: `guard_name` → aggiunto `->badge()->sortable()` (valori a
  bassa cardinalità: `web`/`api`, confermato default `'web'` in migration).
- `SsoProvidersTable.php`: `type` → aggiunto `->badge()->sortable()` (enum
  documentato nel commento della migration: `saml, oidc, oauth`).
- `TeamInvitationsTable.php`: `role` → aggiunto `->badge()->sortable()`.
- `TeamUsersTable.php`: `role` → aggiunto `->badge()->sortable()`.

Nessuna colonna rimossa. Una chiave per riga rispettata in ogni array
toccato (nessuna modifica strutturale agli array, solo append di metodi
fluent sulle righe esistenti).

## Testing

<!-- LOCKED. -->

- `php -l` su tutti i 13 file (Task 1 pre-esistente + 5 file editati in
  questo turno) — nessun errore di sintassi.
- `vendor/bin/phpstan analyse <13 file>` dalla dir `laravel/` — 0 errori.

## Dependency Maps

Nessuna — modifiche isolate a classi Table, nessun consumatore esterno del
metodo `getTableColumns()` oltre a Filament stesso.

## Owned File/Module Scope

I 13 file in `owned_scope`. Nessun altro file toccato in questo turno.

## Learnings from Previous Stories

- Conferma diretta della lezione già in memoria
  `quaeris-user-auth-model-sorella-non-figlia`: la Resource è l'unica fonte
  autorevole per il model, mai il nome del file — qui si è manifestata anche
  nella forma "il model giusto secondo la Resource non è il model 'ovvio'
  per lo stesso nome di tabella" (`Tenant` vs `Customer`).
- Nuova lezione: quando un model dichiara `protected $connection`, la verifica
  schema va fatta con `Schema::connection($name)`, non con la connection di
  default — altrimenti si rischia di leggere una tabella fisicamente diversa
  (stesso nome, DB diverso) e produrre falsi negativi/positivi.

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Completion Notes List

- 2026-09-11: audit completo dei 13 file, 5 migliorie UX applicate, 5 colonne
  sospette documentate (non rimosse), issue #91 aperta e story chiusa.
- 2026-09-11: al momento del commit, `git status` risultava pulito sui 13
  file: una sessione concorrente sulla stessa working tree
  (`Claude-Session: session_01BDKnZidgEpXG7nwJWg7e6H`, commit `71a61955`
  "fase 1 audit" + `89efff94` "fase 3 audit", gia' mergiati in
  `laraxot/dev`) ha applicato — in parallelo e in modo indipendente — le
  stesse identiche modifiche byte-per-byte sui 5 file che avevo editato
  (`ProfilesTable.php` phone, `RolesTable.php` guard_name,
  `SsoProvidersTable.php` type, `TeamInvitationsTable.php` role,
  `TeamUsersTable.php` role). Nessun conflitto, nessun commit di codice
  necessario da parte mia: solo questa story (i findings Task 2 su
  `TenantsTable`/`TenantUsersTable`/`TeamUsersTable.uuid` sono fuori dallo
  scope dell'altro batch, che copriva OAuth/Passport/Permission — vedi
  issue collegata #90 di quel batch, distinta dalla #91 di questo).
