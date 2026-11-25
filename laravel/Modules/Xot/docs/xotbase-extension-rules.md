---
title: "Regole di estensione XotBase"
type: rule
status: active
module: Xot
qmd: "xotbase extension rules filament extends XotBaseResource XotBaseWidget XotBasePage XotBaseListRecords arch test famiglie"
updated: 2026-11-25
---

# Regole di estensione XotBase

Regola unica: **nei moduli e nei temi non si estende mai una classe Filament (o Eloquent/Laravel di base) direttamente: si estende la sua base `XotBase*`
di `Modules/Xot`.** Le basi centralizzano traduzioni, etichette di navigazione, tabelle, form e hook: una modifica sulla base vale per tutti i moduli.

## Mappa delle basi (verificata sul codice)

| Si vuole estendere | Si estende | Percorso in `app/` di Xot |
|---|---|---|
| `Filament\Resources\Resource` | `XotBaseResource` | `Filament/Resources/XotBaseResource.php` |
| `ListRecords` / `CreateRecord` / `EditRecord` / `ViewRecord` | `XotBaseListRecords`, `XotBaseCreateRecord`, `XotBaseEditRecord`, `XotBaseViewRecord` | `Filament/Resources/Pages/` |
| `ManageRecords` / `ManageRelatedRecords` | `XotBaseManageRecords`, `XotBaseManageRelatedRecords` | `Filament/Resources/Pages/` |
| `RelationManager` | `XotBaseRelationManager` | `Filament/Resources/RelationManagers/` |
| `Filament\Pages\Page` / `Dashboard` | `XotBasePage`, `XotBaseDashboard` (pagina impostazioni: `BaseSettingPage`) | `Filament/Pages/` |
| `Widget` | `XotBaseWidget` (con `HasActions`, `HasForms`) | `Filament/Widgets/` |
| `ChartWidget`, `StatsOverviewWidget`, `TableWidget` | `XotBaseChartWidget`, `XotBaseStatsOverviewWidget`, `XotBaseTableWidget` | `Filament/Widgets/` |
| widget con schema/form, infolist, wizard | `XotBaseSchemaWidget`, `XotBaseInfolistWidget`, `XotBaseWizardWidget` | `Filament/Widgets/` |
| `PanelProvider` | `XotBasePanelProvider`, `XotBaseMainPanelProvider` | `Providers/Filament/` |
| `Illuminate\Database\Eloquent\Model` / pivot | `XotBaseModel`, `XotBaseUuidModel`, `XotBaseTreeModel`, `XotBasePivot`, `XotBaseMorphPivot` | `Models/` |
| policy | `XotBasePolicy` (operative: `OperationalXotBasePolicy`) | `Models/Policies/` |
| migration | `XotBaseMigration` | `Database/Migrations/` |
| service provider modulo | `XotBaseServiceProvider`, `XotBaseRouteServiceProvider`, `XotBaseEventServiceProvider`, `XotBaseThemeServiceProvider` | `Providers/` |

Il namespace e' `Modules\Xot\...` senza il segmento `app` (nwidart mappa `app/` sul namespace del modulo): `Modules\MyModule\Filament\Resources`, mai
`Modules\MyModule\App\Filament\Resources`.

## Errori tipici

- **"Class contains N abstract method"**: la base dichiara metodi astratti (per esempio `getFormSchema()` nei widget): vanno implementati tutti, mai con un
  array vuoto.
- **"Access level must be public"**: la visibilita' deve coincidere con quella della base; per i widget vedi [filament-conventions.md](filament-conventions.md).
- **"Cannot override final method"**: `form()` e `table()` di `XotBaseManageRelatedRecords` (e `form()` di `HasXotForm`) sono `final`: si estendono con gli hook
  (`getFormSchema()`, `modifyRelatedQuery()`, ...), non con un override.
- **Tabella vuota senza errori** su una list page: gli hook `getTable*` scritti sulla pagina risolvono allo stub deprecato di Filament; la tabella appartiene
  alla Resource (vedi [filament-conventions.md](filament-conventions.md)).
- Override di un hook = sostituzione; per estendere: `[...propri, ...parent::getTableXxx()]`.

## Cosa NON si fa

- `extends Filament\...` in un modulo (salvo i casi elencati nel debito di `tests/Arch/debt.php`, che puo' solo scendere).
- Estendere `Model`/`Pivot` Eloquent direttamente: si parte da `XotBaseModel` (vedi [models.md](models.md)) e per le many-to-many si usa
  `belongsToManyX` ([traits/relation-x.md](traits/relation-x.md)).
- Duplicare nei moduli metodi gia' presenti nelle basi (traduzioni, `registerViews`, ...): vedi
  [serviceprovider-minimal-structure.md](serviceprovider-minimal-structure.md).

## Guardie

- `tests/Arch/ArchitectureTest.php`: tabella `XOTBASE_FAMILIES` (Resource, Create/Edit/ManageRecords, RelationManager, Chart/StatsOverview/Table widget) e
  regola `xotbase`; il debito di ogni pacchetto sta in `tests/Arch/debt.php` (solo in discesa).
- `tests/Unit/XotBaseManageRelatedRecordsRegressionTest.php`, `tests/Unit/ListPageHasTableClassTest.php`.
- Ricerca manuale: `grep -rn "extends Filament\\\\" laravel/Modules --include=*.php`.

## Decisioni collegate

- [adr/0006-xot-base-extension-points.md](adr/0006-xot-base-extension-points.md)
- [adr/0020-architecture-tests-pest-arch.md](adr/0020-architecture-tests-pest-arch.md)
