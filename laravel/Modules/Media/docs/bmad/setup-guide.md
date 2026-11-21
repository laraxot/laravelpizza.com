---
title: "Media - setup guide"
description: "Setup dell'ambiente di sviluppo e convenzioni BMAD del modulo Media"
type: note
module: "Media"
alias: "media"
tags: [media, setup, environment, aws, ffmpeg, s3, cloudfront, bmad]
created: 2026-09-28
updated: 2026-10-07
documentation_date: "2026-09-29"
bmad_version: "6.2.0"
qmd: "Media setup ambiente ffmpeg s3 cloudfront dipendenze bmad"
related:
  - ./README.md
  - ./quick-reference.md
  - ./architecture/module-boundary.md
  - ./epics/module-roadmap.md
  - ../../composer.json
  - ../../config/config.php
---

# Media - setup guide

> **SUMMARY**: guida per configurare l'ambiente di sviluppo del modulo
> `Modules\Media` e per lavorarci con il metodo BMAD. Copre composer, config,
> dipendenze esterne (FFmpeg, S3, CloudFront), migrazioni, verifica della
> connessione e convenzioni di codice. Derivata da `composer.json`,
> `module.json`, `config/config.php` e `app/Actions/Diagnostic/`.

## Scopo

Rendere ripetibile e verificabile l'uso del BMAD Method per il modulo Media.

## Prerequisiti

| Requisito | Versione | Verifica |
|---|---|---|
| PHP | ^8.2 | `php -v` |
| FFmpeg | presente (binario di sistema) | `ffmpeg -version` |
| AWS CLI | presente | `aws --version` |
| Connessione S3 | configurata | vedi diagnostica |

## Installazione dipendenze

Da `laravel/`:

```bash
composer install
```

Dipendenze del modulo (`composer.json`):

- `pbmedia/laravel-ffmpeg` ^8.5 (usata da `app/Actions/Ffmpeg/ResolveMediaExporterAction.php`)
- `intervention/image` `*` (usata da `app/Actions/Image/`)
- `spatie/laravel-medialibrary` (non dichiarata nel `composer.json` del modulo, arriva dal root: il model `app/Models/Media.php` estende `Spatie\MediaLibrary\...\Media`)

## Configurazione

1. `.env` con le variabili S3/CloudFront (lette da
   `app/Actions/Diagnostic/Aws/GetAwsConfigSnapshotAction.php`).
2. Binario FFmpeg: `FFMPEG_BINARIES` (config `laravel-ffmpeg`) e `FFMPEG_PATH`
   (config `media-library`, default `/usr/bin/ffmpeg`).
3. `config/config.php` del modulo:
   - icona: `heroicon-o-photo`
   - navigazione abilitata, ordine 60
   - route con middleware `['web', 'auth']`
4. Link simbolico pubblico, se serve: `php artisan storage:link`.
5. Provider registrati in `module.json` e in `composer.json` (`extra.laravel.providers`):
   - `Modules\Media\Providers\MediaServiceProvider`
   - `Modules\Media\Providers\Filament\AdminPanelProvider`

   `Providers/RouteServiceProvider` esiste nel modulo ma non e' elencato in questi due file (da verificare se e' caricato dal `MediaServiceProvider`).

## Migrazioni

Da `laravel/` (forward-only, mai `migrate:fresh`):

```bash
php artisan module:migrate Media
```

Migrazioni in `database/migrations/` (il nome tabella e' derivato dal model, convenzione Xot `tableCreate`; connessione `media`):

| File | Tabella |
|---|---|
| `2022_01_01_000000_create_media_converts_table.php` | `media_converts` |
| `2022_01_01_000011_create_medias_table.php` | tabella del model `Media` |
| `2023_01_01_000000_create_temporary_uploads_table.php` | `temporary_uploads` |
| `2026_01_18_152545_create_temporary_uploads_table.php` | `temporary_uploads` (seconda create, da verificare) |
| `2026_01_18_152545_add_columns_to_temporary_uploads_table.php` | colonne aggiuntive di `temporary_uploads` |
| `2026_07_23_150000_create_medias_table.php` | tabella del model `Media` (seconda create, da verificare) |

> **Dati sacri**: mai `migrate:fresh`, mai `--force`, mai `RefreshDatabase`.
> Solo migrate additivi. Su host `10.100.200.15` non si lanciano test Pest.

## Diagnostica ambiente

Eseguire prima di ogni lavoro:

| Action | File | Verifica |
|---|---|---|
| `TestS3ConnectionAction` | `app/Actions/Diagnostic/Aws/TestS3ConnectionAction.php` | connessione S3 |
| `TestCredentialsAction` | `app/Actions/Diagnostic/S3/TestCredentialsAction.php` | credenziali AWS |
| `TestCloudFrontConfigAction` | `app/Actions/Diagnostic/Aws/TestCloudFrontConfigAction.php` | CloudFront |
| `RunFullAwsDiagnosticAction` | `app/Actions/Diagnostic/Aws/RunFullAwsDiagnosticAction.php` | diagnostica completa |

## Conversione video

```bash
php artisan media:convert-video {disk} {file}
```

La conversione e' asincrona e deve poter essere ritentata.

## Verifica ambiente

```bash
# PHPStan solo su questo modulo
php -d memory_limit=2G ./vendor/bin/phpstan analyse Modules/Media
# Pest
./vendor/bin/pest Modules/Media
```

## Cosa e' "BMAD" qui (Business Logic)

In questo modulo BMAD serve a:

- **Garantire la riproducibilita'**: la conversione video e' asincrona e deve poter essere ritentata
- **Tracciare ogni decisione**: path, disk, formato di uscita sono scelte documentate
- **Supportare il code review**: ogni Action tocca un solo dominio (Video, Image, Stream, ...)
- **Governare la sicurezza**: nessun file pubblico oltre ai link firmati

## Best practices

- Documentare prima di implementare: PRD prima di codice
- Estendere XotBase: modelli da `BaseModel`
- Actions, non Services: un dominio per cartella sotto `Actions/`
- PHPStan Level max: nessun `ignoreErrors`
- Traduzioni dai file: mai label hardcoded
- Array PHP: una chiave per riga
- Tipizzare su `PathGeneratorContract`, mai sulla classe concreta

## Bad practices (mai fare)

- Mai estendere Filament direttamente
- Mai silenziare PHPStan
- Mai hardcode label
- Mai creare Services
- Mai modificare `phpstan.neon`
- Mai hardcodare un path di storage
- Mai esporre file su disco pubblico: usare signed URL

## False friends

| Termine | Sembra significare | In realta' significa |
|---|---|---|
| **Media** | File generico | Record con metadati, path e relazione al modello host |
| **MediaConvert** | Conversione | Coda/processo di conversione con stato, non il risultato |
| **TemporaryUpload** | Upload definitivo | File orfano in attesa di attach, con cleanup |
| **PathGenerator** | Generico | Implementazione di `PathGeneratorContract` |
| **Service** | Servizio generico | **Vietato** in Xot, usare `Actions` |

## Struttura directory (canonica)

- **`app/Actions/`**: `Image/`, `Video/`, `Ffmpeg/`, `Stream/`, `Subtitle/`, `S3/`,
  `CloudFront/`, `Storage/`, `TemporaryUpload/`, `Diagnostic/` + Action root
- **`app/Contracts/`**: `PathGenerator`, `PathGeneratorContract`
- **`app/Enums/AttachmentTypeEnum.php`**: `image` / `video` / `document` / `manual`
- **`app/Models/`**: `Media`, `MediaConvert`, `TemporaryUpload`
- **`app/Filament/`**: Resource + `Clusters/`, `RelationManagers/`, `Infolists/`
- **`app/Conversions/`**: generatori immagine/video (le directory `conversions/` in minuscolo sono residui)
- **`app/Support/Ffmpeg/`, `app/Exceptions/`**: supporto runtime
- **`docs/bmad/`**: questa documentazione

## Vedi anche

- [README](./README.md)
- [Quick reference](./quick-reference.md)
- [Architettura: module boundary](./architecture/module-boundary.md)
- [Epic roadmap](./epics/module-roadmap.md)
