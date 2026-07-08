---
title: "censimento omonimi metodi — modulo Media"
type: analysis
module: Media
updated: 2026-06-15
related:
  - ../../../../../../docs/wiki/method-name-homonym-census.md
  - ../../../../../../bashscripts/docs/method-homonym-census.json
---

# Censimento omonimi metodi — Media

> **59** nomi metodo omonimi coinvolgono questo modulo (su 689 totali progetto).

## Riepilogo categoria (solo Media)

| Categoria | Metodi |
|-----------|--------|
| `A_filament_framework` | 29 |
| `E_scheda_stack` | 4 |
| `G_module_local` | 7 |
| `H_cross_module_homonym` | 19 |

## Dettaglio

### `A_filament_framework` (29 metodi)

Hook Filament/Laravel ripetuti — **non** debito. Elenco omesso.

### `E_scheda_stack`

#### `before` — 14 classi

- `Media` · `MediaBasePolicy` · `Modules/Media/app/Models/Policies/MediaBasePolicy.php`

#### `getHeaderWidgets` — 13 classi

- `Media` · `ListMediaConverts` · `Modules/Media/app/Filament/Resources/MediaConvertResource/Pages/ListMediaConverts.php`
- `Media` · `ViewMedia` · `Modules/Media/app/Filament/Resources/MediaResource/Pages/ViewMedia.php`

#### `getModel` — 10 classi

- `Media` · `SubtitleService` · `Modules/Media/app/Services/SubtitleService.php`

#### `rules` — 6 classi

- `Media` · `CreateTemporaryUploadFromDirectS3UploadRequest` · `Modules/Media/app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php`

### `G_module_local`

#### `convert` — 2 classi

- `Media` · `PowerPoint` · `Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `Media` · `Webm` · `Modules/Media/app/Conversions/VideoGenerators/Webm.php`

#### `getDiskName` — 2 classi

- `Media` · `VideoEntry` · `Modules/Media/app/Filament/Infolists/VideoEntry.php`
- `Media` · `TemporaryUpload` · `Modules/Media/app/Models/TemporaryUpload.php`

#### `requirementsAreInstalled` — 2 classi

- `Media` · `PowerPoint` · `Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `Media` · `Webm` · `Modules/Media/app/Conversions/VideoGenerators/Webm.php`

#### `supportedExtensions` — 2 classi

- `Media` · `PowerPoint` · `Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `Media` · `Webm` · `Modules/Media/app/Conversions/VideoGenerators/Webm.php`

#### `supportedMimeTypes` — 2 classi

- `Media` · `PowerPoint` · `Modules/Media/app/Conversions/ImageGenerators/PowerPoint.php`
- `Media` · `Webm` · `Modules/Media/app/Conversions/VideoGenerators/Webm.php`

#### `test_s3_connection` — 2 classi

- `Media` · `AwsTest` · `Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php`
- `Media` · `S3Test` · `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

#### `test_s3_permissions` — 2 classi

- `Media` · `AwsTest` · `Modules/Media/app/Filament/Clusters/Test/Pages/AwsTest.php`
- `Media` · `S3Test` · `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

### `H_cross_module_homonym`

#### `getFormActions` — 13 classi

- `Media` · `S3Test` · `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

#### `get` — 9 classi

- `Media` · `SubtitleService` · `Modules/Media/app/Services/SubtitleService.php`

#### `sendEmail` — 7 classi

- `Media` · `S3Test` · `Modules/Media/app/Filament/Clusters/Test/Pages/S3Test.php`

#### `getInstance` — 6 classi

- `Media` · `SubtitleService` · `Modules/Media/app/Services/SubtitleService.php`

#### `trans` — 6 classi

- `Media` · `AddAttachmentAction` · `Modules/Media/app/Filament/Actions/AddAttachmentAction.php`
- `Media` · `AddAttachmentAction` · `Modules/Media/app/Filament/Resources/HasMediaResource/Actions/AddAttachmentAction.php`

#### `messages` — 5 classi

- `Media` · `CreateTemporaryUploadFromDirectS3UploadRequest` · `Modules/Media/app/Http/Requests/CreateTemporaryUploadFromDirectS3UploadRequest.php`

#### `begin` — 4 classi

- `Media` · `ConvertWidget` · `Modules/Media/app/Filament/Resources/MediaResource/Widgets/ConvertWidget.php`

#### `message` — 4 classi

- `Media` · `FileExtensionRule` · `Modules/Media/app/Rules/FileExtensionRule.php`

#### `panel` — 4 classi

- `Media` · `AdminPanelProvider` · `Modules/Media/app/Providers/Filament/AdminPanelProvider.php`

#### `creator` — 3 classi

- `Media` · `Media` · `Modules/Media/app/Models/Media.php`

#### `getContent` — 3 classi

- `Media` · `SubtitleService` · `Modules/Media/app/Services/SubtitleService.php`

#### `getPath` — 3 classi

- `Media` · `TemporaryUploadPathGenerator` · `Modules/Media/app/Support/TemporaryUploadPathGenerator.php`

_… +7 metodi in questa categoria_




## Rigenerazione

```bash
python3 bashscripts/tools/census-method-homonyms.py
```
