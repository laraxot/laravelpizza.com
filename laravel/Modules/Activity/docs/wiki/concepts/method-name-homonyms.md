---
title: "censimento omonimi metodi — modulo Activity"
type: analysis
module: Activity
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Activity

> **39** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Activity)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 24 |
| `E_scheda_stack` | 2 |
| `G_module_local` | 2 |
| `H_cross_module_homonym` | 11 |

## Dettaglio

### `A_filament_framework` (24 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Activity` · `ActivityBasePolicy` · `Modules/Activity/app/Models/Policies/ActivityBasePolicy.php`

#### `updated` — 4 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

### `G_module_local`

#### `withUuid` — 2 classi

- `Activity` · `SnapshotFactory` · `Modules/Activity/database/factories/SnapshotFactory.php`
- `Activity` · `StoredEventFactory` · `Modules/Activity/database/factories/StoredEventFactory.php`

#### `withVersion` — 2 classi

- `Activity` · `SnapshotFactory` · `Modules/Activity/database/factories/SnapshotFactory.php`
- `Activity` · `StoredEventFactory` · `Modules/Activity/database/factories/StoredEventFactory.php`

### `H_cross_module_homonym`

#### `user` — 9 classi

- `Activity` · `BaseActivityFactory` · `Modules/Activity/database/factories/BaseActivityFactory.php`

#### `logout` — 4 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

#### `panel` — 4 classi

- `Activity` · `AdminPanelProvider` · `Modules/Activity/app/Providers/Filament/AdminPanelProvider.php`

#### `created` — 3 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

#### `login` — 3 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

#### `registerConfig` — 3 classi

- `Activity` · `ActivityServiceProvider` · `Modules/Activity/app/Providers/ActivityServiceProvider.php`

#### `configureEmailVerification` — 2 classi

- `Activity` · `EventServiceProvider` · `Modules/Activity/app/Providers/EventServiceProvider.php`

#### `custom` — 2 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

#### `deleted` — 2 classi

- `Activity` · `ActivityLogger` · `Modules/Activity/app/Actions/ActivityLogger.php`

#### `displaySummary` — 2 classi

- `Activity` · `ActivityMassSeeder` · `Modules/Activity/database/seeders/ActivityMassSeeder.php`

#### `getBreadcrumb` — 2 classi

- `Activity` · `ListLogActivities` · `Modules/Activity/app/Filament/Pages/ListLogActivities.php`




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
