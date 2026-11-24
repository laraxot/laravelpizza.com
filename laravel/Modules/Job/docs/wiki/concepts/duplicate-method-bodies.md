---
issues: []
discussions: []
title: "corpi metodo duplicati — Job"
type: analysis
module: Job
tags: [dry, duplication, census, refactoring, job]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Job identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — Job

> **37** gruppi con corpo identico coinvolgono Job (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Job)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 17 | 1092 |
| `B_business_duplicate` | 8 | 104 |
| `C_cross_name` | 5 | 94 |
| `S_trivial_stub` | 7 | 19835 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `beginStream` — 2 classi · 56 righe · ~56 righe duplicate

- `Job` · `ClockWidget::beginStream` · `Modules/Job/app/Filament/Widgets/ClockWidget.php:55`
- `Job` · `QueueListenWidget::beginStream` · `Modules/Job/app/Filament/Widgets/QueueListenWidget.php:55`

#### `doWrite` — 2 classi · 13 righe · ~13 righe duplicate

- `Job` · `ClockWidget::doWrite` · `Modules/Job/app/Filament/Widgets/ClockWidget.php:66`
- `Job` · `QueueListenWidget::doWrite` · `Modules/Job/app/Filament/Widgets/QueueListenWidget.php:66`

#### `getFromCache` — 2 classi · 10 righe · ~10 righe duplicate

- `Job` · `GetActiveSchedulesAction::getFromCache` · `Modules/Job/app/Actions/GetActiveSchedulesAction.php:43`
- `Job` · `ScheduleService::getFromCache` · `Modules/Job/app/Services/ScheduleService.php:48`

#### `task` — 3 classi · 3 righe · ~6 righe duplicate

- `Job` · `Frequency::task` · `Modules/Job/app/Models/Frequency.php:62`
- `Job` · `Result::task` · `Modules/Job/app/Models/Result.php:57`
- `Job` · `TaskComment::task` · `Modules/Job/app/Models/TaskComment.php:43`

#### `onValidationError` — 2 classi · 6 righe · ~6 righe duplicate

- `Job` · `CreateSchedule::onValidationError` · `Modules/Job/app/Filament/Resources/ScheduleResource/Pages/CreateSchedule.php:48`
- `Job` · `EditSchedule::onValidationError` · `Modules/Job/app/Filament/Resources/ScheduleResource/Pages/EditSchedule.php:37`

#### `withValue` — 2 classi · 5 righe · ~5 righe duplicate

- `Job` · `ScheduleArguments::withValue` · `Modules/Job/app/Filament/Columns/ScheduleArguments.php:19`
- `Job` · `ScheduleOptions::withValue` · `Modules/Job/app/Filament/Columns/ScheduleOptions.php:13`
- `Job` · `ScheduleArguments::withValue` · `Modules/Job/app/Filament/Tables/Columns/ScheduleArguments.php:19`
- `Job` · `ScheduleOptions::withValue` · `Modules/Job/app/Filament/Tables/Columns/ScheduleOptions.php:14`

#### `getWidgets` — 2 classi · 5 righe · ~5 righe duplicate

- `Job` · `JobManagerResource::getWidgets` · `Modules/Job/app/Filament/Resources/JobManagerResource.php:58`
- `Job` · `JobResource::getWidgets` · `Modules/Job/app/Filament/Resources/JobResource.php:45`

#### `user` — 2 classi · 3 righe · ~3 righe duplicate

- `Job` · `TaskComment::user` · `Modules/Job/app/Models/TaskComment.php:51`
- `User` · `TeamPermission::user` · `Modules/User/app/Models/TeamPermission.php:82`

### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `getHeaderActions` / `getTableActions` — 9 classi · 6 righe · ~48 righe duplicate

- `Job` · `ListJobs::getTableActions` · `Modules/Job/app/Filament/Resources/JobResource/Pages/ListJobs.php:70`
- `Job` · `JobsTable::getTableActions` · `Modules/Job/app/Filament/Resources/JobResource/Tables/JobsTable.php:43`
- `Incentivi` · `EditEmployee::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/EmployeeResource/Pages/EditEmployee.php:16`
- `IndennitaCondizioniLavoro` · `EditUpload::getHeaderActions` · `Modules/IndennitaCondizioniLavoro/app/Filament/Resources/UploadResource/Pages/EditUpload.php:16`
- `User` · `EditSocialProvider::getHeaderActions` · `Modules/User/app/Filament/Clusters/Socialite/Resources/SocialProviderResource/Pages/EditSocialProvider.php:16`
- `User` · `EditRole::getHeaderActions` · `Modules/User/app/Filament/Resources/RoleResource/Pages/EditRole.php:43`
- … +4 occorrenze

#### `getHeaderActions` / `getTableHeaderActions` — 2 classi · 23 righe · ~23 righe duplicate

- `Job` · `ListFailedJobs::getHeaderActions` · `Modules/Job/app/Filament/Resources/FailedJobResource/Pages/ListFailedJobs.php:51`
- `Job` · `FailedJobsTable::getTableHeaderActions` · `Modules/Job/app/Filament/Resources/FailedJobResource/Tables/FailedJobsTable.php:33`

#### `getHeaderWidgets` / `getWidgets` — 3 classi · 5 righe · ~10 righe duplicate

- `Job` · `JobsWaitingResource::getWidgets` · `Modules/Job/app/Filament/Resources/JobsWaitingResource.php:41`
- `Job` · `ListJobsWaiting::getHeaderWidgets` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaiting.php:21`
- `Job` · `ListJobsWaitings::getHeaderWidgets` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaitings.php:25`

#### `execute` / `getActives` — 2 classi · 7 righe · ~7 righe duplicate

- `Job` · `GetActiveSchedulesAction::execute` · `Modules/Job/app/Actions/GetActiveSchedulesAction.php:31`
- `Job` · `ScheduleService::getActives` · `Modules/Job/app/Services/ScheduleService.php:28`

#### `clearCache` / `execute` — 2 classi · 6 righe · ~6 righe duplicate

- `Job` · `ClearScheduleCacheAction::execute` · `Modules/Job/app/Actions/ClearScheduleCacheAction.php:15`
- `Job` · `ClearScheduleCacheAction::execute` · `Modules/Job/app/Actions/Schedule/ClearScheduleCacheAction.php:15`
- `Job` · `ScheduleService::clearCache` · `Modules/Job/app/Services/ScheduleService.php:37`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions` — 50 classi · 5 righe · ~245 righe duplicate

- `Job` · `EditJob::getHeaderActions` · `Modules/Job/app/Filament/Resources/JobResource/Pages/EditJob.php:15`
- `Job` · `EditJobsWaiting::getHeaderActions` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/EditJobsWaiting.php:15`
- `Activity` · `EditActivity::getHeaderActions` · `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/EditActivity.php:15`
- `Incentivi` · `EditCapitalPercentage::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource/Pages/EditCapitalPercentage.php:15`
- `Incentivi` · `EditDefaultActivity::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/DefaultActivityResource/Pages/EditDefaultActivity.php:15`
- `Incentivi` · `EditPhase::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/PhaseResource/Pages/EditPhase.php:16`
- … +46 occorrenze

#### `getTableColumns` — 20 classi · 10 righe · ~190 righe duplicate

- `Job` · `ExportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ExportResource/Tables/ExportsTable.php:16`
- `Job` · `ImportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:18`
- `Job` · `JobBatchsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php:16`
- `Job` · `JobManagersTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php:17`
- `Job` · `JobsWaitingsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php:16`
- `Lang` · `TranslationFilesTable::getTableColumns` · `Modules/Lang/app/Filament/Resources/TranslationFileResource/Tables/TranslationFilesTable.php:40`
- … +14 occorrenze

#### `getTableBulkActions` — 31 classi · 5 righe · ~150 righe duplicate

- `Job` · `ListImports::getTableBulkActions` · `Modules/Job/app/Filament/Resources/ImportResource/Pages/ListImports.php:76`
- `Job` · `ImportsTable::getTableBulkActions` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:34`
- `Job` · `ListJobBatches::getTableBulkActions` · `Modules/Job/app/Filament/Resources/JobBatchResource/Pages/ListJobBatches.php:94`
- `Job` · `JobBatchesTable::getTableBulkActions` · `Modules/Job/app/Filament/Resources/JobBatchResource/Tables/JobBatchesTable.php:54`
- `Job` · `ListJobManagers::getTableBulkActions` · `Modules/Job/app/Filament/Resources/JobManagerResource/Pages/ListJobManagers.php:50`
- `Job` · `JobManagersTable::getTableBulkActions` · `Modules/Job/app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php:26`
- … +25 occorrenze

#### `getFormSchema` — 19 classi · 7 righe · ~126 righe duplicate

- `Job` · `ExportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ExportResource/Schemas/ExportForm.php:17`
- `Job` · `ImportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ImportResource/Schemas/ImportForm.php:17`
- `Job` · `JobBatchForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobBatchResource/Schemas/JobBatchForm.php:17`
- `Job` · `JobManagerForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobManagerResource/Schemas/JobManagerForm.php:17`
- `Job` · `JobsWaitingForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Schemas/JobsWaitingForm.php:17`
- `Media` · `HasMediaForm::getFormSchema` · `Modules/Media/app/Filament/Resources/HasMediaResource/Schemas/HasMediaForm.php:17`
- … +13 occorrenze

#### `casts` — 7 classi · 18 righe · ~108 righe duplicate

- `Job` · `BaseMorphPivot::casts` · `Modules/Job/app/Models/BaseMorphPivot.php:49`
- `Notify` · `BaseMorphPivot::casts` · `Modules/Notify/app/Models/BaseMorphPivot.php:49`
- `Notify` · `BasePivot::casts` · `Modules/Notify/app/Models/BasePivot.php:45`
- `User` · `TenantUser::casts` · `Modules/User/app/Models/TenantUser.php:70`
- `Xot` · `BaseMorphPivot::casts` · `Modules/Xot/app/Models/BaseMorphPivot.php:55`
- `Xot` · `XotBaseMorphPivot::casts` · `Modules/Xot/app/Models/XotBaseMorphPivot.php:117`
- … +1 occorrenze

#### `getTableColumns` — 8 classi · 10 righe · ~70 righe duplicate

- `Job` · `FailedImportRowsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/FailedImportRowResource/Tables/FailedImportRowsTable.php:15`
- `Job` · `SchedulesTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ScheduleResource/Tables/SchedulesTable.php:22`
- `Media` · `MediaConvertsTable::getTableColumns` · `Modules/Media/app/Filament/Resources/MediaConvertResource/Tables/MediaConvertsTable.php:15`
- `Media` · `TemporaryUploadsTable::getTableColumns` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Tables/TemporaryUploadsTable.php:15`
- `Xot` · `CacheLocksTable::getTableColumns` · `Modules/Xot/app/Filament/Resources/CacheLockResource/Tables/CacheLocksTable.php:12`
- `Xot` · `CachesTable::getTableColumns` · `Modules/Xot/app/Filament/Resources/CacheResource/Tables/CachesTable.php:12`
- … +2 occorrenze

#### `getTableActions` — 11 classi · 6 righe · ~60 righe duplicate

- `Job` · `ListImports::getTableActions` · `Modules/Job/app/Filament/Resources/ImportResource/Pages/ListImports.php:65`
- `Job` · `ImportsTable::getTableActions` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:27`
- `Incentivi` · `ListProjects::getTableActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ListProjects.php:90`
- `Incentivi` · `ProjectsTable::getTableActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Tables/ProjectsTable.php:81`
- `Performance` · `CriteriMaggiorazioneResource::getTableActions` · `Modules/Performance/app/Filament/Resources/CriteriMaggiorazioneResource.php:121`
- `Performance` · `CriteriOptionsTable::getTableActions` · `Modules/Performance/app/Filament/Resources/CriteriOptionResource/Tables/CriteriOptionsTable.php:72`
- … +5 occorrenze

#### `getFormSchema` — 3 classi · 12 righe · ~24 righe duplicate

- `Job` · `JobManagerResource::getFormSchema` · `Modules/Job/app/Filament/Resources/JobManagerResource.php:28`
- `Job` · `JobsWaitingResource::getFormSchema` · `Modules/Job/app/Filament/Resources/JobsWaitingResource.php:27`
- `Job` · `JobForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Schemas/JobForm.php:19`

#### `getTableColumns` — 2 classi · 24 righe · ~24 righe duplicate

- `Job` · `ListJobsWaiting::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaiting.php:32`
- `Job` · `ListJobsWaitings::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Pages/ListJobsWaitings.php:36`

#### `casts` — 2 classi · 18 righe · ~18 righe duplicate

- `Job` · `FailedImportRow::casts` · `Modules/Job/app/Models/FailedImportRow.php:53`
- `Job` · `Import::casts` · `Modules/Job/app/Models/Import.php:74`

_… +7 gruppi in questa categoria (vedi JSON)_

### S — Stub banali (≤30 char) — rumore, non debito

7 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
