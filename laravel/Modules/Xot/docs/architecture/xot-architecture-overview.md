---
title: "xot architecture overview"
type: note
tags: [documentation]
created: 2026-09-26
updated: 2026-09-26
qmd: "xot architecture overview"
issues: []
discussions: []
---

# Xot Architecture

Xot is the foundational layer of Laraxot. It provides base classes, conventions, and utilities that all 47 other modules extend.

## Core Abstractions

**Base Classes:**
- `XotBaseModel` — Eloquent models with `created_by`, `updated_by`, `deleted_by` tracking
- `XotBaseUuidModel` — UUID-keyed models
- `XotBaseTreeModel` — Hierarchical (adjacency list) models
- `XotBaseResource` — Filament resources with `final form()` and `infolist()`
- `XotBasePage` — Filament pages
- `XotBasePanelProvider` — Filament panel configuration with auto-discovery
- `XotBaseServiceProvider` — Module initialization and convention-driven registration
- `XotBaseMigration` — Idempotent migration methods

**Rationale:** Framework APIs (Filament, Livewire, Laravel) change every major version. Xot interposes a stable layer: a single change to `XotBaseResource::form()` updates all 47 modules at once.

## Conventions

1. **Naming**: Models at `Modules\{Mod}\Models\{Name}`, resources at `Modules\{Mod}\Filament\Resources\{Name}Resource`, tables at `Modules\{Mod}\Filament\Resources\Tables\{Plural}Table`.
2. **Translation**: Keys computed by `GetTransKeyAction` → `{module}::{resource}.{field}` from `lang/{locale}/{resource}.php`.
3. **Forms**: Declare `getFormSchema()` or a class `Schemas\{Name}Form`; never override `form()`.
4. **Tables**: Extend `XotBaseResourceTable`, implement `getTableColumns()`.
5. **Migrations**: Use `tableCreate()` and `tableUpdate()` for idempotency.

## Actions (Utilities)

220+ reusable actions in `app/Actions/`:
- **Cast**: `SafeStringCast`, `SafeIntCast`, `SafeArray`, etc.
- **Model**: `StoreAction`, `UpdateAction`, `CountAction`, `GenerateModelByTable`
- **Panel**: `ApplyMetatagToPanelAction`, `ApplyTenancyToPanelAction`
- **Export**: `ExportXlsByCollection`, `ExportXlsByQuery`, `PdfByView`
- **Translation**: `DeepLTranslateAction` (DeepL, Google, MyMemory, Systran, Apertium)

All actions follow `use QueueableAction` and implement `execute()` method.

## System Resources

In `app/Filament/Resources/`:
- `CacheResource`, `SessionResource`, `ExtraResource`, `ModuleResource`, `LogResource`

## System Pages

In `app/Filament/Pages/`:
- `HealthPage` — Spatie Health dashboard
- `MetatagPage` — Branding config (title, logo, colors)
- `EnvPage` — Environment variables
- `MainDashboard` — User panel redirect

## Configuration

| File | Keys | Usage |
|---|---|---|
| `config/config.php` | `name`, `description`, `icon`, `navigation.*`, `routes.*` | Module metadata |
| `config/xot.php` | `paths.*`, `module_paths.*` | System paths |
| `config/mcp.php` | `servers.*` | MCP server endpoints |
| `XotData` (runtime) | `main_module`, `primary_lang`, `pub_theme`, `adm_theme`, `tenant_class`, etc. | Shared app config |
| `MetatagData` (runtime) | `title`, `logo_*`, `colors[]` | Panel branding |

## Database Models

| Model | Table | Purpose |
|---|---|---|
| `Cache`, `CacheLock` | `cache`, `cache_locks` | Database-backed caching |
| `Session` | `sessions` | User sessions |
| `Extra` | `extras` (uuidMorphs) | Schemaless attributes on any model |
| `HealthCheckResultHistoryItem` | `health_check_result_history_items` | Health check history |
| `PulseAggregate`, `PulseEntry`, `PulseValue` | `pulse_*` | Laravel Pulse data |
| `Module` | (in-memory Sushi) | Module registry |
| `Log` | (in-memory Sushi) | Application log entries |

## Discovery & Registration

`XotBaseServiceProvider::boot()` auto-discovers and registers:
- Views from `resources/views/`
- Translations from `lang/`
- Livewire components from `app/Livewire/`
- Blade components from `app/View/Components/`
- Artisan commands from `app/Console/Commands/`
- Public assets from `public/`

`XotBasePanelProvider::panel()` auto-discovers:
- Resources from `app/Filament/Resources/`
- Pages from `app/Filament/Pages/`
- Widgets from `app/Filament/Widgets/`
- Clusters from `app/Filament/Clusters/`

See `docs/xotbasepanelprovider-discovery.md` for full discovery rules.

## Design Philosophy

- **Never Filament directly.** All Filament classes are extended or wrapped through Xot bases.
- **Actions, not Services.** Business logic lives in `Actions/` with `execute()`, never `app/Services/`.
- **DRY at the framework level.** One change to a base class updates all modules.
- **`phpstan.neon` is sacred.** Errors are fixed in code, never silenced with `ignoreErrors`.
- **Folio and Volt for public pages.** Filament reserved for admin.

For complete philosophy, read `docs/archived/project-religion-politics-zen.md`.

## Integration Points

**Xot is extended by:**
Activity, AI, AiAssistant, AsdSoci, Billing, Blog, Bom, Catalog, Cms, Comment, Compliance, Costing, Customer, Dds, Document, Email, Employee, EnergyBroker, Fiscal, Gdpr, Geo, Giveback, HR, Intervention, Inventory, Job, Lang, Media, MetalWork, Notify, Platform, Production, PublicProcurement, Quotation, Rating, Seo, Signage, Signature, Tenant, Thermo, Timber, UI, User, Vehicle, WhatsApp, WorkOrder, Wts.

**Direct dependencies:** User (TenantClass, ProfileClass), Tenant (`SaveTenantConfigAction`), Media (`GetAttachmentsSchemaAction`).
