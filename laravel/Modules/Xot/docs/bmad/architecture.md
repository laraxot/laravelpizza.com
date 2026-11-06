---
title: "Xot - architecture.md"
module: Xot
bmad: true
status: active
---
---
title: "Xot: architettura BMAD"
type: architecture
tags: [architecture, xot, base, filmato, filtro]
created: 2026-09-26
updated: 2026-09-28
qmd: "Xot architettura confini componenti PHP Laravel Filamento Tabella risorse Action provider"
related:
  - architecture/module-boundary.md
  - architecture/composite-filter-column-span.md
  - architecture/sync-modules-cli.md
  - app/Providers/XotBaseServiceProvider.php
  - app/Filament/Resources/XotBaseResource.php
  - app/Models/XotBaseModel.php
  - ../../app/Providers/XotBaseServiceProvider.php
  - ../../app/Filament/Resources/XotBaseResource.php
  - ../../app/Models/XotBaseModel.php
  - ../../app/Providers/XotBaseServiceProvider.php
  - ../../app/Filament/Resources/XotBaseResource.php
  - ../../app/Models/XotBaseModel.php
status: draft
---

# Xot: architettura

> **SUMMARY**: Indice e mappa reale dell'architettura del modulo Xot (679 file PHP in `app/`, 286 test). Gli shard specialistici sono in `architecture/`; qui si trova la visione d'insieme e i riferimenti verificati.

## Scopo del modulo

Modulo base con funzionalità core e strutture fondamentali. Tutti i 46 moduli della piattaforma Laraxot derivano da Xot: modelli, risorse Filament, Action, trait e provider. Le modifiche a Xot si propagano a tutti i consumatori. Verificabile in `module.json` (`laravel/Modules/Xot/module.json`) e in `app/Providers/XotBaseServiceProvider.php`.

## Inventario verificato

- PHP in `app/`: 679 file (verificato via `find app -name "*.php" | wc -l`).
- Test PHP in `tests/`: 286 file.
- Aree applicative principali: `Actions`, `Filament`, `Models`, `Providers`, `Services`, `Traits`, `Http`, `Database`, `Exports`, `Console`, `Exceptions`, `Events`, `Jobs`, `Rules`, `Config`.
- Persistenza: `database/migrations`, `database/factories`, `database/seeders` presenti.
- Config: `config/config.php`, `config/xot.php`, `config/mcp.php`.

## Classi base: gerarchia verificata

| Simbolo | File | Responsabilità |
|---|---|---|
| `XotBaseModel` | `app/Models/XotBaseModel.php` | Base Eloquent, `XotBaseUuidModel` deriva |
| `XotBaseUuidModel` | `app/Models/XotBaseUuidModel.php` | UUID automatico |
| `XotBaseTreeModel` | `app/Models/XotBaseTreeModel.php` | Albero (parent_id) |
| `XotBasePivot` | `app/Models/XotBasePivot.php` | Pivot base |
| `XotBaseMorphPivot` | `app/Models/XotBaseMorphPivot.php` | Morph pivot base |
| `BaseModel` | `app/Models/BaseModel.php` | Estende `XotBaseModel` |
| `BaseActivity` | `app/Models/BaseActivity.php` | Log attività |
| `BaseRating` | `app/Models/BaseRating.php` | Rating polimorfico |
| `BaseExtra` | `app/Models/BaseExtra.php` | Extra polimorfico |
| `XotBaseResource` | `app/Filament/Resources/XotBaseResource.php` | Resource base Filament (NO `getFormSchema`) |

### Provider: catena di boot

| Provider | File | Ruolo |
|---|---|---|
| `XotServiceProvider` | `app/Providers/XotServiceProvider.php` | Entry point modulo |
| `XotBaseServiceProvider` | `app/Providers/XotBaseServiceProvider.php` | Registra Actions, Views, Config |
| `XotBaseEventServiceProvider` | `app/Providers/XotBaseEventServiceProvider.php` | Eventi |
| `XotBaseRouteServiceProvider` | `app/Providers/XotBaseRouteServiceProvider.php` | Rotte |
| `XotBaseThemeServiceProvider` | `app/Providers/XotBaseThemeServiceProvider.php` | Tema |
| `FilamentOptimizationServiceProvider` | `app/Providers/FilamentOptimizationServiceProvider.php` | Ottimizzazione Filament |
| `EventServiceProvider` | `app/Providers/EventServiceProvider.php` | Eventi locali |
| `RouteServiceProvider` | `app/Providers/RouteServiceProvider.php` | Rotte locali |

### Trait Form/Table/Infolist: composizione a istanza

| Trait | File | Scopo |
|---|---|---|
| `HasXotForm` | `app/Filament/Traits/HasXotForm.php` | Schema Form (astratto, definisce `getFormSchema`) |
| `HasXotTable` | `app/Filament/Traits/HasXotTable.php` | Schema Table (colonna span, filtri) |
| `HasXotInfolist` | `app/Filament/Traits/HasXotInfolist.php` | Schema Infolist |

**Regola architetturale** (story 25, issue-03): `XotBaseResource` NON ha `getFormSchema()`; solo `XotBaseResourceForm` (HasXotForm) lo definisce astratto. Le forme di Filament vivono in `Schemas/Form`, le tabelle in `Tables`, gli infolist in `Infolists`.

### Action: pattern Spatie queueable

Logiche in `app/Actions/` organizzate per dominio: `Export/`, `Import/`, `Model/`, `Translation/`, `Array/`, `File/`, `Pdf/`, `Route/`, `Url/`, `String/`, `Config/`, `Class/`, `Collections/`, `Query/`, `View/`, `Trans/`, `Theme/`, `Design/`, `Debug/`, `Artisan/`, `Composer/`, `Blade/`, `Cast/`, `Tree/`, `Trend/`, `Geo/`, `Html/`, `Livewire/`, `Mail/`, `ModelClass/`, `Module/`, `Panel/`, `Parsers`, `Factories/`, `Generate/`, `Utilities/`, `Adapters/`. Ogni azione espone `execute()` come punto di ingresso.

### Risorse Filament: modello XotBaseResource + Pages/Schemas/Tables

```
app/Filament/Resources/
├── XotBaseResource/                     # base con Pages e RelationManager
│   ├── Pages/                           # Create/Edit/List/View
│   └── RelationManager/
├── CacheLockResource/S                   # + Schemas/ + Tables/
├── CacheResource/
├── ExtraResource/
├── LogResource/
├── ModuleResource/
└── SessionResource/
```

Ogni risorsa concreta segue il pattern: `Resource.php` + `Pages/` + `Schemas/Form.php + Infolist.php` + `Tables/*.php`.

## Risorse File: pubbliche vs private

- `public_path()` = `public_html/` (root repo), mai `laravel/public/`. Verificabile in `laravel/app/Application.php`.
- Asset statici in `app/Resources/` (img, svg, sass, js, views). Il comando `AssetAction` copia asset in `public_html` in fase di boot (`app/Actions/Filament/...`).

## Shard architetturali

| Shard | Stato | Link |
|---|---|---|
| Mappa inventario + confini | Active | [architecture/module-boundary.md](architecture/module-boundary.md) |
| Filtro composito vs columnSpan | Decided | [architecture/composite-filter-column-span.md](architecture/composite-filter-column-span.md) |
| Sync moduli CLI | Superseded | [architecture/sync-modules-cli.md](architecture/sync-modules-cli.md) |
| Regola risorsa vs form | Active | [architectural-rule-resource-vs-form.md](architectural-rule-resource-vs-form.md) |

## Test

- Pest (`tests/Pest.php`, `tests/Unit/`, `tests/Feature/`): 286 file.
- PHPStan a `laravel/phpstan.neon` level max, scope `Modules/`. Baseline 0 errori (24 ago 2026).
- Code coverage: `typeCoverage.constantTypeCoverage` a 188/302 (62.2%).

## Verifica link

I link relativi puntano a file esistenti in questo modulo. Vedasi `README.md` per lo story index e `discussions/01-traits-composition.md` per il contesto architetturale.
# Architettura del modulo Xot

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

## Pattern utilizzati

- Action (Spatie QueueableAction con `execute()`) al posto dei Service.
- Widget Filament al posto di componenti Livewire dedicati.
- Array PHP con una chiave per riga.
- Form schema-driven tramite `XotBaseSchemaWidget` (`app/Filament/Widgets/XotBaseSchemaWidget.php`).
- Contratti per l'iniezione di dipendenze in `app/Contracts/` (es. `DataContract`, `ExtraContract`).