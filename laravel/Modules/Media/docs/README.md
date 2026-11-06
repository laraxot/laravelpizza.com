---
title: "Media Module - Documentation Index"
type: documentation
bmad_id: MEDIA-DOCS-INDEX
domain: media-module
module: Media
version: 1.1.0
status: active
audience: [developer, maintainer]
tags: [media, docs, index, bmad, documentation]
created: 2026-09-26
updated: 2026-10-23
qmd: "README"
issues: []
discussions: []
related: [bmad/00-INDEX.md, bmad/readme.md, INDEX.md]
---

# Media Module - Documentation Index

Path: `laravel/Modules/Media/docs/`
Module: @Modules/Media
Scope: punto di ingresso della documentazione del modulo Media (gestione multimediale in Laraxot). `docs-archive-2026/` non esiste ne' nel modulo ne' nella radice del repo (verificato 2026-10-14): lo storico vive nelle sottocartelle di `docs/`. La mappa delle directory era in `00-INDEX.md`, rimosso il 2026-10-22 (commit e2282c1b) e non riportato altrove.

## File canonici

1. **[README.md](README.md)** - questo file, punto di ingresso
2. **[architecture.md](ARCHITECTURE.md)** - architettura, namespace, dipendenze, struttura, funzionalita'
3. **[INDEX.md](index.md)** - indice completo per categoria, con le story BMAD
4. **[index.md](index.md)** - bridge per discovery (legacy)

Nota: `readme.md` (minuscolo) e' un bridge legacy con la stessa sezione "Scopo" e "Linkage"; la coppia case-variant e' un duplicato da consolidare (vedi [16-4](./stories/16-4-media-case-variant-consolidation.md) per lo stesso problema nei test).

## Scopo del modulo

Verificato sul codice il 2026-10-14 (`app/`, `config/`, `database/migrations`, `routes/`):
- Modelli sopra Spatie MediaLibrary: `Media` estende `Spatie\MediaLibrary\MediaCollections\Models\Media`, `TemporaryUpload` implementa `HasMedia`, `MediaConvert` traccia le conversioni video. Connessione database `media` (`Models/BaseModel`).
- Conversione video con `pbmedia/laravel-ffmpeg`: `Actions/Video/*`, comando `media:convert-video {disk} {file}`, generatori `Conversions/VideoGenerators/Webm` e `Conversions/ImageGenerators/PowerPoint`.
- Allegati ai record: `AttachMediaAction`, `SaveAttachmentsAction`, `GetAttachmentsSchemaAction`, azione Filament `AddAttachmentAction`.
- Sottotitoli e streaming: `Actions/Subtitle/*` (SRT in VTT, lettura XML) e `Actions/Stream/StreamVideoAction`.
- Storage AWS S3 e CloudFront: `Actions/S3/*`, `Actions/CloudFront/GetCloudFrontSignedUrlAction`, diagnostica in `Actions/Diagnostic/Aws/*` e `Actions/Diagnostic/S3/*`, pagine Filament di prova nel cluster `Test` (`AwsTest`, `S3Test`).
- Pannello Filament `media::admin` con tre Resource (`MediaResource`, `MediaConvertResource`, `TemporaryUploadResource`) piu' `HasMediaResource`, che porta relation manager e schemi riusabili dagli altri moduli.

Citato in vecchi documenti ma non trovato nel codice: HLS/DASH, watermark automatico, isolamento per tenant (nessun riferimento a `Tenant` in `app/`), CDN generico (esiste solo CloudFront).

- Modelli sopra Spatie MediaLibrary: `Media` estende `Spatie\MediaLibrary\MediaCollections\Models\Media`, `TemporaryUpload` implementa `HasMedia`, `MediaConvert` traccia le conversioni video. Connessione database `media` (`Models/BaseModel`).
- Conversione video con `pbmedia/laravel-ffmpeg`: `Actions/Video/*`, comando `media:convert-video {disk} {file}`, generatori `Conversions/VideoGenerators/Webm` e `Conversions/ImageGenerators/PowerPoint`.
- Allegati ai record: `AttachMediaAction`, `SaveAttachmentsAction`, `GetAttachmentsSchemaAction`, azione Filament `AddAttachmentAction`.
- Sottotitoli e streaming: `Actions/Subtitle/*` (SRT in VTT, lettura XML) e `Actions/Stream/StreamVideoAction`.
- Storage AWS S3 e CloudFront: `Actions/S3/*`, `Actions/CloudFront/GetCloudFrontSignedUrlAction`, diagnostica in `Actions/Diagnostic/Aws/*` e `Actions/Diagnostic/S3/*`, pagine Filament di prova nel cluster `Test` (`AwsTest`, `S3Test`).
- Pannello Filament `media::admin` con tre Resource (`MediaResource`, `MediaConvertResource`, `TemporaryUploadResource`) piu' `HasMediaResource`, che porta relation manager e schemi riusabili dagli altri moduli.

## Dove iniziare

- [Wiki locale](./wiki/index.md)
- [Audit ridondanza](./code-redundancy-audit.md)
- [Regole architettura](./architecture-rules.md)
- [Disciplina agenti](./agent-edit-discipline.md)

## Dipendenze e collegamenti

- [README root (vetrina)](../README.md) · [Xot (framework base)](../../Xot/docs/)
- Standard [README doppio](../../../../docs/wiki/standards/module-theme-readme-dual.md) e [disciplina issue GitHub](../../../../docs/wiki/how-to/github-issue-agent-discipline.md) da seguire prima di modifiche sostanziali.
- Dipende, nel codice, da: Xot (85 righe `use Modules\Xot` in `app/` e `tests/`), User (3), UI (2, `SvgExistsAction`), Job (1, `ClockWidget` in `ListMediaConverts`). `Tenant` compare solo tra i `repositories` di tipo path in `composer.json`.
- Usato da (file in `Modules/*/app` e `Themes/*/app` che citano `Modules\Media` o `media::`): Blog 9, Notify 8, User 4, Rating 2, Fixcity 2, Cms 2, Xot 1.
- Standard di documentazione: [contratto docs di moduli e temi](../../../../bmad-output/docs-architecture/module-theme-docs-contract.md).

## Quick start

Dalla cartella `laravel/`, verificato il 2026-10-14:

```bash
php artisan list media                    # espone media:convert-video {disk} {file}
php artisan route:list --name=media       # 19 rotte, tutte del pannello Filament media/admin
vendor/bin/phpstan analyse Modules/Media  # exit 0, nessun errore
vendor/bin/pest Modules/Media/tests       # 40 file di test; non eseguito in questa verifica
```

Il pannello e' raggiungibile su `media/admin` (Resource `media`, `media-converts`, `temporary-uploads`, cluster `test`). Configurazione propria del modulo: `config/config.php` (nome, icona, navigazione); le chiavi operative sono in `laravel/config/media-library.php` (`media_model`, `temporary_upload_model`, `max_file_size` 10 MB) e in `filesystems.cloudfront.*` / `services.cloudfront.*`.

## Limiti e debiti noti

- `routes/web.php` e `routes/api.php` sono vuoti. `Http/Controllers/ConvertController` (vista `media::convert`) non ha rotta ed e' citato solo da un test di istanziazione.
- Non esiste `app/Services/`: `SubtitleService` e `VideoStream` sono stati rimossi (story 2026-10-08 services-to-actions).
- Directory con varianti di maiuscole nel codice: `app/Conversions` e `app/conversions`, `tests/Filament` e `tests/filament` (story 16-4).
- `app/Filament/Clusters/` contiene una directory dal nome corrotto (`极est/Pages/AwsTest.php`, file tracciato da 0 byte) accanto a `Test/`.
- Due migrazioni di create per `medias` (`2022_01_01_000011` e `2026_07_23_150000`) e per `temporary_uploads` (`2023_01_01_000000` e `2026_01_18_152545`).
- `docs/lambda_function.py` e `docs/lambda-function.py` sono identici (esempio AWS Lambda con ffmpeg) e non sono usati dal codice: nessun riferimento a "lambda" in `app/`, `config/`, `tests/`.

## Struttura della documentazione

- **architecture.md**: architettura del modulo e pattern di design
- **README.md**: questo file
- **stories/**: story BMAD del modulo (elenco in [INDEX.md](index.md#story-bmad))
- **bmad/**: artefatti BMAD (indice in [bmad/00-INDEX.md](./bmad/00-index.md))

Linee guida: documenti chiari e concisi, ricchi di esempi, aggiornati insieme al codice, in formato Markdown (`.md`).

## Story recenti

- [2026-10-06 PHPStan cleanup - Media](./stories/phpstan-zero-errors-media.story.md) · [dev](./stories/phpstan-zero-errors-media.dev.md)
- [02 Risoluzione dei marker di merge del commit e7e667b11](./stories/02.Media-merge-conflict-resolution.story.md)
- [2026-10-30 Niente testi fissi nelle Blade (it, en, de, es)](./stories/blade-i18n-no-hardcoded-text.story.md)
