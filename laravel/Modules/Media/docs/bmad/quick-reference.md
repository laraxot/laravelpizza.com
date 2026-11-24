---
title: "Media - quick reference"
description: "Riferimento rapido per lo sviluppo su Modules\\Media: classi chiave, comandi, verifiche e comandi BMAD"
type: note
module: "Media"
alias: "media"
tags: [media, quick-reference, commands, actions, spatie-media-library, bmad]
created: 2026-09-28
updated: 2026-10-07
documentation_date: "2026-09-29"
bmad_version: "6.2.0"
qmd: "Media quick reference comandi azioni conversioni ffmpeg s3 bmad"
related:
  - ./README.md
  - ./setup-guide.md
  - ./architecture/module-boundary.md
  - ./epics/module-roadmap.md
---

# Media - quick reference

> **SUMMARY**: riferimento rapido per lo sviluppo su `Modules\Media`:
> namespace, modelli chiave, action orchestrative, comandi console, path
> delle conversioni, dipendenze e comandi BMAD. Derivato da file reali del modulo.

## Namespace e connessione

- Namespace: `Modules\Media`
- Connessione DB dei model: `media` (vedi `app/Models/BaseModel.php`)

## Modelli principali

| Modello | File | Estende / Implementa | Note |
|---|---|---|---|
| `Media` | `app/Models/Media.php` | `SpatieMedia` | tabella derivata dal model |
| `MediaConvert` | `app/Models/MediaConvert.php` | `BaseModel` | `media_converts` |
| `TemporaryUpload` | `app/Models/TemporaryUpload.php` | `BaseModel`, `HasMedia` | `temporary_uploads` |
| `BaseModel` | `app/Models/BaseModel.php` | `XotBaseModel` | classe astratta, fissa la connessione |

## Relazioni chiave

- `Media::mediaConverts()` -> `HasMany`
- `Media::temporaryUpload()` -> `BelongsTo`
- `Media::creator()` -> `BelongsTo`
- `MediaConvert::media()` -> `BelongsTo` (inversa)

## Contracts ed enum

| Elemento | Ruolo |
|---|---|
| `PathGeneratorContract` (`app/Contracts/`) | Genera i path di storage in modo pluggable |
| `PathGenerator` (`app/Contracts/`) | Implementazione concreta del generatore path |
| `AttachmentTypeEnum` (`app/Enums/`) | `image`, `video`, `document`, `manual` |

## Actions (`app/Actions/`): un dominio per cartella

| Dominio | Action principali |
|---------|-------------------|
| root | `AttachMediaAction`, `SaveAttachmentsAction`, `GetAttachmentsSchemaAction`, `GenerateTemporaryUploadPathAction` |
| `Video/` | `ConvertVideoAction`, `ConvertVideoByMediaConvertAction`, `ConvertVideoByConvertDataAction`, `GetVideoDurationAction`, `GetVideoScreenshotAction`, `GetVideoFrameContentAction` |
| `Image/` | `Merge`, `SvgExistsAction` |
| `Ffmpeg/` | `ResolveMediaExporterAction` |
| `Stream/` | `StreamVideoAction`, `SubtitleService` |
| `Subtitle/` | `ConvertSrtToVttAction`, `ExtractSubtitlePlainTextAction`, `ParseSubtitleXmlAction`, `UpdateModelSubtitleFieldAction` |
| `CloudFront/` | `GetCloudFrontSignedUrlAction` |
| `S3/` | `UploadFileAction`, `DeleteFileAction`, `CheckFileExistsAction`, `GetFileInfoAction` |
| `Storage/` | `GetFilesystemAdapterAction` (disco tipizzato `FilesystemAdapter`, da usare al posto di `Storage::disk()` per `url()` e `mimeType()`) |
| `TemporaryUpload/` | `GetTemporaryUploadPathAction`, `GetTemporaryUploadConversionPathAction`, `GetTemporaryUploadResponsivePathAction` |
| `Diagnostic/` | `Aws/` (CloudFront, IAM, S3), `S3/` (connessione, credenziali, permessi), `Support/` (client S3/STS) |

## Console

| Comando | File | Descrizione |
|---|---|---|
| `php artisan media:convert-video {disk} {file}` | `app/Console/Commands/ConvertVideoCommand.php` | transcodifica un mp4 in WebM via FFmpeg |

## Conversioni (Spatie)

- Conversioni immagine: `app/Conversions/ImageGenerators/` (esiste anche un residuo `app/conversions/` in minuscolo, case-variant)
- Conversioni video: `app/Conversions/VideoGenerators/`
- Conversione FFmpeg: `app/Actions/Ffmpeg/ResolveMediaExporterAction.php`

## Filament

- **Resources** (`app/Filament/Resources/`): `MediaResource`, `MediaConvertResource`, `TemporaryUploadResource`, `HasMediaResource`
- **Extra**: `Clusters/`, `RelationManagers/`, `Infolists/`, `Actions/`, `Tables/`
- Le list page sono sottili: tabelle in `Resources/<R>/Tables/<Plurale>Table`, schemi in `Schemas/`.
- **Livewire**: nessun controller residuo, i Conversion manager sono il target widget.

## Pattern del modulo

- Un path di storage non e' mai hardcoded: passa da `PathGeneratorContract`
- `MediaConvert` e' asincrono: la conversione parte e il record si aggiorna via queue
- Streaming via URL firmato CloudFront, mai file pubblico esposto
- `TemporaryUpload` precede l'attach: ciclo separato, cleanup a parte
- Immagini con `intervention/image`, video con `pbmedia/laravel-ffmpeg` `^8.5`

## Comandi rapidi (da laravel/)

```bash
# PHPStan solo su questo modulo
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Media

# Pint su questo modulo
./vendor/bin/pint Modules/Media

# Pest su questo modulo
./vendor/bin/pest Modules/Media
```

## Comandi BMAD per Media

### Help

```bash
bmad-help
```

### Workflow

```bash
# Phase 1
bmad-domain-research      # Studio dominio: immagini, video, streaming, S3
bmad-technical-research   # Fattibilita' FFmpeg, CloudFront, conversione

# Phase 2
bmad-create-prd           # PRD: upload, conversioni, streaming, allegati
bmad-create-architecture  # Architettura Media <-> MediaConvert <-> TemporaryUpload

# Phase 3
bmad-create-epics-and-stories            # Epic: immagini, video, allegati
bmad-check-implementation-readiness      # Quality gate

# Phase 4
bmad-sprint-planning      # Sprint iniziale
bmad-create-story         # Story: modello MediaConvert, migrazione
bmad-dev-story            # Implementazione
bmad-code-review          # Review con focus path, storage, ffmpeg
```

### Agenti per Media

| Agente | Skill | Scopo |
|--------|-------|-------|
| Mary (analyst) | `skill: "bmad-agent-analyst"` | ricerca gestione media |
| John (pm) | `skill: "bmad-agent-pm"` | PRD conversioni e streaming |
| Winston (architect) | `skill: "bmad-agent-architect"` | architettura storage e path |
| Amelia (dev) | `skill: "bmad-agent-dev"` | implementazione Actions |
| Quinn (qa) | `skill: "bmad-agent-qa"` | test upload, conversione, signed URL |

### Quick flow

```bash
bmad-quick-dev "Aggiungi thumbnail alla tabella media"
bmad-quick-spec "Specifica retention dei temporary upload"
```

## Vedi anche

- [README](./README.md)
- [Setup guide](./setup-guide.md)
- [Architettura: module boundary](./architecture/module-boundary.md)
- [Epic roadmap](./epics/module-roadmap.md)
