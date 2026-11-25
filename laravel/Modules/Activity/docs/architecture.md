---
title: "Activity: architettura del modulo"
type: architecture
status: active
module: Activity
created: 2026-11-25
updated: 2026-11-25
qmd: "activity architettura modelli actions adapters contracts provider pannello filament connessione activity UserContract policy"
related:
  - ./README.md
  - ./actions.md
  - ./database.md
---

# Activity: architettura

Fatti verificati sul codice il 2026-11-25. Dove una cosa non e' provata e' scritto "non verificato".

## Livelli

| Livello | Dove | Cosa |
|---|---|---|
| Modelli | `app/Models` | `Activity` (estende `Spatie\Activitylog\Models\Activity`, connessione `activity`, tabella `activity_log`), `StoredEvent` (estende `EloquentStoredEvent`, `stored_events`), `Snapshot` (estende `EloquentSnapshot`, `snapshots`), `BaseModel` (astratto, su `XotBaseModel`), `TestModel` |
| Logica | `app/Actions` (30 file) | Spatie Queueable Action; catalogo e contratti sintetici in [actions.md](./actions.md). Nessun `Service` |
| DTO | `app/Datas` | Spatie Data: `ActivityConfigData`, `Log*Data` del log viewer |
| Adapter e contratti | `app/Adapters`, `app/Contracts`, `app/Models/Contracts` | facciata di compatibilita' sopra le Action, vedi sotto |
| Ingressi | `app/Listeners`, `Providers/EventServiceProvider.php` | solo `Login` e `Logout` di Laravel Auth |
| Pannello | `app/Filament`, `Providers/Filament/AdminPanelProvider.php` | vedi [filament-admin.md](./filament-admin.md) |
| Policy | `app/Models/Policies` | `ActivityPolicy`, `SnapshotPolicy`, `StoredEventPolicy` (per permesso) e `ActivityBasePolicy` (astratta) |
| Trait | `app/Traits` | `ActivityScopes`, `HasEvents`, `HasSnapshots` |
| Eccezioni, enum | `app/Exceptions`, `app/Enums` | `InvalidLogFileException`, `LogLevelEnum` (EMERGENCY ... DEBUG) |

Il modulo non ha `Http/Controllers` utili (solo `.gitkeep`), nessuna rotta attiva (`routes/web.php` e `routes/api.php` contengono solo commenti), nessun widget e nessuna cartella Livewire.

## Provider e dipendenze

- `Providers\ActivityServiceProvider` estende `XotBaseServiceProvider` (`$name = 'Activity'`). Nel `boot()` registra la config (`mergeConfigFrom` su `activity`) e i componenti Blade, poi chiama `ApplyActivityConfigAction`. **Non** monta Folio: il mount delle pagine e' del modulo che possiede Folio, vedi [la story](./bmad/stories/folio-routing-centralization.story.md).
- `Providers\Filament\AdminPanelProvider` estende `XotBasePanelProvider` con `$module = 'Activity'`.
- `module.json` richiede `Xot` e `User`. Pacchetti: `spatie/laravel-activitylog` 5.1.5, `spatie/laravel-event-sourcing` 7.15.3 (`laravel/composer.lock`), `spatie/laravel-queueable-action`, `spatie/laravel-schemaless-attributes`.
- Le firme pubbliche accettano `Modules\Xot\Contracts\UserContract` e non la classe concreta `User`: servono a far funzionare gli utenti di un modulo User diverso, classe sorella e non sottoclasse.

## Connessione `activity`

I tre modelli dichiarano `$connection = 'activity'`. La connessione non e' scritta in `config/database.php`: la aggiunge `TenantServiceProvider::registerDB()` come copia della connessione di default (stesso database; vedi `laravel/CLAUDE.md`, "Database config Laravel 12"). `StoredEvent` e `Snapshot` in ambiente `testing` ripiegano sulla connessione di default (vedi [testing.md](./testing.md)).

## Adapter e contratti duplicati

Esistono due livelli di facciata sopra le stesse Action, entrambi documentati qui perche' creano confusione:

- `Actions\ActivityLogger` (scrive e interroga direttamente, ~290 righe) e `Adapters\ActivityLogger` (delega alle Action `Query/*` e `ActivityMaintenanceAction`). Stesso nome, due namespace, API quasi uguale (`log`, `created`, `updated`, `deleted`, `login`, `logout`, `custom`, `getUserActivities`, `getModelActivities`, `getByType`, `getRecent`, `cleanOld`, `getStatistics`).
- Tre interfacce `ActivityRecorder*`: `Contracts\ActivityRecorderContract` e `Models\Contracts\ActivityRecorderContract` (stessa firma `record(string, int|string, string, array)` + `getLog`) e `Contracts\ActivityRecorderInterface` (con `int $modelId`). L'unica implementazione e' `Adapters\ActivityRecorder` (implementa `Contracts\ActivityRecorderContract` e delega a `RecordSubjectActivityAction` / `GetSubjectActivityLogAction`).
- Fuori dal modulo non c'e' nessun chiamante di `Adapters\*`, `LogModel*Action` e `LogUser*Action` (cercato in `Modules/*/app`): i moduli vicini usano `activity()` di Spatie. Chi usa davvero le classi del modulo: `Gdpr\DeleteAccountAction` (modello `Activity`), `Meetup\Models\Event` (trait `HasEvents`, `HasSnapshots`, modelli `StoredEvent`, `Snapshot`), `User\Filament\Widgets\Auth\RegisterWidget` (`IsActivityLogSchemaWritableAction`).

Consolidare i duplicati e' debito aperto, vedi [roadmap.md](./roadmap.md).

## Policy e autorizzazione

- `ActivityPolicy`, `SnapshotPolicy`, `StoredEventPolicy` estendono `User\Models\Policies\UserBasePolicy` e rispondono per permesso Spatie: `activity.*`, `snapshot.*`, `stored_event.*` (`view`, `create`, `update`, `delete`, `restore`, `forceDelete`; `viewAny` solo in `ActivityPolicy`, e' commentato nelle altre due).
- `ActivityBasePolicy::before()` darebbe bypass a `super-admin` e `activity::admin`, ma nessuna policy concreta la estende e `UserBasePolicy` non ha `before()`: il bypass `activity::admin` non e' applicato (non verificato a runtime).
- Il log viewer ha una regola separata: [log-viewer.md](./log-viewer.md).
- Matrice per attori: [manuale-uso-attori.md](./manuale-uso-attori.md).

## Configurazione

- `config/config.php` (chiave `activity`): `name`, `description`, `icon`, `navigation` (`enabled`, `sort` 20), `routes`, `providers`.
- Config Spatie nel progetto host: `laravel/config/activitylog.php` (`activity_model` = `Modules\Activity\Models\Activity`, `table_name` = `activity_log`) e `laravel/config/event-sourcing.php`; ogni tenant puo' avere i propri override in `config/local/<tenant>/{activitylog,event-sourcing}.php`.
- Le impostazioni salvate dal tenant (pagina `SettingPage`) arrivano a `activitylog.*` tramite `ApplyActivityConfigAction`, vedi [activity-logging.md](./activity-logging.md).
