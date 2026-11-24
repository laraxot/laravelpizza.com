---
title: "Activity — mappa file -> responsabilita"
type: concept
tags: [architecture, activity, mappa, file-responsabilita]
created: 2026-09-28
updated: 2026-09-28
qmd: "Activity mappa file responsabilita modelli action dto resource"
related:
  - ../architecture.md
  - ./module-boundary.md
  - ../brainstorming.md
issues: []
discussions: []
---

# Activity — mappa file -> responsabilita

> **SUMMARY**: una riga per file (o gruppo omogeneo) con la responsabilita
> unica. Se un file non sta qui, e probabile che sia da spostare o da dichiarare
> esplicitamente.

## Entry point

| File | Responsabilita |
|---|---|
| `module.json` | Manifesto del modulo: alias, provider, dipendenze (`Xot`, `User`) |
| `config/config.php` | Icona, posizione di navigazione (sort 20), rotte e middleware |

## Modelli

| File | Responsabilita |
|---|---|
| `app/Models/Activity.php` | Riga di audit, estende Spatie Activity, `properties` schemaless |
| `app/Models/StoredEvent.php` | Evento di event sourcing persistito, `meta_data` schemaless |
| `app/Models/Snapshot.php` | Snapshot Eloquent per proiezioni |
| `app/Models/BaseModel.php` | Base interna del modulo |
| `app/Models/TestModel.php` | Modello di appoggio ai test |
| `app/Models/Contracts/ActivityRecorderContract.php` | **Contratto pubblico**: `record()` + `getLog()` |
| `app/Models/Policies/` | Policy per l'accesso alle righe di audit |

## Contratti e adattatori

| File | Responsabilita |
|---|---|
| `app/Contracts/ActivityRecorderContract.php` | Contratto tipizzato per la registrazione |
| `app/Contracts/ActivityRecorderInterface.php` | Interfaccia non vincolata |
| `app/Adapters/ActivityRecorder.php` | Implementazione concreta del recorder |
| `app/Adapters/ActivityLogger.php` | Implementazione concreta del logger |

## Action — query

| File | Responsabilita |
|---|---|
| `app/Actions/Query/GetActivitiesByTypeAction.php` | Filtra le attivita per tipo |
| `app/Actions/Query/GetActivityStatisticsAction.php` | Statistiche aggregate |
| `app/Actions/Query/GetModelActivitiesAction.php` | Attivita di un modello |
| `app/Actions/Query/GetRecentActivitiesAction.php` | Attivita recenti |
| `app/Actions/Query/GetSubjectActivityLogAction.php` | Log per soggetto |
| `app/Actions/Query/GetUserActivitiesAction.php` | Attivita di un utente |

## Action — log viewer

| File | Responsabilita |
|---|---|
| `app/Actions/Log/ResolveLogDirectoryAction.php` | Individua la directory dei log |
| `app/Actions/Log/ResolveLogFilePathAction.php` | Risolve il percorso di un file di log |
| `app/Actions/Log/ListLogFilesAction.php` | Elenco dei file di log |
| `app/Actions/Log/BuildLogFileTreeAction.php` | Albero dei file per data |
| `app/Actions/Log/ReadLogTailAction.php` | Ultime righe di un file |
| `app/Actions/Log/DownloadLogFileAction.php` | Download di un file di log |
| `app/Actions/Log/FilterLogEntriesAction.php` | Filtro sulle entry di log |
| `app/Actions/Log/ParseLogEntriesAction.php` | Parsing delle righe di log |
| `app/Actions/Log/BuildLogViewerStateAction.php` | Stato completo della vista |
| `app/Actions/Log/AuthorizeLogAccessAction.php` | Controllo di accesso al log |

## Action — schema

| File | Responsabilita |
|---|---|
| `app/Actions/Schema/CheckActivityLogWritableAction.php` | Verifica scrivibilita del log di attivita |
| `app/Actions/Schema/IsActivityLogSchemaWritableAction.php` | Verifica scrivibilita dello schema |

## DTO

| File | Responsabilita |
|---|---|
| `app/Datas/ResolvedLogFileData.php` | Percorso risolto di un file di log |
| `app/Datas/LogFileData.php` | Metadati di un file di log |
| `app/Datas/LogTreeData.php` | Albero dei file di log |
| `app/Datas/LogTailData.php` | Coda di un file di log |
| `app/Datas/LogEntryData.php` | Una singola entry di log |
| `app/Datas/FilteredLogEntriesData.php` | Entry filtrate |
| `app/Datas/LogViewerStateData.php` | Stato aggregato del visualizzatore |

## Filament

| File | Responsabilita |
|---|---|
| `app/Filament/Resources/ActivityResource/` | CRUD delle righe di audit (`Schemas/`, `Tables/`, `Pages/`) |
| `app/Filament/Resources/SnapshotResource/` | Visione degli snapshot (`Schemas/`, `Tables/`, `Pages/`) |
| `app/Filament/Resources/StoredEventResource/` | Visione degli eventi (`Schemas/`, `Tables/`, `Pages/`) |
| `app/Filament/Pages/` | Pagine custom (log viewer) |
| `app/Filament/Pages/Concerns/` | Trait riutilizzati dalle pagine |
| `app/Filament/Forms/`, `Forms/Components/` | Componenti di form riusabili |
| `app/Filament/Actions/` | Action Filament riusabili |

## Provider ed eventi

| File | Responsabilita |
|---|---|
| `app/Providers/ActivityServiceProvider.php` | Bootstrap del modulo (registrato due volte: `module.json` + `config.php`) |
| `app/Providers/Filament/AdminPanelProvider.php` | Pannello admin (registrato solo in `module.json`) |
| `app/Providers/EventServiceProvider.php` | Sottoscrizioni degli eventi |
| `app/Providers/RouteServiceProvider.php` | Rotte del modulo |
| `app/Events/ActivityEvent.php` | Evento di attivita |
| `app/Exceptions/InvalidLogFileException.php` | Path di log non valido |
| `app/Listeners/` | Listener degli eventi |

## Persistenza e test

| Percorso | Responsabilita |
|---|---|
| `database/migrations/2023_03_31_103350_create_activity_table.php` | Prima creazione tabella `activity` |
| `database/migrations/2023_03_31_103351_create_activity_table.php` | Seconda creazione (sovrapposta) |
| `database/migrations/2024_01_01_000001_create_activity_table.php` | Terza creazione (sovrapposta) |
| `database/migrations/2024_01_01_000002_create_activity_table.php` | Quarta creazione (sovrapposta) |
| `database/migrations/2026_02_13_171410_fix_causer_id_to_uuid.php` | `causer_id` convertito a UUID |
| `database/migrations/2026_06_10_141000_create_activity_table.php` | Quinta creazione (sovrapposta) |
| `database/migrations/2023_10_30_103350_create_stored_events_table.php` | Tabella `stored_events` |
| `database/migrations/2023_10_31_103350_create_snapshots_table.php` | Tabella `snapshots` |
| `database/migrations/2026_03_05_000001_create_test_models_table.php` | Tabella `test_models` |
| `tests/` (145 file PHP) | Copertura del modulo |
