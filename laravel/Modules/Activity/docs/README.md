---
title: "Activity: documentazione del modulo (docs)"
type: readme
status: active
module: Activity
created: 2026-10-14
updated: 2026-10-14
tags: [activity, activitylog, event-sourcing, docs]
qmd: "activity modulo docs readme identita ownership actions log viewer event sourcing quick start limiti"
related:
  - ./00-index.md
  - ./stories/docs-ingressi-activity.story.md
---

# Activity: docs del modulo

Fatti verificati sul codice il 2026-10-14. Dove una cosa non e' stata provata e' scritto "non verificato".

## Identita' e ownership

- Modulo `laravel/Modules/Activity`, repository git separato, pacchetto `laraxot/module_activity_fila5`, alias `activity`. Richiede i moduli `Xot` e `User` (`module.json`).
- Provider: `Modules\Activity\Providers\ActivityServiceProvider` e `Providers\Filament\AdminPanelProvider`.
- Pacchetti: `spatie/laravel-activitylog` (5.1.1 in `laravel/composer.lock`) e `spatie/laravel-event-sourcing` (7.15.1).
- Proprietario di questa cartella: il modulo Activity. Le story BMAD stanno in [stories/](./stories/). Indice operativo: [00-INDEX.md](./00-index.md).

## Cosa contiene davvero

| Area | Dove | Fatto |
|---|---|---|
| Registrare un'attivita' | `app/Actions/LogActivityAction.php` | costruttore `(type, user, subject, properties, description)`, poi `execute(): Activity`; scrive su `Models\Activity` |
| Altre Action | `app/Actions` (29 file) | `LogModelCreated/Updated/DeletedAction`, `LogUserLogin/LogoutAction`, `RecordSubjectActivityAction`, `RestoreActivityAction`, `RedactModelAttributesAction`, `ActivityMaintenanceAction` (`execute(int $days = 90)`), 6 Action di lettura in `Query/`, 2 in `Schema/` |
| Modelli | `app/Models` | `Activity` (estende il modello Spatie, connessione `activity`, tabella `activity_log`), `StoredEvent` (`stored_events`), `Snapshot`, `TestModel` |
| Event sourcing | `app/Traits/HasEvents.php`, `HasSnapshots.php` | `HasEvents` espone le relazioni `storedEvents()` e `snapshots()`; nessun altro modulo li usa (cerca in `Modules/*/app`: 0 risultati) |
| Pannello Filament | `app/Filament` | `ActivityResource`, `SnapshotResource`, `StoredEventResource`; pagine `Dashboard`, `LogViewer`, `ListLogActivities` (astratta) con la Action `ListLogActivitiesAction`. Non esiste nessuna cartella `Widgets` |
| Visualizzatore log | `app/Filament/Pages/LogViewer.php`, `app/Actions/Log` (10 file) | legge `storage/logs` dal pannello; accesso solo a `super-admin` o al permesso `log.viewAny` (`AuthorizeLogAccessAction`); il download e' la pagina Folio `resources/views/pages/api/log-download.blade.php` su `/api/log-download` (403 senza permesso). Dettagli: [wiki/concepts/log-viewer-page-no-ssh.md](./wiki/concepts/log-viewer-page-no-ssh.md) |
| Listener | `app/Listeners`, `Providers/EventServiceProvider.php` | mappati `Login` e `Logout`; `LogoutListener` scrive un `Activity` (`log_name` auth, `event` logout); `LoginListener::handle()` e' vuoto |
| Rotte | `routes/web.php`, `routes/api.php` | nessuna rotta attiva: contengono solo commenti |
| Config | `config/config.php` | chiavi `name`, `description`, `icon`, `navigation`, `routes`, `providers`, unite come `activity`; la config Spatie e' in `laravel/config/activitylog.php` (`activity_model` = `Modules\Activity\Models\Activity`, tabella `activity_log`) e `laravel/config/event-sourcing.php` |
| Database | `database/migrations` | `activity_log` e' definita da `2026_06_10_141000_create_activity_table.php` (intestazione: "UNICA migrazione", contratto in [wiki/concepts/activity-log-single-migration-contract.md](./wiki/concepts/activity-log-single-migration-contract.md)); `stored_events`, `snapshots`, `test_models` hanno una migrazione ciascuna |
| Test | `tests/Feature`, `tests/Unit`, `tests/Security` | 100 file `*Test.php` in stile Pest e 34 fixture; `TestCase` estende `XotBaseTestCase`, usa transazioni e risolve lo SQLite condiviso (fallback `database/test_data.sqlite`) senza `RefreshDatabase`. Il file non è versionato e deve essere predisposto in modo disposable prima dei test. |
| Traduzioni | `lang/` | 18 cartelle di lingua piu' `en.json` e `it.json`; `lang/it` ha 24 file |

## Quick start

Registrare un'attivita' dal codice (uso reale in `Modules/Fixcity/app/Actions/ChangeTicketPriorityAction.php`):

```php
use Modules\Activity\Actions\LogActivityAction;

(new LogActivityAction(
    'priority_changed',
    subject: $ticket,
    properties: ['from' => $previous, 'to' => $priority],
))->execute();
```

Controllare la qualita' del modulo (eseguito il 2026-10-14 con `laravel/phpstan.neon`: uscita 0, nessun errore):

```bash
cd laravel
./vendor/bin/phpstan analyse Modules/Activity --memory-limit=3G
```

I test Pest non sono stati rieseguiti in questa sessione: non verificato che passino.

## Limiti noti

- Con `user` nullo `LogActivityAction` imposta `causer_id` a `Auth::id()` ma lascia `causer_type` nullo (codice di `execute()`): l'attivita' risulta senza causer risolvibile come relazione.
- `LoginListener` non registra nulla: gli accessi non finiscono nel log, solo le uscite.
- In `database/migrations` restano altre quattro migrazioni `create_activity_table` (`2023_03_31_103350`, `2023_03_31_103351`, `2024_01_01_000001`, `2024_01_01_000002`) oltre a quella del 2026-06-10. Se siano innocue non e' verificato.
- La connessione `activity` e' dichiarata nei modelli (`$connection = 'activity'`) ma non e' definita in `laravel/config/database.php`: dove venga creata non e' verificato.
- Documenti che non descrivono il codice: [ARCHITECTURE.md](./ARCHITECTURE.md) (Repositories, Services, Projections inesistenti), [API.md](./api.md) (firma `execute(array $data)` inesistente), [readme.md](./readme.md) (`ActivityStatsWidget`, `EventStore`, monitoraggio in tempo reale inesistenti). Sono marcati `stale`.
