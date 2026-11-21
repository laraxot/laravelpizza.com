---
issues: []
discussions: []
title: "corpi metodo duplicati — Media"
type: analysis
module: Media
tags: [dry, duplication, census, refactoring, media]
created: 2026-07-22
updated: 2026-07-22
qmd: "duplicate method bodies Media identical hash DRY"

related:
  - ../../../../../../docs/wiki/duplicate-method-bodies-census.md
  - ./method-name-homonyms.md
---

# Corpi metodo duplicati — Media

> **27** gruppi con corpo identico coinvolgono Media (su 790 totali progetto).
> Omonimo con corpo **diverso** = configurazione, e' nel [censimento omonimi](./method-name-homonyms.md); qui solo corpi **identici**.

## Riepilogo (solo Media)

| Categoria | Gruppi | ~Righe duplicate |
|-----------|--------|------------------|
| `A_config_identical` | 9 | 928 |
| `B_business_duplicate` | 9 | 112 |
| `C_cross_name` | 4 | 65 |
| `S_trivial_stub` | 5 | 19716 |

## Dettaglio

### B — Business logic con corpo identico (consolidare: 1 owner)

#### `processRangeHeader` — 2 classi · 27 righe · ~27 righe duplicate

- `Media` · `StreamVideoAction::processRangeHeader` · `Modules/Media/app/Actions/Stream/StreamVideoAction.php:108`
- `Media` · `VideoStream::processRangeHeader` · `Modules/Media/app/Services/VideoStream.php:102`

#### `streamContent` — 2 classi · 20 righe · ~20 righe duplicate

- `Media` · `StreamVideoAction::streamContent` · `Modules/Media/app/Actions/Stream/StreamVideoAction.php:140`
- `Media` · `VideoStream::streamContent` · `Modules/Media/app/Services/VideoStream.php:134`

#### `setHeaders` — 2 classi · 17 righe · ~17 righe duplicate

- `Media` · `StreamVideoAction::setHeaders` · `Modules/Media/app/Actions/Stream/StreamVideoAction.php:89`
- `Media` · `VideoStream::setHeaders` · `Modules/Media/app/Services/VideoStream.php:80`

#### `before` — 3 classi · 7 righe · ~14 righe duplicate

- `Media` · `MediaBasePolicy::before` · `Modules/Media/app/Models/Policies/MediaBasePolicy.php:14`
- `Activity` · `ActivityBasePolicy::before` · `Modules/Activity/app/Models/Policies/ActivityBasePolicy.php:14`
- `UI` · `UiBasePolicy::before` · `Modules/UI/app/Models/Policies/UiBasePolicy.php:21`

#### `secondsToHms` — 2 classi · 9 righe · ~9 righe duplicate

- `Media` · `SubtitleService::secondsToHms` · `Modules/Media/app/Actions/Stream/SubtitleService.php:206`
- `Media` · `ParseSubtitleXmlAction::secondsToHms` · `Modules/Media/app/Actions/Subtitle/ParseSubtitleXmlAction.php:85`
- `Media` · `SubtitleService::secondsToHms` · `Modules/Media/app/Services/SubtitleService.php:206`

#### `closeStream` — 2 classi · 7 righe · ~7 righe duplicate

- `Media` · `StreamVideoAction::closeStream` · `Modules/Media/app/Actions/Stream/StreamVideoAction.php:162`
- `Media` · `VideoStream::closeStream` · `Modules/Media/app/Services/VideoStream.php:159`

#### `getInstance` — 2 classi · 7 righe · ~7 righe duplicate

- `Media` · `SubtitleService::getInstance` · `Modules/Media/app/Actions/Stream/SubtitleService.php:41`
- `Media` · `SubtitleService::getInstance` · `Modules/Media/app/Services/SubtitleService.php:41`
- `Notify` · `MailtrapEngine::getInstance` · `Modules/Notify/app/Services/MailEngines/MailtrapEngine.php:33`

#### `getBasePath` — 2 classi · 6 righe · ~6 righe duplicate

- `Media` · `GenerateTemporaryUploadPathAction::getBasePath` · `Modules/Media/app/Actions/GenerateTemporaryUploadPathAction.php:26`
- `Media` · `TemporaryUploadPathGenerator::getBasePath` · `Modules/Media/app/Support/TemporaryUploadPathGenerator.php:34`

#### `getContent` — 2 classi · 5 righe · ~5 righe duplicate

- `Media` · `ExtractSubtitlePlainTextAction::getContent` · `Modules/Media/app/Actions/Subtitle/ExtractSubtitlePlainTextAction.php:33`
- `Media` · `ParseSubtitleXmlAction::getContent` · `Modules/Media/app/Actions/Subtitle/ParseSubtitleXmlAction.php:78`

### C — Corpo identico, nomi diversi (copy-paste con rename)

#### `execute` / `srtToVtt` — 2 classi · 27 righe · ~27 righe duplicate

- `Media` · `SubtitleService::srtToVtt` · `Modules/Media/app/Actions/Stream/SubtitleService.php:177`
- `Media` · `ConvertSrtToVttAction::execute` · `Modules/Media/app/Actions/Subtitle/ConvertSrtToVttAction.php:18`
- `Media` · `SubtitleService::srtToVtt` · `Modules/Media/app/Services/SubtitleService.php:177`

#### `buildConfigDebugData` / `execute` — 2 classi · 18 righe · ~18 righe duplicate

- `Media` · `BuildConfigDebugDataAction::execute` · `Modules/Media/app/Actions/Diagnostic/S3/BuildConfigDebugDataAction.php:16`
- `Media` · `S3Test::buildConfigDebugData` · `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php:266`

#### `execute` / `from` — 2 classi · 11 righe · ~11 righe duplicate

- `Media` · `ResolveMediaExporterAction::execute` · `Modules/Media/app/Actions/Ffmpeg/ResolveMediaExporterAction.php:15`
- `Media` · `MediaExporterResolver::from` · `Modules/Media/app/Support/Ffmpeg/MediaExporterResolver.php:19`

#### `execute` / `getAwsConfig` — 2 classi · 9 righe · ~9 righe duplicate

- `Media` · `GetAwsConfigSnapshotAction::execute` · `Modules/Media/app/Actions/Diagnostic/Aws/GetAwsConfigSnapshotAction.php:18`
- `Media` · `AwsTest::getAwsConfig` · `Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php:248`

### A — Hook framework con corpo identico (override ridondante / candidato default XotBase)

#### `getHeaderActions` — 50 classi · 5 righe · ~245 righe duplicate

- `Media` · `EditMedia::getHeaderActions` · `Modules/Media/app/Filament/Resources/MediaResource/Pages/EditMedia.php:18`
- `Media` · `ViewMedia::getHeaderActions` · `Modules/Media/app/Filament/Resources/MediaResource/Pages/ViewMedia.php:88`
- `Media` · `EditTemporaryUpload::getHeaderActions` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Pages/EditTemporaryUpload.php:18`
- `Activity` · `EditActivity::getHeaderActions` · `Modules/Activity/app/Filament/Resources/ActivityResource/Pages/EditActivity.php:15`
- `Incentivi` · `EditCapitalPercentage::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/CapitalPercentageResource/Pages/EditCapitalPercentage.php:15`
- `Incentivi` · `EditDefaultActivity::getHeaderActions` · `Modules/Incentivi/app/Filament/Resources/DefaultActivityResource/Pages/EditDefaultActivity.php:15`
- … +46 occorrenze

#### `getTableColumns` — 20 classi · 10 righe · ~190 righe duplicate

- `Media` · `HasMediasTable::getTableColumns` · `Modules/Media/app/Filament/Resources/HasMediaResource/Tables/HasMediasTable.php:15`
- `Job` · `ExportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ExportResource/Tables/ExportsTable.php:16`
- `Job` · `ImportsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ImportResource/Tables/ImportsTable.php:18`
- `Job` · `JobBatchsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobBatchResource/Tables/JobBatchsTable.php:16`
- `Job` · `JobManagersTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobManagerResource/Tables/JobManagersTable.php:17`
- `Job` · `JobsWaitingsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Tables/JobsWaitingsTable.php:16`
- … +14 occorrenze

#### `getTableBulkActions` — 31 classi · 5 righe · ~150 righe duplicate

- `Media` · `ListMediaConverts::getTableBulkActions` · `Modules/Media/app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php:99`
- `Media` · `ListTemporaryUploads::getTableBulkActions` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Pages/ListTemporaryUploads.php:72`
- `Incentivi` · `ManageProjectSettlements::getTableBulkActions` · `Modules/Incentivi/app/Filament/Resources/ProjectResource/Pages/ManageProjectSettlements.php:107`
- `IndennitaResponsabilita` · `ListRatingMorphs::getTableBulkActions` · `Modules/IndennitaResponsabilita/app/Filament/Resources/RatingMorphResource/Pages/ListRatingMorphs.php:81`
- `IndennitaResponsabilita` · `RatingMorphsTable::getTableBulkActions` · `Modules/IndennitaResponsabilita/app/Filament/Resources/RatingMorphResource/Tables/RatingMorphsTable.php:73`
- `Job` · `ListImports::getTableBulkActions` · `Modules/Job/app/Filament/Resources/ImportResource/Pages/ListImports.php:76`
- … +25 occorrenze

#### `getFormSchema` — 19 classi · 7 righe · ~126 righe duplicate

- `Media` · `HasMediaForm::getFormSchema` · `Modules/Media/app/Filament/Resources/HasMediaResource/Schemas/HasMediaForm.php:17`
- `Job` · `ExportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ExportResource/Schemas/ExportForm.php:17`
- `Job` · `ImportForm::getFormSchema` · `Modules/Job/app/Filament/Resources/ImportResource/Schemas/ImportForm.php:17`
- `Job` · `JobBatchForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobBatchResource/Schemas/JobBatchForm.php:17`
- `Job` · `JobManagerForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobManagerResource/Schemas/JobManagerForm.php:17`
- `Job` · `JobsWaitingForm::getFormSchema` · `Modules/Job/app/Filament/Resources/JobsWaitingResource/Schemas/JobsWaitingForm.php:17`
- … +13 occorrenze

#### `getInfolistSchema` — 12 classi · 7 righe · ~77 righe duplicate

- `Media` · `HasMediaInfolist::getInfolistSchema` · `Modules/Media/app/Filament/Resources/HasMediaResource/Schemas/HasMediaInfolist.php:15`
- `Notify` · `NotificationLogInfolist::getInfolistSchema` · `Modules/Notify/app/Filament/Resources/NotificationLogResource/Schemas/NotificationLogInfolist.php:15`
- `User` · `OauthAccessTokenInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAccessTokenResource/Schemas/OauthAccessTokenInfolist.php:14`
- `User` · `OauthAuthCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthAuthCodeResource/Schemas/OauthAuthCodeInfolist.php:14`
- `User` · `OauthClientInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthClientResource/Schemas/OauthClientInfolist.php:14`
- `User` · `OauthDeviceCodeInfolist::getInfolistSchema` · `Modules/User/app/Filament/Clusters/Passport/Resources/OauthDeviceCodeResource/Schemas/OauthDeviceCodeInfolist.php:14`
- … +6 occorrenze

#### `getTableColumns` — 8 classi · 10 righe · ~70 righe duplicate

- `Media` · `MediaConvertsTable::getTableColumns` · `Modules/Media/app/Filament/Resources/MediaConvertResource/Tables/MediaConvertsTable.php:15`
- `Media` · `TemporaryUploadsTable::getTableColumns` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Tables/TemporaryUploadsTable.php:15`
- `Job` · `FailedImportRowsTable::getTableColumns` · `Modules/Job/app/Filament/Resources/FailedImportRowResource/Tables/FailedImportRowsTable.php:15`
- `Job` · `SchedulesTable::getTableColumns` · `Modules/Job/app/Filament/Resources/ScheduleResource/Tables/SchedulesTable.php:22`
- `Xot` · `CacheLocksTable::getTableColumns` · `Modules/Xot/app/Filament/Resources/CacheLockResource/Tables/CacheLocksTable.php:12`
- `Xot` · `CachesTable::getTableColumns` · `Modules/Xot/app/Filament/Resources/CacheResource/Tables/CachesTable.php:12`
- … +2 occorrenze

#### `getFormSchema` — 2 classi · 38 righe · ~38 righe duplicate

- `Media` · `MediaConvertResource::getFormSchema` · `Modules/Media/app/Filament/Resources/MediaConvertResource.php:25`
- `Media` · `MediaConvertForm::getFormSchema` · `Modules/Media/app/Filament/Resources/MediaConvertResource/Schemas/MediaConvertForm.php:16`

#### `getTableActions` — 4 classi · 7 righe · ~21 righe duplicate

- `Media` · `ListTemporaryUploads::getTableActions` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Pages/ListTemporaryUploads.php:59`
- `Activity` · `ListSnapshots::getTableActions` · `Modules/Activity/app/Filament/Resources/SnapshotResource/Pages/ListSnapshots.php:64`
- `User` · `ListPermissions::getTableActions` · `Modules/User/app/Filament/Resources/PermissionResource/Pages/ListPermissions.php:68`
- `User` · `ProfileRelationManager::getTableActions` · `Modules/User/app/Filament/Resources/UserResource/RelationManagers/ProfileRelationManager.php:70`

#### `getFormSchema` — 2 classi · 11 righe · ~11 righe duplicate

- `Media` · `TemporaryUploadResource::getFormSchema` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource.php:32`
- `Media` · `TemporaryUploadForm::getFormSchema` · `Modules/Media/app/Filament/Resources/TemporaryUploadResource/Schemas/TemporaryUploadForm.php:17`

### S — Stub banali (≤30 char) — rumore, non debito

5 gruppi — elenco omesso.


## Rigenerazione

```bash
python3 bashscripts/tools/census-duplicate-method-bodies.py
```
