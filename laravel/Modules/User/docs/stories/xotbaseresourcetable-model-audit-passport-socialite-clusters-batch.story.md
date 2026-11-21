---
title: "XotBaseResourceTable: audit $model + verifica colonne (batch Passport/Socialite clusters + AuthLog/BaseProfile/BaseUser/Client)"
type: story
module: User
epic: null
story_id: null
slug: xotbaseresourcetable-model-audit-passport-socialite-clusters-batch
status: done
cold_gate: null
created: '2026-09-11'
updated: '2026-09-11'
repository: "https://github.com/laraxot/module_user_fila5.git"
github_issue: 92
github_discussion: null
estimated_effort: "2h"
blocked_by: []
blocks: []
supersedes: []
owned_scope:
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Tables/OauthAccessTokensTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Tables/OauthAuthCodesTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Tables/OauthClientsTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Tables/OauthDeviceCodesTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthPersonalAccessClientResource/Tables/OauthPersonalAccessClientsTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Passport/Resources/OauthRefreshTokenResource/Tables/OauthRefreshTokensTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Socialite/Resources/SocialiteUserResource/Tables/SocialiteUsersTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Socialite/Resources/SocialProviderResource/Tables/SocialProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Clusters/Socialite/Resources/SsoProviderResource/Tables/SsoProvidersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/AuthenticationLogResource/Tables/AuthenticationLogsTable.php"
  - "laravel/Modules/User/app/Filament/Resources/BaseProfileResource/Tables/BaseProfilesTable.php"
  - "laravel/Modules/User/app/Filament/Resources/BaseUserResource/Tables/BaseUsersTable.php"
  - "laravel/Modules/User/app/Filament/Resources/ClientResource/Tables/ClientsTable.php"
related:
  - "docs/stories/xotbaseresourcetable-model-audit-batch-user-oauth.story.md"
  - "docs/stories/xotbaseresourcetable-model-audit-user-module-batch.story.md"
---

# XotBaseResourceTable: audit $model + verifica colonne (batch Passport/Socialite clusters + AuthLog/BaseProfile/BaseUser/Client)

## Story

Come manutentore, voglio che ogni `*Table extends XotBaseResourceTable` dei
cluster Passport/Socialite e delle Resource AuthenticationLog/BaseProfile/
BaseUser/Client dichiari esplicitamente `protected static string $model`
(preso dalla Resource sorella o da `getModel()`, mai indovinato dal nome
file) e che `getTableColumns()` sia verificato contro lo schema reale,
rispettando la connection DB specifica di ciascun model.

## Contesto / Baseline

All'apertura di questo turno i 13 file avevano già `$model` popolato (working
tree condivisa, modifiche non committate di una sessione precedente/parallela
— confermato via `git diff --stat` prima di editare nulla). Ho verificato
ogni valore contro la fonte autorevole (property `$model` o `getModel()`
della Resource sorella, con tracciamento della catena dinamica dove
applicabile), mai contro il nome del file.

## Acceptance Criteria

<!-- LOCKED. -->

1. Tutti i 13 file hanno `protected static string $model = X::class;` con `X`
   verificato contro la Resource sorella (mai dal nome del file).
2. `getTableColumns()` di ognuno verificato contro lo schema reale,
   rispettando la connection DB del model (`Schema::connection($name)`) —
   non la connection di default.
3. Colonne non verificabili (chiavi con relazione, es. `user.name`) saltate.
4. Colonne sospette segnalate con file:riga, NON rimosse salvo typo certo al
   100%.
5. Migliorie UX additive solo dove giustificate da consistenza interna al
   batch o da un cast/tipo reale.
6. `php -l` pulito su tutti i file toccati; PHPStan pulito sui file toccati.
7. Lock/unlock rispettati per ogni file editato in questo turno.
8. Story + issue GitHub collegati e aggiornati.

## Esplicitamente fuori scope

- I model file (`app/Models/OauthDeviceCode.php`, ecc.) — solo le classi
  Table sono in `owned_scope`, anche quando un finding riguarda un model.
- I file `ClientResource/Tables/OauthClientsTable.php`,
  `SocialiteUserResource/Tables/SocialiteUsersTable.php` (top-level, non
  cluster) e simili — appartengono ad altri batch/issue (#90, #91), non
  toccati qui anche se il finding li cita per contesto.
- Cancellazione di file dead-code identificati (`BaseUsersTable.php`,
  `BaseProfilesTable.php`, `ClientsTable.php`) — segnalati, non rimossi, per
  policy esplicita del mandato.

## Tasks / Subtasks

<!-- LOCKED. Ogni riga mappata a un AC. -->

- [x] Verifica `$model` per i 13 file contro la Resource sorella / `getModel()` (AC: 1)
- [x] Verifica schema reale per i 13 file, rispettando `$connection` per-model (AC: 2, 3)
- [x] Segnalazione colonne sospette e dead-code con evidenza (AC: 4)
- [x] Migliorie UX additive minime (3 colonne, coerenza interna al batch) (AC: 5)
- [x] `php -l` + PHPStan sui 13 file toccati (AC: 6)
- [x] Lock/unlock per i 3 file editati in questo turno (AC: 7)
- [x] Issue #92 + questa story (AC: 8)

## Dev Notes

<!-- LOCKED. Ogni affermazione con [Source: ...]. -->

### $model — tutti confermati corretti

| File | Model | Come verificato |
|---|---|---|
| OauthAccessTokensTable.php | `Modules\User\Models\OauthAccessToken` | [Source: app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource.php#L36] `$model` esplicito |
| OauthAuthCodesTable.php | `Modules\User\Models\OauthAuthCode` | [Source: .../OauthAuthCodeResource.php#L22] `$model` esplicito |
| OauthClientsTable.php (Passport) | `Modules\User\Models\OauthClient` | [Source: .../OauthClientResource.php#L51-65] `getModel()` → `LaravelPassport::clientModel()` → [Source: app/Providers/PassportServiceProvider.php#L119-127] `config('user.passport.client_model', OauthClient::class)` + `Passport::useClientModel($clientModel)`; default confermato in [Source: config/passport.php#L77] `'client_model' => OauthClient::class` |
| OauthDeviceCodesTable.php | `Modules\User\Models\OauthDeviceCode` | [Source: .../OauthDeviceCodeResource.php#L31] `$model` esplicito |
| OauthPersonalAccessClientsTable.php | `Modules\User\Models\OauthPersonalAccessClient` | [Source: .../OauthPersonalAccessClientResource.php#L32] `$model` esplicito |
| OauthRefreshTokensTable.php | `Modules\User\Models\OauthRefreshToken` | [Source: .../OauthRefreshTokenResource.php#L28] `$model` esplicito |
| SocialiteUsersTable.php (cluster) | `Modules\User\Models\SocialiteUser` | [Source: Clusters/Socialite/Resources/SocialiteUserResource.php#L22] `$model` esplicito |
| SocialProvidersTable.php (cluster) | `Modules\User\Models\SocialProvider` | [Source: Clusters/Socialite/Resources/SocialProviderResource.php#L23] `$model` esplicito |
| SsoProvidersTable.php (cluster) | `Modules\User\Models\SsoProvider` | [Source: Clusters/Socialite/Resources/SsoProviderResource.php#L25] `$model` esplicito |
| AuthenticationLogsTable.php | `Modules\User\Models\AuthenticationLog` | [Source: app/Filament/Resources/AuthenticationLogResource.php#L15] `$model` esplicito |
| BaseProfilesTable.php | `Modules\User\Models\BaseProfile` (abstract) | [Source: app/Filament/Resources/BaseProfileResource.php#L16] `$model` esplicito — coerente con il pattern "Base*" astratto pensato per essere esteso dai progetti consumer |
| BaseUsersTable.php | `Modules\User\Models\BaseUser` (abstract) | `BaseUserResource::$model` e' commentato; risolto via [Source: Modules/Xot/app/Filament/Resources/XotBaseResource.php#L97-125] `getModel()` fallback per convenzione (`Str::before(class_basename(static::class), 'Resource')` = `BaseUser`) — coincide col valore gia' presente |
| ClientsTable.php (top-level ClientResource) | `Modules\User\Models\OauthClient` | [Source: app/Filament/Resources/ClientResource.php#L27-39] `getModel()` → `Passport::clientModel()` → stesso fallback `OauthClient::class`, stessa config |

### Colonne verificate — esito per file

**Nota metodologica critica**: questo modulo usa connection DB per-model
diverse da quella di default (`protected $connection = 'user'` → DB fisico
`quaeris_user`; `'quaeris'` per il model `Profile` concreto → DB
`quaeris_data` ma schema separato). Un primo giro di verifica fatto con
`Schema::getColumnListing()` (connection di default, senza specificarla) ha
prodotto **8 falsi positivi** (`grant_types`, `redirect_uris`, `owner_id`,
`owner_type` su `oauth_clients`; `is_otp`, `type`, `state`,
`password_expires_at` su `users`) — tutti rientrati verificando con
`Schema::connection($model->getConnectionName())->getColumnListing(...)`.
Confermato anche indipendentemente dal batch parallelo issue #90 sullo
stesso modulo.

**OK, nessuna colonna sospetta residua** dopo la verifica con connection
corretta: OauthAccessTokensTable, OauthAuthCodesTable, OauthClientsTable
(Passport), OauthPersonalAccessClientsTable, OauthRefreshTokensTable,
SocialiteUsersTable, SsoProvidersTable, AuthenticationLogsTable,
BaseUsersTable, ClientsTable.

- `SocialProvidersTable.php`: model Sushi (`SushiToPhpArray`, righe da
  `GetTenantConfigArrayAction` a runtime, nessuna migration/tabella fissa).
  Verificato contro il PHPDoc `@property` del model
  [Source: app/Models/SocialProvider.php#L16-46] — tutte le chiavi
  (`name`, `active`, `socialite`, `stateless`, `scopes`, `id`, `created_at`,
  `updated_at`) documentate. Config tenant vuota in questo ambiente
  (`getSushiRows()` → `[]`), quindi zero righe reali da rompere.
- `OauthDeviceCodesTable.php`: tabella assente sia su connection `mysql`
  (default, quella usata dal model — vedi finding sotto) sia su `user`.
  Verificato contro la migration vendor
  [Source: vendor/laravel/passport/database/migrations/2024_06_01_000001_create_oauth_device_codes_table.php] —
  colonne `id, user_id, client_id, user_code, scopes, revoked,
  user_approved_at, last_polled_at, expires_at` — tutte le chiavi
  referenziate (`user_id`, `client_id`, `revoked`, `user_approved_at`,
  `expires_at`, `last_polled_at`, `scopes`) presenti; nessun `created_at`/
  `updated_at` nella tabella, e infatti la Table non li referenzia.
- `BaseProfilesTable.php`: `user.name` (relazione, non verificabile via
  Schema, saltata). `first_name`/`last_name`/`email` presenti su
  `Schema::connection('quaeris')->getColumnListing('profiles')`. `is_active`
  **non presente** sul DB dev corrente via la connection corretta, ma
  verificato come intenzionale: `$fillable`
  [Source: app/Models/BaseProfile.php#L101], cast boolean
  [Source: app/Models/BaseProfile.php#L215], e definito in 6 migration
  `create_profiles_table` duplicate incluso l'owner piu' recente datato
  [Source: database/migrations/2026_09_01_150108_create_profiles_table.php#L57,L146-147] —
  drift ambientale pre-esistente (il modulo ha ≥6 migration quasi-duplicate
  per `profiles`, stesso pattern gia' noto per `users`), non un difetto del
  codice Table. Non toccato (era gia' cosi' prima del mio unico edit su
  `is_active`, che ha solo aggiunto `->sortable()`).

### Findings aggiuntivi (fuori `owned_scope`, solo segnalati)

1. **`OauthDeviceCode` model non allineato ai fratelli**
   [Source: app/Models/OauthDeviceCode.php] — a differenza di
   `OauthAccessToken`, `OauthAuthCode`, `OauthClient`,
   `OauthPersonalAccessClient`, `OauthRefreshToken` (tutti
   `protected $connection = 'user';`), `OauthDeviceCode` non dichiara alcuna
   connection e risolve quindi al default (`mysql`), dove la tabella non
   esiste. Verificato via tinker: `(new OauthDeviceCode())->getConnectionName()`
   → `mysql` invece di `user`. File model, fuori da `owned_scope` di questa
   story.
2. **`BaseUserResource`/`BaseUsersTable` sono dead code in questo progetto**:
   `grep -rln "extends BaseUserResource"` non trova nulla;
   `Modules\User\Filament\Resources\UserResource extends XotBaseResource`
   direttamente, non `BaseUserResource`. La Table non e' mai risolta da
   `getTableClass()` in nessun percorso raggiungibile. Non cancellata (regola
   esplicita del mandato: mai di propria iniziativa).
3. **`BaseProfilesTable.php` e' dead code per convenzione `getTableClass()`**,
   nonostante `BaseProfileResource` sia effettivamente esteso da
   `ProfileResource` [Source: app/Filament/Resources/ProfileResource.php]:
   `XotBaseResource::getTableClass()`
   [Source: Modules/Xot/app/Filament/Resources/XotBaseResource.php#L185-200]
   costruisce il nome classe da `static::class` (il **chiamante concreto**,
   `ProfileResource`), non dalla classe astratta padre — quindi risolve
   `ProfileResource\Tables\ProfilesTable` (esistente,
   [Source: app/Filament/Resources/ProfileResource/Tables/ProfilesTable.php]),
   bypassando `BaseProfileResource\Tables\BaseProfilesTable` del tutto. Non
   cancellata.
4. **`ClientResource/Tables/ClientsTable.php` duplicato byte-per-byte** (a
   parte il nome classe) di `ClientResource/Tables/OauthClientsTable.php`
   (stesso `$model = OauthClient::class`, stesso `getTableColumns()`) — file
   non in questo batch. Per la stessa convenzione `getTableClass()`
   (`Str::plural(class_basename($model))` = `OauthClients`), la classe
   live e' `OauthClientsTable`, rendendo `ClientsTable.php` dead code. Non
   cancellata.
5. Osservazione architetturale (non un difetto): esistono **due Resource
   Socialite separate e legittimamente live** —
   `Modules\User\Filament\Resources\SocialiteUserResource` (standalone) e
   `Modules\User\Filament\Clusters\Socialite\Resources\SocialiteUserResource`
   (`protected static ?string $cluster = Socialite::class;`) — stesso model,
   due registrazioni Filament distinte (una flat, una in un Cluster UI). Non
   e' duplicazione accidentale: sono entrambe raggiungibili e verificate
   separatamente (questa story copre solo la versione cluster).

### Migliorie UX applicate (3, additive, basso rischio)

- `AuthenticationLogsTable.php:26` — `authenticatable_id` era l'unica
  colonna del file senza alcun modifier fluent (`TextColumn::make(...)` nudo,
  mentre la colonna gemella `id` nello stesso file ha
  `->sortable()->copyable()`). Aggiunto `->sortable()->copyable()` per
  coerenza interna.
- `BaseProfilesTable.php:77` — `is_active` aveva solo `->boolean()`, mentre
  ogni altra colonna boolean/icon nell'intero batch di 13 file
  (`revoked`, `active`, `socialite`, `stateless`, `login_successful`,
  `cleared_by_user`, `is_active` in `SsoProvidersTable`/`SocialProvidersTable`)
  ha anche `->sortable()`. Aggiunto `->sortable()`.
- `BaseUsersTable.php:39` — `state` era un `TextColumn::make('state')` nudo
  (zero modifier), unico caso simile a `authenticatable_id`. Aggiunto
  `->sortable()`. Non aggiunto `->badge()`: nessun cast a enum/State
  dichiarato su `BaseUser::$casts` per `state`
  [Source: app/Models/BaseUser.php] (solo presente in `$fillable`), quindi
  non verificabile come valore a bassa cardinalità — niente supposizioni.

Nessuna colonna rimossa. Una chiave per riga rispettata (i 3 edit sono
append di metodi fluent su righe esistenti, nessuna riga con piu' di una
chiave introdotta).

## Testing

<!-- LOCKED. -->

- `php -l` sui 13 file di `owned_scope` — nessun errore di sintassi
  (rieseguito due volte per il rischio di race multi-agente sulla stessa
  working tree, vedi Dev Agent Record).
- `cd laravel && vendor/bin/phpstan analyse <13 file> --no-progress` — `[OK] No errors`.
- Nessun comando di scrittura DB eseguito (solo `Schema::connection(...)
  ->getColumnListing()` e query `SELECT` in sola lettura via tinker).

## Dependency Maps

Nessuna dipendenza diretta da altre story. Correlata (stesso modulo, file
diversi, nessuna sovrapposizione di `owned_scope`) a:
- `xotbaseresourcetable-model-audit-batch-user-oauth.story.md` (issue #90)
- `xotbaseresourcetable-model-audit-user-module-batch.story.md` (issue #91)

## Owned File/Module Scope

I 13 file in `owned_scope`. I findings su `OauthDeviceCode.php` (model),
`ClientResource/Tables/OauthClientsTable.php`,
`SocialiteUserResource/Tables/SocialiteUsersTable.php` (top-level) sono
citati per contesto ma **non modificati** — appartengono ad altri file/batch.

## Learnings from Previous Stories

- Conferma diretta della lezione gia' documentata in issue #90 dello stesso
  modulo: quando un model dichiara `protected $connection`, la verifica
  schema va fatta con `Schema::connection($name)`, mai con la connection di
  default — altrimenti si rischia di leggere una tabella fisicamente diversa
  (stesso nome, DB diverso) e produrre falsi positivi/negativi. In questo
  batch la lezione si e' manifestata su `oauth_clients` (default `mysql` →
  schema Passport "vecchio stile"; `user` → schema con `grant_types`/
  `owner_id` corretto) e su `users` (default `mysql` vuoto/altro schema;
  `user` → schema completo con `is_otp`/`state`/`type`).
- Nuova lezione: la convenzione `XotBaseResource::getTableClass()` risolve
  il nome della classe Table dal namespace del **chiamante concreto**
  (`static::class`), non da quello della classe Resource astratta anche
  quando quest'ultima dichiara il proprio `$model` e la propria cartella
  `Tables/`. Una gerarchia `BaseXResource` → `XResource extends BaseXResource`
  con `Tables/` sotto **entrambe** le cartelle produce sempre una coppia
  dead-code/live, non un errore visibile finche' non si legge
  `getTableClass()` riga per riga.

## Dev Agent Record

### Agent Model Used

Claude Sonnet 5

### Completion Notes List

- 2026-09-11: audit completo dei 13 file assegnati. `$model` gia' presente e
  verificato corretto su tutti (nessuna modifica necessaria). 3 migliorie UX
  additive applicate (`AuthenticationLogsTable.is_active`... veder sopra
  `authenticatable_id`, `BaseProfilesTable.is_active`, `BaseUsersTable.state`).
  4 findings di dead-code/duplicazione segnalati e non toccati. 1 finding di
  drift ambientale (`profiles.is_active`) documentato e non toccato. 1
  finding su model fuori scope (`OauthDeviceCode` connection) documentato.
  Issue #92 aperta, story chiusa.
- 2026-09-11: durante la sessione, `php artisan tinker` ha fallito una volta
  per un marker di conflitto Git non risolto in un file del modulo Activity
  (`Modules/Activity/.../ActivitiesTable.php`, fuori scope, causa boot
  Filament che scandisce tutte le Resource) lasciato da una sessione
  concorrente non identificata; il retry immediato successivo e' riuscito
  (il file e' stato sanato da quell'altra sessione nel frattempo). Non
  toccato, non di mia competenza.
- 2026-09-11: `BaseProfilesTable.php` e' stato osservato cambiare sul disco
  durante la sessione (un blocco di condizioni `null === $x` → `$x === null`
  applicato da un'altra sessione, poi parzialmente revertito da una terza) —
  il mio singolo edit (`is_active` → `->sortable()`) e' rimasto intatto in
  ogni istante verificato; non ho toccato le altre righe del file.
