---
issues: []
discussions: []
title: "corpi metodo duplicati: Rating"
type: analysis
module: Rating
tags: [dry, duplication, census, refactoring, rating]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Rating identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
status: draft
---

# Corpi metodo duplicati: Rating

> **18** gruppi con corpo identico coinvolgono Rating (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Rating)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 8 | 229 |
| `B_business_duplicate` | 2 | 33 |
| `C_cross_name` | 3 | 75 |
| `S_trivial_stub` | 5 | 18523 |

## Dettaglio

### B: Business logic con corpo identico (consolidare: 1 owner)

#### `getRatingsCountAttribute`: 2 classi · 19 righe · ~19 righe duplicate

- `Rating` · `trait:HasRatingsTrait::getRatingsCountAttribute` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php:147`
- `Rating` · `trait:RatingTrait::getRatingsCountAttribute` · `Modules/Rating/app/Models/Traits/RatingTrait.php:113`

#### `getRatingsAvgAttribute`: 2 classi · 14 righe · ~14 righe duplicate

- `Rating` · `trait:HasRatingsTrait::getRatingsAvgAttribute` · `Modules/Rating/app/Models/Traits/HasRatingsTrait.php:131`
- `Rating` · `trait:RatingTrait::getRatingsAvgAttribute` · `Modules/Rating/app/Models/Traits/RatingTrait.php:97`

### C: Corpo identico, nomi diversi (copy-paste con rename)

#### `create` / `delete` / `forceDelete` / `restore` / `reverse` / `update`: 11 classi · 3 righe · ~30 righe duplicate

- `Rating` · `RatingMorphPolicy::restore` · `Modules/Rating/app/Models/Policies/RatingMorphPolicy.php:61`
- `Rating` · `RatingMorphPolicy::forceDelete` · `Modules/Rating/app/Models/Policies/RatingMorphPolicy.php:69`
- `Rating` · `RatingPolicy::restore` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:56`
- `Rating` · `RatingPolicy::forceDelete` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:64`
- `Incentivi` · `SettlementPolicy::reverse` · `Modules/Incentivi/app/Models/Policies/SettlementPolicy.php:103`
- `IndennitaResponsabilita` · `BaseModelPolicy::create` · `Modules/IndennitaResponsabilita/app/Models/Policies/BaseModelPolicy.php:32`
- … +17 occorrenze

#### `create` / `delete` / `update` / `view` / `viewAny`: 10 classi · 3 righe · ~27 righe duplicate

- `Rating` · `RatingPolicy::create` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:32`
- `Rating` · `RatingPolicy::update` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:40`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaPolicy::update` · `Modules/IndennitaResponsabilita/app/Models/Policies/IndennitaResponsabilitaPolicy.php:54`
- `IndennitaResponsabilita` · `IndennitaResponsabilitaPolicy::delete` · `Modules/IndennitaResponsabilita/app/Models/Policies/IndennitaResponsabilitaPolicy.php:62`
- `Performance` · `IndividualeDirigentePolicy::viewAny` · `Modules/Performance/app/Models/Policies/IndividualeDirigentePolicy.php:16`
- `Performance` · `IndividualeDirigentePolicy::create` · `Modules/Performance/app/Models/Policies/IndividualeDirigentePolicy.php:33`
- … +11 occorrenze

#### `create` / `view` / `viewAny`: 7 classi · 3 righe · ~18 righe duplicate

- `Rating` · `RatingMorphPolicy::viewAny` · `Modules/Rating/app/Models/Policies/RatingMorphPolicy.php:16`
- `Rating` · `RatingMorphPolicy::create` · `Modules/Rating/app/Models/Policies/RatingMorphPolicy.php:34`
- `Rating` · `RatingPolicy::viewAny` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:16`
- `Rating` · `RatingPolicy::view` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:24`
- `Performance` · `IndividualePoPesiPolicy::viewAny` · `Modules/Performance/app/Models/Policies/IndividualePoPesiPolicy.php:16`
- `Ptv` · `CriteriEsclusionePolicy::viewAny` · `Modules/Ptv/app/Models/Policies/CriteriEsclusionePolicy.php:16`
- … +3 occorrenze

### A: Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getTableActions`: 11 classi · 6 righe · ~60 righe duplicate

- `Rating` · `BaseRatingsTable::getTableActions` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/BaseRatingsTable.php:56`
- `Rating` · `RatingTable::getTableActions` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/RatingTable.php:55`
- `Incentivi` · `ListProjects::getTableActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ListProjects.php:90`
- `Incentivi` · `ProjectsTable::getTableActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Tables/ProjectsTable.php:81`
- `Job` · `ListImports::getTableActions` · `Modules/Job/app/Filament/Resources/ImportResource/Pages/ListImports.php:65`
- `Job` · `ImportsTable::getTableActions` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:27`
- … +5 occorrenze

#### `getFormSchema`: 4 classi · 15 righe · ~45 righe duplicate

- `Rating` · `BaseRatingResource::getFormSchema` · `Modules/Rating/app/Filament/Resources/BaseRatingResource.php:25`
- `Rating` · `BaseRatingForm::getFormSchema` · `Modules/Rating/app/Filament/Resources/RatingResource/Schemas/BaseRatingForm.php:28`
- `IndennitaResponsabilita` · `RatingForm::getFormSchema` · `Modules/IndennitaResponsabilita/app/Filament/Resources/RatingResource/Schemas/RatingForm.php:22`
- `Progressioni` · `RatingForm::getFormSchema` · `Modules/Progressioni/app/Filament/Resources/RatingResource/Schemas/RatingForm.php:22`

#### `getTableColumns`: 3 classi · 22 righe · ~44 righe duplicate

- `Rating` · `ListRatingMorphs::getTableColumns` · `Modules/Rating/app/Filament/Resources/RatingMorphResource/Pages/ListRatingMorphs.php:19`
- `IndennitaResponsabilita` · `RatingMorphsTable::getTableColumns` · `Modules/IndennitaResponsabilita/app/Filament/Resources/RatingMorphResource/Tables/RatingMorphsTable.php:20`
- `Progressioni` · `RatingMorphsTable::getTableColumns` · `Modules/Progressioni/app/Filament/Resources/RatingMorphResource/Tables/RatingMorphsTable.php:21`

#### `getTableColumns`: 3 classi · 13 righe · ~26 righe duplicate

- `Rating` · `BaseRatingsTable::getTableColumns` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/BaseRatingsTable.php:29`
- `Rating` · `RatingTable::getTableColumns` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/RatingTable.php:28`
- `Rating` · `RatingsTable::getTableColumns` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/RatingsTable.php:16`

#### `casts`: 3 classi · 10 righe · ~20 righe duplicate

- `Rating` · `BaseModel::casts` · `Modules/Rating/app/Models/BaseModel.php:17`
- `Lang` · `BaseModel::casts` · `Modules/Lang/app/Models/BaseModel.php:22`
- `Lang` · `BaseModelLang::casts` · `Modules/Lang/app/Models/BaseModelLang.php:65`

#### `delete`: 7 classi · 3 righe · ~18 righe duplicate

- `Rating` · `RatingPolicy::delete` · `Modules/Rating/app/Models/Policies/RatingPolicy.php:48`
- `Performance` · `IndividualeDirigentePolicy::delete` · `Modules/Performance/app/Models/Policies/IndividualeDirigentePolicy.php:50`
- `Performance` · `IndividualePoPesiPolicy::delete` · `Modules/Performance/app/Models/Policies/IndividualePoPesiPolicy.php:48`
- `Ptv` · `ProfilePolicy::delete` · `Modules/Ptv/app/Models/Policies/ProfilePolicy.php:61`
- `Sigma` · `Ana00fPolicy::delete` · `Modules/Sigma/app/Models/Policies/Ana00fPolicy.php:74`
- `Sigma` · `AnagPolicy::delete` · `Modules/Sigma/app/Models/Policies/AnagPolicy.php:74`
- … +1 occorrenze

#### `casts`: 2 classi · 9 righe · ~9 righe duplicate

- `Rating` · `BaseMorphPivot::casts` · `Modules/Rating/app/Models/BaseMorphPivot.php:48`
- `Lang` · `BaseMorphPivot::casts` · `Modules/Lang/app/Models/BaseMorphPivot.php:59`

#### `getTableBulkActions`: 2 classi · 7 righe · ~7 righe duplicate

- `Rating` · `BaseRatingsTable::getTableBulkActions` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/BaseRatingsTable.php:66`
- `Rating` · `RatingTable::getTableBulkActions` · `Modules/Rating/app/Filament/Resources/RatingResource/Tables/RatingTable.php:65`

### S: Stub banali (≤30 char): rumore, non debito

5 gruppi: elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
