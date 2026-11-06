---
title: Architecture
module: Activity
type: note
status: draft
updated: 2026-10-08
tags: [docs, activity, bmad]
qmd: "activity   architettura bmad activity"
---

---
title: "Activity: architettura BMAD"
type: concept
tags: [architecture, activity, audit, log, event-sourcing, spatie]
created: 2026-09-28
updated: 2026-09-28
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

# Activity: architettura BMAD

> **SUMMARY**: mappa reale del modulo `Modules/Activity` (alias `activity`): due
> sottosistemi distinti: audit delle azioni utente su Spatie Activity + event
> sourcing, e un visualizzatore dei log di file Laravel: con tre Resource
> Filament, 29 Action e 7 DTO.

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
| `BaseModel` |: | base interna del modulo |
| `TestModel` |: | appoggio ai test (tabella `test_models`, migrazione 2026_03_05) |

Tutti i modelli di dominio usano `Modules\Xot\Models\Traits\HasXotFactory` e una
factory in `database/factories/` (`ActivityFactory`, `SnapshotFactory`,
`StoredEventFactory`). `app/Models/Contracts/ActivityRecorderContract.php`
e il **contratto pubblico** del modulo.

## Contratti e adattatori

- `app/Contracts/ActivityRecorderContract.php`: `record(class-string, int|string, create|update|delete|restore, array $changes)` e `getLog(string, int|string): array`. Il docblock impone: *"Modules should dispatch ActivityRecorded events instead of calling this directly"*.
- `app/Contracts/ActivityRecorderInterface.php`: interfaccia gemella non vincolata al tipaggio stretto.
- `app/Adapters/ActivityRecorder.php` e `app/Adapters/ActivityLogger.php`: implementazioni concrete.

## Action: tre famiglie distinte

**Query (`app/Actions/Query`, 6)**: letture per il pannello: `GetActivitiesByTypeAction`,
`GetActivityStatisticsAction`, `GetModelActivitiesAction`, `GetRecentActivitiesAction`,
`GetSubjectActivityLogAction`, `GetUserActivitiesAction`.

**Log (`app/Actions/Log`, 10)**: il visualizzatore dei log di file:
`ResolveLogDirectoryAction`, `ResolveLogFilePathAction`, `ListLogFilesAction`,
`BuildLogFileTreeAction`, `ReadLogTailAction`, `DownloadLogFileAction`,
`FilterLogEntriesAction`, `ParseLogEntriesAction`, `BuildLogViewerStateAction`,
`AuthorizeLogAccessAction`.

**Schema (`app/Actions/Schema`, 2)**: `CheckActivityLogWritableAction` e
`IsActivityLogSchemaWritableAction`: verificano se la tabella di audit e la
struttura del log sono scrivibili prima di tentare l'operazione.

## DTO (`app/Datas`, 7)

`FilteredLogEntriesData`, `LogEntryData`, `LogFileData`, `LogTailData`,
`LogTreeData`, `LogViewerStateData`, `ResolvedLogFileData`: coprono l'intero
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

## Migrazioni (16 file in `database/migrations`)

Attenzione: la tabella `activity` e creata da **cinque** migrazioni distinte
(`2023_03_31_103350`, `2023_03_31_103351`, `2024_01_01_000001`, `2024_01_01_000002`,
`2026_02_13_171410` e `2026_06_10_141000`), piu `stored_events`, `snapshots`,
`test_models`. Esiste una directory `_bak/`. Questa sovrapposizione e un punto
noto (vedi [brainstorming](./brainstorming.md)).

## Test (`tests/`, 145 file PHP)

E il modulo piu testato del monorepo in rapporto alle sue dimensioni.

## Da leggere

- [module-boundary.md](./architecture/module-boundary.md): confini del modulo.
- [module-map.md](./architecture/module-map.md): mappa file -> responsabilita, una riga per file.
- [brainstorming.md](./brainstorming.md): decisioni prese e problemi aperti.# Architettura del modulo Activity

## Overview

[DA COMPLETARE]

## Componenti principali

### Actions
Azioni eseguibili (Queueable Actions) per la logica di business.

### Resources
Risorse Filament per il pannello di amministrazione.

### Widget
Widget Filament per dashboard e pannelli.

### Models
Modelli Eloquent per l'interazione con il database.

### Contracts
Interfacce per l'iniezione di dipendenze.

## Flussi di dati

[DA COMPLETARE]

## Pattern utilizzati

- Action invece di Service
- Filament Widget invece di Livewire
- Array una chiave per riga
- Schema-driven Forms (XotBaseSchemaWidget)

---

<!-- merged from ARCHITECTURE.md -->

# Architecture Documentation
---
title: "Activity Module Architecture"
type: architecture
tags: [module, architecture, audit]
created: 2026-07-28
updated: 2026-07-28
---

## Activity Module Architecture

### System Overview

The Activity module provides a comprehensive activity logging and event sourcing system for the Laraxot ecosystem. This document describes the module's architecture, components, and design patterns.

### Core Components

Vedi [wiki/concepts/queueable-action-execute-entrypoint.md](../wiki/concepts/queueable-action-execute-entrypoint.md) per la mappa Actions attuale (no Services layer).

```
Activity Module Architecture
┌─────────────────────────────────────────────────────────────┐
│                     Activity Module                          │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Models     │  │ Repositories │  │  Services    │       │
│  │              │  │              │  │              │       │
│  │ ActivityLog  │  │ ActivityRepo │  │ ActivitySvc  │       │
│  │ StoredEvent  │  │ EventRepo    │  │ EventSvc     │       │
│  │ Snapshot     │  │ SnapRepo     │  │ SnapSvc      │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Events     │  │   Commands   │  │  Projections │       │
│  │              │  │              │  │              │       │
│  │ DomainEvent  │  │ CreateAct    │  │ ActivityView │       │
│  │ StoredEvt    │  │ UpdateAct    │  │ EventView    │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Policies   │  │   Actions    │  │   Pages      │       │
│  │              │  │              │  │              │       │
│  │ ActPolicy    │  │ LogAct       │  │ ActListPage  │       │
│  │ EvtPolicy    │  │ RevAct       │  │ EvtListPage  │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
```

### Data Flow

## Quality Gates
✅ PHPStan L10: Executed (2026-07-28)
# Architecture Documentation
---
title: "Activity Module Architecture"
type: architecture
tags: [module, architecture, audit]
created: 2026-07-28
updated: 2026-07-28
---

## Activity Module Architecture

### System Overview

The Activity module provides a comprehensive activity logging and event sourcing system for the Laraxot ecosystem. This document describes the module's architecture, components, and design patterns.

### Core Components

Vedi [wiki/concepts/queueable-action-execute-entrypoint.md](../wiki/concepts/queueable-action-execute-entrypoint.md) per la mappa Actions attuale (no Services layer).

```
Activity Module Architecture
┌─────────────────────────────────────────────────────────────┐
│                     Activity Module                          │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Models     │  │ Repositories │  │  Services    │       │
│  │              │  │              │  │              │       │
│  │ ActivityLog  │  │ ActivityRepo │  │ ActivitySvc  │       │
│  │ StoredEvent  │  │ EventRepo    │  │ EventSvc     │       │
│  │ Snapshot     │  │ SnapRepo     │  │ SnapSvc      │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Events     │  │   Commands   │  │  Projections │       │
│  │              │  │              │  │              │       │
│  │ DomainEvent  │  │ CreateAct    │  │ ActivityView │       │
│  │ StoredEvt    │  │ UpdateAct    │  │ EventView    │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Policies   │  │   Actions    │  │   Pages      │       │
│  │              │  │              │  │              │       │
│  │ ActPolicy    │  │ LogAct       │  │ ActListPage  │       │
│  │ EvtPolicy    │  │ RevAct       │  │ EvtListPage  │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
```

### Data Flow

## Quality Gates
✅ PHPStan L10: Executed (2026-07-28)
# Architecture Documentation

## Activity Module Architecture

### System Overview

The Activity module provides a comprehensive activity logging and event sourcing system for the Laraxot ecosystem. This document describes the module's architecture, components, and design patterns.

### Core Components

Vedi [wiki/concepts/queueable-action-execute-entrypoint.md](../wiki/concepts/queueable-action-execute-entrypoint.md) per la mappa Actions attuale (no Services layer).

```
Activity Module Architecture
┌─────────────────────────────────────────────────────────────┐
│                     Activity Module                          │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Models     │  │ Repositories │  │  Services    │       │
│  │              │  │              │  │              │       │
│  │ ActivityLog  │  │ ActivityRepo │  │ ActivitySvc  │       │
│  │ StoredEvent  │  │ EventRepo    │  │ EventSvc     │       │
│  │ Snapshot     │  │ SnapRepo     │  │ SnapSvc      │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Events     │  │   Commands   │  │  Projections │       │
│  │              │  │              │  │              │       │
│  │ DomainEvent  │  │ CreateAct    │  │ ActivityView │       │
│  │ StoredEvt    │  │ UpdateAct    │  │ EventView    │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
├─────────────────────────────────────────────────────────────┤
│  ┌──────────────┐  ┌──────────────┐  ┌──────────────┐       │
│  │   Policies   │  │   Actions    │  │   Pages      │       │
│  │              │  │              │  │              │       │
│  │ ActPolicy    │  │ LogAct       │  │ ActListPage  │       │
│  │ EvtPolicy    │  │ RevAct       │  │ EvtListPage  │       │
│  └──────────────┘  └──────────────┘  └──────────────┘       │
└─────────────────────────────────────────────────────────────┘
```

### Data Flow

1. **Event Creation**: User actions trigger domain events
2. **Event Storage**: Events persisted to `stored_events` table
3. **Snapshot Creation**: Aggregates create snapshots for performance
4. **Projection Update**: Read models updated via event handlers
5. **Query Handling**: Projections queried for activity listings

### Database Schema

```sql
-- Activity Logs
CREATE TABLE activity_log (
    id BIGINT PRIMARY KEY,
    log_name VARCHAR(255),
    description TEXT,
    subject_type VARCHAR(255),
    subject_id BIGINT,
    causer_type VARCHAR(255),
    causer_id BIGINT,
    properties JSON,
    created_at TIMESTAMP,
    updated_at TIMESTAMP
);

-- Event Sourcing Tables
CREATE TABLE stored_events (
    id BIGINT PRIMARY KEY,
    event_name VARCHAR(255),
    aggregate_id VARCHAR(255),
    aggregate_type VARCHAR(255),
    event_data JSON,
    created_at TIMESTAMP
);

CREATE TABLE snapshots (
    id BIGINT PRIMARY KEY,
    aggregate_id VARCHAR(255),
    aggregate_type VARCHAR(255),
    version INTEGER,
    data JSON,
    created_at TIMESTAMP
);
```

### Design Patterns

#### 1. Repository Pattern
```php
interface ActivityRepositoryInterface
{
    public function find(int $id): ?Activity;
    public function findBySubject(string $type, int $id): Collection;
    public function paginate(int $perPage): LengthAwarePaginator;
}
```

#### 2. CQRS Pattern
- **Command Side**: Handles mutations, validates business rules
- **Query Side**: Optimized read models via projections

#### 3. Event Sourcing
```php
class ActivityCreated extends ShouldBroadcast
{
    public function __construct(
        public readonly string $activityType,
        public readonly array $data
    ) {}
}
```

#### 4. Policy-Based Authorization
```php
class ActivityPolicy
{
    public function viewAny(User $user): bool
    {
        return $user->hasPermissionTo('activities.view');
    }
}
```

### Integration Points

| Component | Integration | Purpose |
|-----------|-------------|---------|
| Xot | BaseRepository | Generic repository patterns |
| User | UserModel | User activity tracking |
| Filament | ActivityResource | Admin UI integration |
| spatie/laravel-activitylog | Third-party | Alternative logging |
| spatie/laravel-event-sourcing | Core dependency | Event sourcing engine |

### Performance Considerations

1. **Database Indexing**: Composite indexes on `subject_type`, `causer_type`
2. **Caching**: Redis cache for activity counts (TTL: 5 minutes)
3. **Pagination**: Cursor-based pagination for large datasets
4. **Archiving**: Old events archived to separate table

### Scaling Strategy

- **Horizontal**: Read replicas for query-heavy operations
- **Vertical**: Index optimization for write-heavy periods
- **Event Sourcing**: Enables temporal querying and replay

### Extension Points

1. **Event Handlers**: Add custom handlers via service container
2. **Projectors**: Create new projections for specialized views
3. **Middleware**: Add activity logging middleware to routes
4. **Custom Events**: Extend base event classes

### Related Documentation

- [Security](SECURITY.md)
- [Quality](../roadmap/quality.md)
- [Performance](PERFORMANCE.md)
- [Testing](TESTING.md)
- [Testing](TESTING.md)
- [Testing](TESTING.md)
- [Testing](TESTING.md)
- [Testing](TESTING.md)
- [Testing](TESTING.md)
