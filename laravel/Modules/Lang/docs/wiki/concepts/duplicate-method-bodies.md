---
issues: []
discussions: []
title: "corpi metodo duplicati — Lang"
type: analysis
module: Lang
tags: [dry, duplication, census, refactoring, lang]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Lang identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — Lang

> **19** gruppi con corpo identico coinvolgono Lang (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Lang)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 5 | 237 |
| `B_business_duplicate` | 7 | 99 |
| `M_database_layer` | 1 | 35 |
| `S_trivial_stub` | 6 | 19596 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `execute` — 2 classi · 29 righe · ~29 righe duplicate

- `Lang` · `GetAllModuleTranslationAction::execute` · `Modules/Lang/app/Actions/GetAllModuleTranslationAction.php:22`
- `Lang` · `GetAllTranslationAction::execute` · `Modules/Lang/app/Actions/GetAllTranslationAction.php:22`

#### `get` — 2 classi · 20 righe · ~20 righe duplicate

- `Lang` · `TranslatorAction::get` · `Modules/Lang/app/Actions/TranslatorAction.php:30`
- `Lang` · `TranslatorAdapter::get` · `Modules/Lang/app/Adapters/TranslatorAdapter.php:34`

#### `panel` — 2 classi · 17 righe · ~17 righe duplicate

- `Lang` · `AdminPanelProvider::panel` · `Modules/Lang/app/Providers/Filament/AdminPanelProvider.php:16`
- `Lang` · `LangBasePanelProvider::panel` · `Modules/Lang/app/Providers/Filament/LangBasePanelProvider.php:16`

#### `notifyMissingKey` — 2 classi · 11 righe · ~11 righe duplicate

- `Lang` · `TranslatorAction::notifyMissingKey` · `Modules/Lang/app/Actions/TranslatorAction.php:53`
- `Lang` · `TranslatorService::notifyMissingKey` · `Modules/Lang/app/Services/TranslatorService.php:60`

#### `translatableComponents` — 2 classi · 10 righe · ~10 righe duplicate

- `Lang` · `LangServiceProvider::translatableComponents` · `Modules/Lang/app/Providers/LangServiceProvider.php:172`
- `Xot` · `XotServiceProvider::translatableComponents` · `Modules/Xot/app/Providers/XotServiceProvider.php:205`

#### `execute` — 2 classi · 9 righe · ~9 righe duplicate

- `Lang` · `TransCollectionAction::execute` · `Modules/Lang/app/Actions/TransCollectionAction.php:27`
- `Xot` · `TransCollectionAction::execute` · `Modules/Xot/app/Actions/Collection/TransCollectionAction.php:29`

#### `getDefaultTranslatableLocale` — 2 classi · 3 righe · ~3 righe duplicate

- `Lang` · `LangBaseResource::getDefaultTranslatableLocale` · `Modules/Lang/app/Filament/Resources/LangBaseResource.php:16`
- `Lang` · `TranslationFileResource::getDefaultTranslatableLocale` · `Modules/Lang/app/Filament/Resources/TranslationFileResource.php:18`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getTableColumns` — 20 classi · 10 righe · ~190 righe duplicate

- `Lang` · `TranslationFilesTable::getTableColumns` · `Modules/Lang/app/Filament/Resources/TranslationFileResource/Tables/TranslationFilesTable.php:40`
- `Job` · `ExportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ExportResource/Tables/ExportsTable.php:16`
- `Job` · `ImportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:18`
- `Job` · `JobBatchsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php:16`
- `Job` · `JobManagersTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php:17`
- `Job` · `JobsWaitingsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php:16`
- … +14 occorrenze

#### `casts` — 3 classi · 10 righe · ~20 righe duplicate

- `Lang` · `BaseModel::casts` · `Modules/Lang/app/Models/BaseModel.php:22`
- `Lang` · `BaseModelLang::casts` · `Modules/Lang/app/Models/BaseModelLang.php:65`
- `Rating` · `BaseModel::casts` · `Modules/Rating/app/Models/BaseModel.php:17`

#### `render` — 2 classi · 12 righe · ~12 righe duplicate

- `Lang` · `Change::render` · `Modules/Lang/app/Http/Livewire/Lang/Change.php:66`
- `Lang` · `Switcher::render` · `Modules/Lang/app/Http/Livewire/Lang/Switcher.php:63`

#### `casts` — 2 classi · 9 righe · ~9 righe duplicate

- `Lang` · `BaseMorphPivot::casts` · `Modules/Lang/app/Models/BaseMorphPivot.php:59`
- `Rating` · `BaseMorphPivot::casts` · `Modules/Rating/app/Models/BaseMorphPivot.php:48`

#### `getHeaderActions` — 2 classi · 6 righe · ~6 righe duplicate

- `Lang` · `LangBaseEditRecord::getHeaderActions` · `Modules/Lang/app/Filament/Resources/Pages/LangBaseEditRecord.php:17`
- `Lang` · `LangBaseViewRecord::getHeaderActions` · `Modules/Lang/app/Filament/Resources/Pages/LangBaseViewRecord.php:17`

### M — Layer database (migrations/factories/seeders)

#### `run` — 8 classi · 5 righe · ~35 righe duplicate

- `Lang` · `LangDatabaseSeeder::run` · `Modules/Lang/database/seeders/LangDatabaseSeeder.php:15`
- `IndennitaCondizioniLavoro` · `IndennitaCondizioniLavoroDatabaseSeeder::run` · `Modules/IndennitaCondizioniLavoro/database/seeders/IndennitaCondizioniLavoroDatabaseSeeder.php:20`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaDatabaseSeeder::run` · `Modules/IndennitaResponsabilita/database/seeders/IndennitaResponsabilitaDatabaseSeeder.php:15`
- `Notify` · `NotifyDatabaseSeeder::run` · `Modules/Notify/database/seeders/NotifyDatabaseSeeder.php:15`
- `Performance` · `PerformanceDatabaseSeeder::run` · `Modules/Performance/database/seeders/PerformanceDatabaseSeeder.php:15`
- `Progressioni` · `ProgressioniDatabaseSeeder::run` · `Modules/Progressioni/database/seeders/ProgressioniDatabaseSeeder.php:15`
- … +2 occorrenze

### S — Stub banali (≤30 char) — rumore, non debito

6 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
