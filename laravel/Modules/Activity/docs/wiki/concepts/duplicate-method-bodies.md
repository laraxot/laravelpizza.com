---
<<<<<<< .merge_file_I8iSAs
title: "corpi metodo duplicati — Activity"
=======
>>>>>>> .merge_file_TOA2pP
title: "corpi metodo duplicati: Activity"
type: analysis
module: Activity
tags: [dry, duplication, census, refactoring, activity]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Activity identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
<<<<<<< .merge_file_I8iSAs
---

# Corpi metodo duplicati — Activity
=======
>>>>>>> .merge_file_TOA2pP
status: draft
---

# Corpi metodo duplicati: Activity

> **14** gruppi con corpo identico coinvolgono Activity (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Activity)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 6 | 353 |
| `B_business_duplicate` | 1 | 14 |
| `C_cross_name` | 4 | 56 |
| `M_database_layer` | 2 | 10 |
| `S_trivial_stub` | 1 | 18445 |

## Dettaglio

<<<<<<< .merge_file_I8iSAs
### B — Business logic con corpo identico (consolidare: 1 owner)

#### `before` — 3 classi · 7 righe · ~14 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
### B: Business logic con corpo identico (consolidare: 1 owner)

#### `before`: 3 classi · 7 righe · ~14 righe duplicate

- `Activity` · `ActivityBasePolicy::before` · `Modules/Activity/app/Models/Policies/ActivityBasePolicy.php:14`
- `Media` · `MediaBasePolicy::before` · `Modules/Media/app/Models/Policies/MediaBasePolicy.php:14`
- `UI` · `UiBasePolicy::before` · `Modules/UI/app/Models/Policies/UiBasePolicy.php:21`

<<<<<<< .merge_file_I8iSAs
### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `execute` / `isWritable` — 2 classi · 21 righe · ~21 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
### C: Corpo identico, nomi diversi (copy-paste con rename)

#### `execute` / `isWritable`: 2 classi · 21 righe · ~21 righe duplicate

- `Activity` · `IsActivityLogSchemaWritableAction::execute` · `Modules/Activity/app/Actions/Schema/IsActivityLogSchemaWritableAction.php:17`
- `Activity` · `ActivityLogSchema::isWritable` · `Modules/Activity/app/Support/ActivityLogSchema.php:14`

<<<<<<< .merge_file_I8iSAs
#### `execute` / `getByType` — 2 classi · 15 righe · ~15 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `execute` / `getByType`: 2 classi · 15 righe · ~15 righe duplicate

- `Activity` · `ActivityLogger::getByType` · `Modules/Activity/app/Actions/ActivityLogger.php:181`
- `Activity` · `GetActivitiesByTypeAction::execute` · `Modules/Activity/app/Actions/Query/GetActivitiesByTypeAction.php:22`

<<<<<<< .merge_file_I8iSAs
#### `execute` / `getRecent` — 2 classi · 11 righe · ~11 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `execute` / `getRecent`: 2 classi · 11 righe · ~11 righe duplicate

- `Activity` · `ActivityLogger::getRecent` · `Modules/Activity/app/Actions/ActivityLogger.php:203`
- `Activity` · `GetRecentActivitiesAction::execute` · `Modules/Activity/app/Actions/Query/GetRecentActivitiesAction.php:22`

<<<<<<< .merge_file_I8iSAs
#### `execute` / `getModelActivities` — 2 classi · 9 righe · ~9 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `execute` / `getModelActivities`: 2 classi · 9 righe · ~9 righe duplicate

- `Activity` · `ActivityLogger::getModelActivities` · `Modules/Activity/app/Actions/ActivityLogger.php:165`
- `Activity` · `GetModelActivitiesAction::execute` · `Modules/Activity/app/Actions/Query/GetModelActivitiesAction.php:22`

<<<<<<< .merge_file_I8iSAs
### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions` — 50 classi · 5 righe · ~245 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
### A: Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions`: 50 classi · 5 righe · ~245 righe duplicate

- `Activity` · `EditActivity::getHeaderActions` · `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/EditActivity.php:15`
- `Incentivi` · `EditCapitalPercentage::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource/Pages/EditCapitalPercentage.php:15`
- `Incentivi` · `EditDefaultActivity::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/DefaultActivityResource/Pages/EditDefaultActivity.php:15`
- `Incentivi` · `EditPhase::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/PhaseResource/Pages/EditPhase.php:16`
- `Incentivi` · `EditSettlement::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/SettlementResource/Pages/EditSettlement.php:15`
- `Incentivi` · `EditWorkgroup::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/WorkgroupResource/Pages/EditWorkgroup.php:15`
- … +46 occorrenze

<<<<<<< .merge_file_I8iSAs
#### `getTableBulkActions` — 9 classi · 6 righe · ~48 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `getTableBulkActions`: 9 classi · 6 righe · ~48 righe duplicate

- `Activity` · `ListSnapshots::getTableBulkActions` · `Modules/Activity/app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php:76`
- `Performance` · `IndividualeDecurtazioneAssenzeResource::getTableBulkActions` · `Modules/Performance/app/Filament/Resources/IndividualeDecurtazioneAssenzeResource.php:99`
- `Performance` · `IndividualePesiResource::getTableBulkActions` · `Modules/Performance/app/Filament/Resources/IndividualePesiResource.php:129`
- `Performance` · `IndividualeTotStabiResource::getTableBulkActions` · `Modules/Performance/app/Filament/Resources/IndividualeTotStabiResource.php:138`
- `Performance` · `MyLogResource::getTableBulkActions` · `Modules/Performance/app/Filament/Resources/MyLogResource.php:100`
- `Performance` · `OrganizzativaAssenzeResource::getTableBulkActions` · `Modules/Performance/app/Filament/Resources/OrganizzativaAssenzeResource.php:93`
- … +3 occorrenze

<<<<<<< .merge_file_I8iSAs
#### `getFormSchema` — 2 classi · 24 righe · ~24 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `getFormSchema`: 2 classi · 24 righe · ~24 righe duplicate

- `Activity` · `ActivityResource::getFormSchema` · `Modules/Activity/app/Filament/Resources/ActivityResource.php:37`
- `Activity` · `ActivityForm::getFormSchema` · `Modules/Activity/app/Filament/Resources/ActivityResource/Schemas/ActivityForm.php:17`

<<<<<<< .merge_file_I8iSAs
#### `getTableActions` — 4 classi · 7 righe · ~21 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `getTableActions`: 4 classi · 7 righe · ~21 righe duplicate

- `Activity` · `ListSnapshots::getTableActions` · `Modules/Activity/app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php:64`
- `Media` · `ListTemporaryUploads::getTableActions` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Pages/ListTemporaryUploads.php:59`
- `User` · `ListPermissions::getTableActions` · `Modules/User/app/Filament/Resources/PermissionResource/Pages/ListPermissions.php:68`
- `User` · `ProfileRelationManager::getTableActions` · `Modules/User/app/Filament/Resources/UserResource/RelationManagers/ProfileRelationManager.php:70`

<<<<<<< .merge_file_I8iSAs
#### `getFormSchema` — 2 classi · 10 righe · ~10 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `getFormSchema`: 2 classi · 10 righe · ~10 righe duplicate

- `Activity` · `StoredEventResource::getFormSchema` · `Modules/Activity/app/Filament/Resources/StoredEventResource.php:23`
- `Activity` · `StoredEventForm::getFormSchema` · `Modules/Activity/app/Filament/Resources/StoredEventResource/Schemas/StoredEventForm.php:19`

<<<<<<< .merge_file_I8iSAs
#### `casts` — 2 classi · 5 righe · ~5 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `casts`: 2 classi · 5 righe · ~5 righe duplicate

- `Activity` · `BaseModel::casts` · `Modules/Activity/app/Models/BaseModel.php:34`
- `Ptv` · `BaseScheda::casts` · `Modules/Ptv/app/Models/BaseScheda.php:412`

<<<<<<< .merge_file_I8iSAs
### M — Layer database (migrations/factories/seeders)

#### `withUuid` — 2 classi · 5 righe · ~5 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
### M: Layer database (migrations/factories/seeders)

#### `withUuid`: 2 classi · 5 righe · ~5 righe duplicate

- `Activity` · `SnapshotFactory::withUuid` · `Modules/Activity/database/factories/SnapshotFactory.php:50`
- `Activity` · `StoredEventFactory::withUuid` · `Modules/Activity/database/factories/StoredEventFactory.php:63`

<<<<<<< .merge_file_I8iSAs
#### `withVersion` — 2 classi · 5 righe · ~5 righe duplicate
=======
>>>>>>> .merge_file_TOA2pP
#### `withVersion`: 2 classi · 5 righe · ~5 righe duplicate

- `Activity` · `SnapshotFactory::withVersion` · `Modules/Activity/database/factories/SnapshotFactory.php:60`
- `Activity` · `StoredEventFactory::withVersion` · `Modules/Activity/database/factories/StoredEventFactory.php:73`

<<<<<<< .merge_file_I8iSAs
### S — Stub banali (≤30 char) — rumore, non debito

1 gruppi — elenco omesso.
=======
>>>>>>> .merge_file_TOA2pP
### S: Stub banali (≤30 char): rumore, non debito

1 gruppi: elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
