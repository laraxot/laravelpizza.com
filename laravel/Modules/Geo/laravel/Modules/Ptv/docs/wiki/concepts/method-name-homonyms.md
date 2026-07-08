---
title: "censimento omonimi metodi — modulo Ptv"
type: analysis
module: Ptv
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Ptv

> **92** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Ptv)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 29 |
| `B_sigma_relationship_homonym` | 1 |
| `D_field_metadata_contract` | 4 |
| `E_scheda_stack` | 28 |
| `F_trait_name_collision` | 2 |
| `G_module_local` | 4 |
| `H_cross_module_homonym` | 24 |

## Dettaglio

### `A_filament_framework` (29 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `B_sigma_relationship_homonym`

#### `anag` — 7 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`

### `D_field_metadata_contract`

#### `annFieldName` — 13 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`

#### `rangeFromField` — 13 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`

#### `rangeToField` — 13 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`

#### `matrField` — 5 classi

- `Ptv` · `WorkerFields` · `Modules/Ptv/app/Filament/Forms/Components/WorkerFields.php`

### `E_scheda_stack`

#### `via` — 14 classi

- `Ptv` · `SendSchedaNotification` · `Modules/Ptv/app/Notifications/SendSchedaNotification.php`

#### `getHeaderWidgets` — 13 classi

- `Ptv` · `ListScheda` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/ListScheda.php`
- `Ptv` · `ListSchedas` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/ListSchedas.php`

#### `getView` — 11 classi

- `Ptv` · `FillOutTheForm` · `Modules/Ptv/app/Filament/Resources/ReportResource/Pages/FillOutTheForm.php`
- `Ptv` · `BaseCompilaScheda` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `Ptv` · `BaseFillOutTheForm` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

#### `getModel` — 10 classi

- `Ptv` · `BaseSchedaResource` · `Modules/Ptv/app/Filament/Resources/BaseSchedaResource.php`
- `Ptv` · `UserResource` · `Modules/Ptv/app/Filament/Resources/UserResource.php`

#### `toMail` — 10 classi

- `Ptv` · `SendSchedaNotification` · `Modules/Ptv/app/Notifications/SendSchedaNotification.php`

#### `authorizeAccess` — 7 classi

- `Ptv` · `BaseCompilaScheda` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `Ptv` · `BaseFillOutTheForm` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

#### `criteriOptions` — 7 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`
- `Ptv` · `CriteriEsclusione` · `Modules/Ptv/app/Models/CriteriEsclusione.php`

#### `back` — 6 classi

- `Ptv` · `BaseCompilaScheda` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseCompilaScheda.php`
- `Ptv` · `BaseFillOutTheForm` · `Modules/Ptv/app/Filament/Resources/SchedaResource/Pages/BaseFillOutTheForm.php`

#### `stabiDirigente` — 6 classi

- `Ptv` · `trait:HasStabiDirigente` · `Modules/Ptv/app/Models/Traits/HasStabiDirigente.php`

#### `attachments` — 5 classi

- `Ptv` · `SchedaMail` · `Modules/Ptv/app/Mail/SchedaMail.php`

#### `envelope` — 5 classi

- `Ptv` · `SchedaMail` · `Modules/Ptv/app/Mail/SchedaMail.php`

#### `scopeWithDays` — 5 classi

- `Ptv` · `BaseScheda` · `Modules/Ptv/app/Models/BaseScheda.php`

_… +16 metodi in questa categoria_

### `F_trait_name_collision`

#### `criteriValutazione` — 2 classi

- `Ptv` · `trait:HasCriteriValutazione` · `Modules/Ptv/app/Models/Traits/HasCriteriValutazione.php`

#### `myLogs` — 2 classi

- `Ptv` · `trait:HasMyLogs` · `Modules/Ptv/app/Models/Traits/HasMyLogs.php`

### `G_module_local`

#### `appendColumns` — 7 classi

- `Ptv` · `LavoratoreColumn` · `Modules/Ptv/app/Filament/Columns/LavoratoreColumn.php`
- `Ptv` · `PeriodoColumn` · `Modules/Ptv/app/Filament/Columns/PeriodoColumn.php`
- `Ptv` · `QuaColumn` · `Modules/Ptv/app/Filament/Columns/QuaColumn.php`
- `Ptv` · `QualificaColumn` · `Modules/Ptv/app/Filament/Columns/QualificaColumn.php`
- `Ptv` · `RepColumn` · `Modules/Ptv/app/Filament/Columns/RepColumn.php`
- `Ptv` · `RepartoColumn` · `Modules/Ptv/app/Filament/Columns/RepartoColumn.php`
- `Ptv` · `WorkerColumn` · `Modules/Ptv/app/Filament/Columns/WorkerColumn.php`

#### `areFormActionsSticky` — 2 classi

- `Ptv` · `FirmaStabiReparWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `Ptv` · `FirmaValutatoreWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

#### `filtersUpdated` — 2 classi

- `Ptv` · `FirmaStabiReparWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `Ptv` · `FirmaValutatoreWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

#### `getFormActionsAlignment` — 2 classi

- `Ptv` · `FirmaStabiReparWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `Ptv` · `FirmaValutatoreWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

### `H_cross_module_homonym`

#### `getFormActions` — 13 classi

- `Ptv` · `FirmaStabiReparWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaStabiReparWidget.php`
- `Ptv` · `FirmaValutatoreWidget` · `Modules/Ptv/app/Filament/Resources/ReportResource/Widgets/FirmaValutatoreWidget.php`

#### `getWidgets` — 10 classi

- `Ptv` · `Dashboard` · `Modules/Ptv/app/Filament/Pages/Dashboard.php`

#### `form` — 9 classi

- `Ptv` · `AszEffRelationManager` · `Modules/Ptv/app/Filament/Resources/AnagResource/RelationManagers/AszEffRelationManager.php`
- `Ptv` · `CreateStabiDirigente` · `Modules/Ptv/app/Filament/Resources/ReportResource/Pages/CreateStabiDirigente.php`

#### `getSchema` — 9 classi

- `Ptv` · `LavoratoreColumn` · `Modules/Ptv/app/Filament/Columns/LavoratoreColumn.php`
- `Ptv` · `PeriodoColumn` · `Modules/Ptv/app/Filament/Columns/PeriodoColumn.php`
- `Ptv` · `QuaColumn` · `Modules/Ptv/app/Filament/Columns/QuaColumn.php`
- `Ptv` · `QualificaColumn` · `Modules/Ptv/app/Filament/Columns/QualificaColumn.php`
- `Ptv` · `RepColumn` · `Modules/Ptv/app/Filament/Columns/RepColumn.php`
- `Ptv` · `RepartoColumn` · `Modules/Ptv/app/Filament/Columns/RepartoColumn.php`
- `Ptv` · `WorkerColumn` · `Modules/Ptv/app/Filament/Columns/WorkerColumn.php`
- `Ptv` · `PeriodoSection` · `Modules/Ptv/app/Filament/Forms/Components/PeriodoSection.php`

#### `cast` — 7 classi

- `Ptv` · `DateStringToIntCast` · `Modules/Ptv/app/Casts/DateStringToIntCast.php`

#### `collection` — 6 classi

- `Ptv` · `RepQuaYearData` · `Modules/Ptv/app/Datas/RepQuaYearData.php`

#### `getCards` — 4 classi

- `Ptv` · `AdminWidgets` · `Modules/Ptv/app/Filament/Widgets/AdminWidgets.php`

#### `getEnteAttribute` — 4 classi

- `Ptv` · `BaseStabiDirigente` · `Modules/Ptv/app/Models/BaseStabiDirigente.php`

#### `getNomeDiriAttribute` — 4 classi

- `Ptv` · `BaseStabiDirigente` · `Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `Ptv` · `Valutatore` · `Modules/Ptv/app/Models/Valutatore.php`

#### `getResource` — 4 classi

- `Ptv` · `FillOutTheForm` · `Modules/Ptv/app/Filament/Resources/ReportResource/Pages/FillOutTheForm.php`

#### `panel` — 4 classi

- `Ptv` · `AdminPanelProvider` · `Modules/Ptv/app/Providers/Filament/AdminPanelProvider.php`

#### `repart` — 4 classi

- `Ptv` · `BaseStabiDirigente` · `Modules/Ptv/app/Models/BaseStabiDirigente.php`
- `Ptv` · `Valutatore` · `Modules/Ptv/app/Models/Valutatore.php`

_… +12 metodi in questa categoria_



## Riflessioni Ptv

Cluster `E_scheda_stack`: ereditarietà da `BaseScheda` e trait scheda — allineare a un solo trait accessor `getGg*`.
Verificare che i modelli scheda estendano la gerarchia documentata in Ptv/Sigma wiki.


## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
