---
title: "Audit $model + schema colonne su 13 XotBaseResourceTable (OAuth/Passport/Permission)"
type: story
module: User
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-batch-user-oauth
status: done
cold_gate: null
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_user_fila5.git"
github_issue: "https://github.com/laraxot/module_user_fila5/issues/90"
github_discussion: null
estimated_effort: "2-3h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "app/Filament/Resources/ClientResource/Tables/OauthClientsTable.php"
  - "app/Filament/Resources/DeviceResource/Tables/DevicesTable.php"
  - "app/Filament/Resources/FeatureResource/Tables/FeaturesTable.php"
  - "app/Filament/Resources/OauthAccessTokenResource/Tables/OauthAccessTokensTable.php"
  - "app/Filament/Resources/OauthAuthCodeResource/Tables/OauthAuthCodesTable.php"
  - "app/Filament/Resources/OauthClientResource/Tables/ClientsTable.php"
  - "app/Filament/Resources/OauthClientResource/Tables/OauthClientsTable.php"
  - "app/Filament/Resources/OauthPersonalAccessClientResource/Tables/OauthPersonalAccessClientsTable.php"
  - "app/Filament/Resources/OauthRefreshTokenResource/Tables/OauthRefreshTokensTable.php"
  - "app/Filament/Resources/PasswordResetResource/Tables/PasswordResetsTable.php"
  - "app/Filament/Resources/PermissionResource/Tables/PermissionsTable.php"
  - "app/Filament/Resources/PersonalAccessTokenResource/Tables/OauthAccessTokensTable.php"
  - "app/Filament/Resources/PersonalAccessTokenResource/Tables/PersonalAccessTokensTable.php"
related:
  - "app/Filament/Resources/OauthClientResource.php"
  - "app/Filament/Resources/ClientResource.php"
  - "app/Models/Permission.php"
  - "app/Models/Device.php"
  - "database/migrations/2026_09_01_150112_create_permissions_table.php"
---

# Audit $model + schema colonne su 13 XotBaseResourceTable (OAuth/Passport/Permission)

## Story

Come sviluppatore che mantiene le Resource Filament del modulo User, voglio che ogni
classe `XotBaseResourceTable` dichiari esplicitamente il proprio `$model` (copiato
dalla Resource sorella, mai indovinato dal nome del file) e che le colonne in
`getTableColumns()` siano verificate contro lo schema reale della connessione
corretta, cosi' che non si scoprano a runtime colonne inesistenti o Table duplicate
mai usate.

## Contesto / Baseline

Batch assegnato: 13 file `XotBaseResourceTable` sotto `app/Filament/Resources/*`
(cluster OAuth/Passport, Device, Feature, PasswordReset, Permission,
PersonalAccessToken). All'apertura del batch, `git status` nel repo del modulo
mostrava questi 13 file (insieme ad altri ~24 non in questo batch) gia' modificati
nel working tree con la property `protected static string $model` aggiunta — lavoro
di un batch/agente precedente in esecuzione in parallelo sullo stesso repo. Verificato
uno per uno (vedi sotto) che il valore di `$model` gia' presente e' corretto contro
la Resource sorella; nessuna riscrittura necessaria per il Task 1.

Durante il lavoro, un secondo batch parallelo ("fase 3 audit: piccoli affinamenti
UX colonne", commit `89efff94`) ha fatto merge su `dev` aggiungendo
`->searchable()->sortable()` anche su `display_name` in `PermissionsTable.php` —
proprio la colonna che questa story segnala come inesistente nello schema reale.
Corretto (rimossi i due modificatori, colonna lasciata visibile) e documentato
con commento su GitHub issue #90, vedi Dev Agent Record.

Comando chiave per la verifica schema (NON la connessione di default — questo modulo
usa la connessione `user`, DB `quaeris_user`, diversa dalla connessione `mysql` di
default, DB `quaeris_data`):

```
Illuminate\Support\Facades\Schema::connection($model->getConnectionName())->getColumnListing($table)
```

## Acceptance Criteria

1. Ogni file della lista ha `protected static string $model = X::class;` con `X`
   verificato contro `getModel()`/`$model` della Resource sorella (mai dedotto dal
   nome del file Table).
2. Ogni colonna diretta (senza punto) in `getTableColumns()` e' verificata contro
   `Schema::connection(...)->getColumnListing()` sul model+connessione corretti;
   le colonne sospette sono documentate con file:riga, non rimosse d'iniziativa.
3. Migliorie UX additive solo dove il dato e' confermato esistente e a basso
   rischio (nessuna rimozione di colonne esistenti).
4. `php -l` pulito sui file toccati, `vendor/bin/phpstan analyse` a 0 errori sui 13
   file della lista.
5. Findings strutturali (schema mismatch, dead code) tracciati su GitHub issue
   collegata, non lasciati solo in questo file.

## Esplicitamente fuori scope

- Modificare `app/Filament/Resources/OauthClientResource.php` (la Resource, non la
  Table) anche se e' la causa radice del mismatch di colonne trovato su
  `OauthClientResource/Tables/ClientsTable.php` — file fuori dalla lista assegnata.
- Modificare `app/Models/Permission.php` (`$fillable`) o aggiungere una migration
  per `display_name`/`description` — decisione di design che richiede risposta
  esplicita (aggiungere le colonne vs rimuovere il campo), non un fix meccanico.
- Sanare il drift di migrazione su `devices.uuid` (nessuna `migrate` eseguita, per
  regola "i dati sono sacri" — mai comandi che scrivono sul DB in questo batch).
- Cancellare i due file Table duplicati/dead-code trovati — solo segnalati.

## Tasks / Subtasks

- [x] Task 1 — Verificare/confermare `$model` sui 13 file contro la Resource
  sorella (letta con `Read`, non indovinata). (AC: 1)
- [x] Task 2 — Risolvere il model+tabella reale di ciascun file via tinker
  (`new $model()->getTable()` + `getConnectionName()`) e confrontare
  `getTableColumns()` con `Schema::connection(...)->getColumnListing()`. (AC: 2)
- [x] Task 3 — Aggiungere `->sortable()`/`->searchable()` dove il dato reale lo
  giustifica e il rischio e' minimo. (AC: 3)
- [x] Task 4 — `php -l` + `vendor/bin/phpstan analyse` sui 13 file. (AC: 4)
- [x] Task 5 — Aprire issue GitHub con i findings strutturali, collegarla qui.
  (AC: 5)

## Dev Notes

- [Source: app/Filament/Resources/ClientResource.php#L30-L41] — `getModel()` e'
  dinamico: `Passport::clientModel()` con fallback a `Laravel\Passport\Client`.
  Verificato via tinker che a runtime risolve `Modules\User\Models\OauthClient`
  (connessione `user`).
- [Source: app/Filament/Resources/OauthClientResource.php#L20] — `$model` e'
  hardcoded a `Laravel\Passport\Client` (connessione di default `mysql`), diverso
  dal model dinamico usato da `ClientResource`.
- [Source: app/Filament/Resources/DeviceResource.php#L12] — `$model = Device::class`.
- [Source: app/Filament/Resources/FeatureResource.php#L18] — `$model = Feature::class`.
- [Source: app/Filament/Resources/OauthAccessTokenResource.php#L18] — `$model =
  OauthAccessToken::class`.
- [Source: app/Filament/Resources/OauthAuthCodeResource.php#L27] — `$model =
  OauthAuthCode::class`.
- [Source: app/Filament/Resources/OauthPersonalAccessClientResource.php#L16] —
  `$model = OauthPersonalAccessClient::class`.
- [Source: app/Filament/Resources/OauthRefreshTokenResource.php#L25] — `$model =
  OauthRefreshToken::class`.
- [Source: app/Filament/Resources/PasswordResetResource.php#L15] — `$model =
  PasswordReset::class`.
- [Source: app/Filament/Resources/PermissionResource.php#L20] — `$model =
  Permission::class`.
- [Source: app/Filament/Resources/PersonalAccessTokenResource.php#L13] — `$model =
  OauthAccessToken::class`.
- [Source: Modules/Xot/app/Filament/Resources/XotBaseResource.php#L185-L200] —
  `getTableClass()` risolve la Table attiva per convenzione:
  `static::class . '\Tables\\' . Str::plural(class_basename(static::getModel())) .
  'Table'`. Usato per identificare le due coppie di Table duplicate come dead code.
- [Source: tinker `Schema::connection('user')->getColumnListing('permissions')`] —
  colonne reali: `id,name,guard_name,created_at,updated_at,updated_by,created_by`.
  `display_name`/`description` (in `app/Models/Permission.php` `$fillable` e in
  `PermissionsTable.php`) non esistono.
- [Source: database/migrations/2026_09_01_150112_create_permissions_table.php] —
  migration owner post-consolidamento, commento esplicito "Colonne unione viste
  nei duplicati non presenti qui: nessuna" — conferma che `display_name`/
  `description` non sono mai state nello schema intenzionale.
- [Source: tinker `Schema::connection('user')->getColumnListing('devices')`] —
  colonne reali senza `uuid`, nonostante la migration di CREATE
  (`2023_01_01_000000_create_devices_table.php`) lo preveda e il model
  (`app/Models/Device.php` `$fillable`/`casts()`/PHPDoc) lo dichiari. Drift di
  migrazione, non refuso della Table.
- [Source: tinker `Schema::connection('user')/'mysql'->getColumnListing('oauth_clients')`]
  — su connessione `user` (model `Modules\User\Models\OauthClient`): colonne
  `grant_types`,`redirect_uris`,`owner_id`,`owner_type` presenti. Su connessione
  `mysql` (model `Laravel\Passport\Client`, quella dichiarata da
  `OauthClientResource`): quelle 4 colonne NON esistono, ne' `updated_by`/
  `created_by`.

## Testing

```bash
cd /var/www/_bases/base_quaeris_fila5/laravel
php -l Modules/User/app/Filament/Resources/ClientResource/Tables/OauthClientsTable.php
php -l Modules/User/app/Filament/Resources/PermissionResource/Tables/PermissionsTable.php
vendor/bin/phpstan analyse \
  Modules/User/app/Filament/Resources/ClientResource/Tables/OauthClientsTable.php \
  Modules/User/app/Filament/Resources/DeviceResource/Tables/DevicesTable.php \
  Modules/User/app/Filament/Resources/FeatureResource/Tables/FeaturesTable.php \
  Modules/User/app/Filament/Resources/OauthAccessTokenResource/Tables/OauthAccessTokensTable.php \
  Modules/User/app/Filament/Resources/OauthAuthCodeResource/Tables/OauthAuthCodesTable.php \
  Modules/User/app/Filament/Resources/OauthClientResource/Tables/ClientsTable.php \
  Modules/User/app/Filament/Resources/OauthClientResource/Tables/OauthClientsTable.php \
  Modules/User/app/Filament/Resources/OauthPersonalAccessClientResource/Tables/OauthPersonalAccessClientsTable.php \
  Modules/User/app/Filament/Resources/OauthRefreshTokenResource/Tables/OauthRefreshTokensTable.php \
  Modules/User/app/Filament/Resources/PasswordResetResource/Tables/PasswordResetsTable.php \
  Modules/User/app/Filament/Resources/PermissionResource/Tables/PermissionsTable.php \
  Modules/User/app/Filament/Resources/PersonalAccessTokenResource/Tables/OauthAccessTokensTable.php \
  Modules/User/app/Filament/Resources/PersonalAccessTokenResource/Tables/PersonalAccessTokensTable.php \
  --no-progress
```

Esito reale (2026-09-11): `php -l` senza errori sui 2 file editati; PHPStan
`[OK] No errors` sui 13 file. Nessuna migration/seed/write DB eseguita — solo
`Schema::getColumnListing()` in lettura via `artisan tinker`.

## Dependency Maps

Non blocca ne' e' bloccata da altre story note. Genera pero' 4 follow-up impliciti
(vedi issue GitHub #90): fix `OauthClientResource::$model`, decisione su
`Permission::display_name`/`description`, sanare `devices.uuid`, pulizia dead code.
Nessuno di questi e' stato aperto come story separata in questo turno — solo
tracciato nell'issue, per rispettare lo scope della lista assegnata.

## Owned File/Module Scope

Questo batch tocca **solo** 2 dei 13 file con modifiche di codice (miglioria UX
additiva, vedi File List); gli altri 11 sono stati letti e verificati ma lasciati
invariati perche' gia' corretti (Task 1 gia' fatto da altro batch) o perche' un
edit sicuro non era identificabile (colonne sospette da non toccare senza
certezza al 100%).

## Learnings from Previous Stories

- `Schema::getColumnListing()` senza specificare la connessione del model usa la
  connessione di default (`mysql`/`quaeris_data`), che in questo modulo puo'
  essere un DB diverso da quello reale del model (`user`/`quaeris_user`). Va
  sempre passato `Schema::connection($model->getConnectionName())`, altrimenti il
  risultato e' silenziosamente sbagliato (nel caso di `features` e' risultato un
  array vuoto invece di un errore, facile da scambiare per "tabella vuota di
  colonne" invece che "connessione sbagliata").
- Un ParseError con marker di merge (`<<<<<<< HEAD`) in un altro modulo
  (`Modules/Activity`) ha temporaneamente rotto il boot di `artisan tinker`
  (Filament `discoverResources()` autoload-a tutte le Resource di tutti i moduli
  abilitati). Il marker e' sparito da solo pochi minuti dopo (altra sessione in
  parallelo lo ha risolto) — coerente con la nota di memoria "i marker di merge
  vivono sul remote / race multi-agente sullo stesso repo": non e' stato un bug
  introdotto da questo batch, ne' e' stato "riparato" da questo batch.

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Completion Notes List

- 2026-09-11: Verificati i 13 `$model` contro le Resource sorelle (gia' presenti,
  corretti, aggiunti da altro batch parallelo — nessuna riscrittura necessaria).
- 2026-09-11: Verificate le colonne reali via `Schema::connection(...)` per tutti
  i model coinvolti; trovati 3 problemi strutturali (schema mismatch
  `OauthClientResource`, colonne fantasma `Permission::display_name`/
  `description`, drift `devices.uuid`) e 2 Table duplicate/dead-code — tutti
  documentati, nessuno modificato senza certezza al 100%.
- 2026-09-11: Applicate 2 migliorie UX additive a basso rischio (vedi File List).
- 2026-09-11: Aperta issue GitHub laraxot/module_user_fila5#90 con tutti i
  findings.
- 2026-09-11: Merge parallelo ha reintrodotto `->searchable()->sortable()` su
  `display_name` (colonna inesistente) in `PermissionsTable.php`; rimossi i due
  modificatori (colonna lasciata visibile), commentato inline con link
  all'issue, e postato un commento di aggiornamento su issue #90.

### File List

- `app/Filament/Resources/ClientResource/Tables/OauthClientsTable.php` (modificato:
  `->sortable()` su `owner_id`, `->searchable()->sortable()` su `owner_type`)
- `app/Filament/Resources/PermissionResource/Tables/PermissionsTable.php`
  (modificato: `->searchable()->sortable()` su `guard_name`)
- `app/Filament/Resources/DeviceResource/Tables/DevicesTable.php` (solo letto/verificato)
- `app/Filament/Resources/FeatureResource/Tables/FeaturesTable.php` (solo letto/verificato)
- `app/Filament/Resources/OauthAccessTokenResource/Tables/OauthAccessTokensTable.php` (solo letto/verificato)
- `app/Filament/Resources/OauthAuthCodeResource/Tables/OauthAuthCodesTable.php` (solo letto/verificato)
- `app/Filament/Resources/OauthClientResource/Tables/ClientsTable.php` (solo letto/verificato, findings segnalati)
- `app/Filament/Resources/OauthClientResource/Tables/OauthClientsTable.php` (solo letto/verificato, dead code segnalato)
- `app/Filament/Resources/OauthPersonalAccessClientResource/Tables/OauthPersonalAccessClientsTable.php` (solo letto/verificato)
- `app/Filament/Resources/OauthRefreshTokenResource/Tables/OauthRefreshTokensTable.php` (solo letto/verificato)
- `app/Filament/Resources/PasswordResetResource/Tables/PasswordResetsTable.php` (solo letto/verificato)
- `app/Filament/Resources/PersonalAccessTokenResource/Tables/OauthAccessTokensTable.php` (solo letto/verificato)
- `app/Filament/Resources/PersonalAccessTokenResource/Tables/PersonalAccessTokensTable.php` (solo letto/verificato, dead code segnalato)
