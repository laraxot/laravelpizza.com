---
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
title: "Activity — architettura BMAD"
type: concept
module: Activity
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_RrO1bI
title: Architecture
module: Activity
---

---
=======
>>>>>>> .merge_file_JUSBS4
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
title: "Activity — architettura BMAD"
type: concept
>>>>>>> laraxot/dev
tags: [architecture, activity, audit, log, event-sourcing, spatie]
created: 2026-09-28
updated: 2026-11-16
qmd: "Activity architettura moduli Spatie activity event sourcing log viewer contratti modelli"
related:
  - ./architecture/module-boundary.md
  - ./architecture/module-map.md
  - ./brainstorming.md
  - ./epics/module-roadmap.md
  - ./README.md
issues: []
discussions: []
---

# Activity — architettura BMAD

> **SUMMARY**: mappa reale del modulo `Modules/Activity` (alias `activity`): due
> sottosistemi distinti — audit delle azioni utente su Spatie Activity + event
> sourcing, e un visualizzatore dei log di file Laravel — con tre Resource
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
> Filament, 30 Action e 8 DTO (misura 2026-11-19; 7 DTO del log viewer + `ActivityConfigData`).
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
> Filament, 30 Action e 8 DTO (misura 2026-11-19; 7 DTO del log viewer + `ActivityConfigData`).
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
> Filament, 30 Action e 8 DTO (misura 2026-11-19; 7 DTO del log viewer + `ActivityConfigData`).
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_RrO1bI
> Filament, 29 Action e 7 DTO.
> Filament, 30 Action e 7 DTO (misura 2026-11-16).
=======
> Filament, 30 Action e 8 DTO (misura 2026-11-19; 7 DTO del log viewer + `ActivityConfigData`).
>>>>>>> .merge_file_JUSBS4
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV

## Identita del modulo

Da `module.json`: alias `activity`, `requires: ["Xot", "User"]`, `order: 5`,
priority 0, `minimumCoreVersion 10.0`, `phpVersion ^8.1`. Da `config/config.php`:
rotte abilitate con middleware `web, auth`, navigation `sort: 20`.

## Modelli (`app/Models`)

| Classe | Base | Ruolo |
|---|---|---|
| `Activity` | `Spatie\Activitylog\Models\Activity` (`SpatieActivity`) | una riga di audit per azione su modello; `properties` castata a `SchemalessAttributes` |
| `StoredEvent` | `Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent` | evento persistito per replay; `meta_data` schemaless |
| `Snapshot` | `Spatie\EventSourcing\Snapshots\EloquentSnapshot` | snapshot Eloquent per proiezioni |
| `BaseModel` | — | base interna del modulo |
| `TestModel` | — | appoggio ai test (tabella `test_models`, migrazione 2026_03_05) |

Tutti i modelli di dominio usano `Modules\Xot\Models\Traits\HasXotFactory` e una
factory in `database/factories/` (`ActivityFactory`, `SnapshotFactory`,
`StoredEventFactory`). `app/Models/Contracts/ActivityRecorderContract.php`
e il **contratto pubblico** del modulo.

## Contratti e adattatori

- `app/Contracts/ActivityRecorderContract.php` — `record(class-string, int|string, create|update|delete|restore, array $changes)` e `getLog(string, int|string): array`. Il docblock impone: *"Modules should dispatch ActivityRecorded events instead of calling this directly"*.
- `app/Contracts/ActivityRecorderInterface.php` — interfaccia gemella non vincolata al tipaggio stretto.
- `app/Adapters/ActivityRecorder.php` e `app/Adapters/ActivityLogger.php` — implementazioni concrete.

<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
## Action — tre famiglie distinte
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
## Action — famiglie
=======
## Action — tre famiglie distinte
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV

**Query (`app/Actions/Query`, 6)** — letture per il pannello: `GetActivitiesByTypeAction`,
`GetActivityStatisticsAction`, `GetModelActivitiesAction`, `GetRecentActivitiesAction`,
`GetSubjectActivityLogAction`, `GetUserActivitiesAction`.

**Log (`app/Actions/Log`, 10)** — il visualizzatore dei log di file:
`ResolveLogDirectoryAction`, `ResolveLogFilePathAction`, `ListLogFilesAction`,
`BuildLogFileTreeAction`, `ReadLogTailAction`, `DownloadLogFileAction`,
`FilterLogEntriesAction`, `ParseLogEntriesAction`, `BuildLogViewerStateAction`,
`AuthorizeLogAccessAction`.

**Schema (`app/Actions/Schema`, 2)** — `CheckActivityLogWritableAction` e
`IsActivityLogSchemaWritableAction`: verificano se la tabella di audit e la
struttura del log sono scrivibili prima di tentare l'operazione.

<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
**Radice (`app/Actions`, 11) e Config (`app/Actions/Config`, 1)** — scrittura e manutenzione del log:
`LogActivityAction`, `LogModelCreatedAction`, `LogModelUpdatedAction`, `LogModelDeletedAction`,
`LogUserLoginAction`, `LogUserLogoutAction`, `RecordSubjectActivityAction`, `RedactModelAttributesAction`,
`RestoreActivityAction`, `ActivityMaintenanceAction`, `ActivityLogger` (non ha il suffisso `Action`) e
`Config/ApplyActivityConfigAction`.

=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
## DTO (`app/Datas`, 8)

`ActivityConfigData` (configurazione del modulo) e `FilteredLogEntriesData`, `LogEntryData`, `LogFileData`, `LogTailData`,
`LogTreeData`, `LogViewerStateData`, `ResolvedLogFileData` — questi ultimi sette coprono l'intero
flusso del log viewer: risoluzione percorso -> lista -> albero -> tail ->
parsing -> filtro -> stato UI.

## Filament (`app/Filament`)

Tre Resource, ciascuna con schema e table separati in sottodirectory proprie:
`ActivityResource`, `SnapshotResource`, `StoredEventResource`. Presenti
`app/Filament/Pages` (con `Pages/Concerns`), `Forms`, `Forms/Components` e `Actions`.

## Provider (`app/Providers`)

`ActivityServiceProvider` (registrato in `module.json` e `config/config.php`),
`EventServiceProvider`, `RouteServiceProvider`, e
`Filament/AdminPanelProvider` (registrato solo in `module.json`).

## Migrazioni (9 attive + 7 in `_bak/` = 16 file in `database/migrations`)

Attenzione: la tabella `activity` e creata da **cinque** migrazioni distinte
(`2023_03_31_103350`, `2023_03_31_103351`, `2024_01_01_000001`, `2024_01_01_000002`
e `2026_06_10_141000`, piu `2026_02_13_171410_fix_causer_id_to_uuid`), piu `stored_events`, `snapshots`,
`test_models`. Esiste una directory `_bak/`. Questa sovrapposizione e un punto
noto (vedi [brainstorming](./brainstorming.md)).

## Test (`tests/`, 152 file PHP, 100 `*Test.php`, 486 casi Pest)

Alto numero ma qualita da verificare: 8 file senza casi, 19 punti di skip, 0 `Livewire::test` ([audit](./audits/activity-audit.md#p1-4--test-svuotati-e-saltati)).

## Da leggere

- [module-boundary.md](./architecture/module-boundary.md) — confini del modulo.
- [module-map.md](./architecture/module-map.md) — mappa file -> responsabilita, una riga per file.
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_RrO1bI
- [brainstorming.md](./brainstorming.md) — decisioni prese e problemi aperti.# Architettura del modulo Activity

## Overview

[DA COMPLETARE]

## Componenti principali

### Actions
Azioni eseguibili (Queueable Actions) per la logica di business.

### Resources
Risorse Filament per il pannello di amministrazione.
=======
>>>>>>> .merge_file_JUSBS4
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
- [brainstorming.md](./brainstorming.md) — decisioni prese e problemi aperti.

## Flussi di dati (verificati sul codice, 2026-11-16)

1. **Audit (percorso reale):** le Action degli altri moduli chiamano il helper `activity()` di Spatie
   (es. `Ptv/app/Actions/Scheda/LogEmailSentAction.php:45`, `User/app/Actions/Activity/LogRegistrationAction.php:21`);
   solo 2 file fuori da Activity usano il trait `LogsActivity`. Risultato: riga in `activity_log`
   (connessione `activity`) con `properties`/`attribute_changes`.
   Nessun modulo chiama `Adapters\ActivityLogger` o `LogModel*Action` (`rg` fuori da `tests`/`docs`).
2. **Login/logout:** `EventServiceProvider` collega `Login` → `LoginListener` (**vuoto**, `handle()` senza corpo)
   e `Logout` → `LogoutListener` (registra guard, IP, user agent). Il login e' tracciato dal modulo User.
3. **Event sourcing:** `StoredEvent` e `Snapshot` (Spatie Event Sourcing) con Resource di sola gestione.
4. **Log viewer:** `LogViewer::canAccess` → `AuthorizeLogAccessAction` (`super-admin` o `log.viewAny`) →
   catena `Resolve*` → `ListLogFiles` → `BuildLogFileTree` → `ReadLogTail` → `Parse`/`Filter` → stato UI.
5. **Restore da attivita':** `ListLogActivities::restoreActivity` → gate `canRestore` della Resource →
   `RestoreActivityAction` (`update($oldProperties)` sul record corrente).

## Autorizzazione

Policy per permesso (`activity.*`, `snapshot.*`, `stored_event.*`) su `UserBasePolicy`. `ActivityBasePolicy`
(bypass `super-admin`/`activity::admin`) e' presente ma senza sottoclassi: vedi
[audit P2](./audits/activity-audit.md#p2--debito).

## Pattern utilizzati

<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
<<<<<<< .merge_file_fj0qqm
=======
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
<<<<<<< .merge_file_RrO1bI
- Action invece di Service
- Filament Widget invece di Livewire
- Array una chiave per riga
- Schema-driven Forms (XotBaseSchemaWidget)
=======
>>>>>>> .merge_file_JUSBS4
<<<<<<< HEAD
=======
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
>>>>>>> laraxot/dev
<<<<<<< .merge_file_T5Yzwl
<<<<<<< .merge_file_DKSjwR
<<<<<<< .merge_file_n8aavK
>>>>>>> .merge_file_uaKkDc
=======
>>>>>>> .merge_file_b7zAcg
=======
>>>>>>> .merge_file_0SqaTD
=======
>>>>>>> .merge_file_4OyGhV
- Action Queueable invece di Service (0 Services).
- Resource con `Schemas/` e `Tables/` separati, base `XotBase*`.
- Array una chiave per riga.
