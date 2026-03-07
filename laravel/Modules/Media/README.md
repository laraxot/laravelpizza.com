# Media Module

[![Laravel 12.x](https://img.shields.io/badge/Laravel-12.x-red.svg)](https://laravel.com/)
[![Filament 5.x](https://img.shields.io/badge/Filament-5.x-blue.svg)](https://filamentphp.com/)
[![PHPStan Level 10](https://img.shields.io/badge/PHPStan-Level%2010-brightgreen.svg)](https://phpstan.org/)
[![PHP 8.3+](https://img.shields.io/badge/PHP-8.3+-blue.svg)](https://php.net)
[![Spatie Media Library](https://img.shields.io/badge/Spatie-Media%20Library-orange.svg)](https://spatie.be/docs/laravel-medialibrary)

> **Gestione media completa**: upload, conversioni video FFMpeg, streaming, responsive images, S3/CloudFront, temporary uploads con session lifecycle. Basato su Spatie Media Library.

---

## Cosa fa

Il modulo Media gestisce l'intero ciclo di vita dei file multimediali: upload temporanei con pulizia automatica, conversioni video con FFMpeg (codec, bitrate, dimensioni), streaming video, integrazione S3 e CloudFront con URL firmati, e responsive images. Estende Spatie Media Library con modelli custom e DTO tipizzati.

```php
// Upload e media library (Spatie)
$model->addMedia($file)
    ->toMediaCollection('documents');

// Conversione video con DTO
$convertData = ConvertData::from([
    'format' => 'mp4',
    'codec_video' => 'X264',
    'bitrate' => 1000,
    'width' => 1920,
    'height' => 1080,
]);
app(ConvertVideoByConvertDataAction::class)->execute($media, $convertData);

// URL firmato CloudFront
$signedUrl = app(GetCloudFrontSignedUrlAction::class)->execute($media);

// Screenshot da video
$screenshot = app(GetVideoScreenshotAction::class)->execute($media, $atSecond);
```

---

## Architettura

```
File Upload (Filament / API)
    |
    v
TemporaryUpload (session-based, auto-pruning)
    |
    v
Media (Spatie Media Library extended)
    |
    +-- Conversioni Video (FFMpeg)
    |     +-- ConvertData DTO (codec, bitrate, dimensioni)
    |     +-- MediaConvert model (tracking progresso %)
    |     +-- Output: MP4 X264
    |
    +-- Storage
    |     +-- Local disk
    |     +-- S3 (upload, check, delete, info)
    |     +-- CloudFront (URL firmati)
    |
    +-- Responsive Images (Spatie)
    +-- Video Streaming (VideoStream service)
    +-- Subtitles (SubtitleService)
```

---

## Modelli (3)

| Modello | Funzione |
|---------|----------|
| **Media** | Estende Spatie Media: file storage, conversioni, responsive images, EXIF metadata |
| **MediaConvert** | Tracking conversioni video: codec, bitrate, dimensioni, progresso %, tempo esecuzione |
| **TemporaryUpload** | Upload temporanei con session lifecycle e auto-pruning (MassPrunable) |

---

## Azioni (17)

### Upload & Attachments

| Action | Funzione |
|--------|----------|
| **GetAttachmentsSchemaAction** | Genera schema Filament FileUpload con validazione (PDF, DOCX, 10MB) |
| **SaveAttachmentsAction** | Persiste file nella media library con cleanup temp |
| **AttachMediaAction** | Attachment generico (Queueable) |

### Video (5)

| Action | Funzione |
|--------|----------|
| **ConvertVideoAction** | Conversione FFMpeg a MP4 X264 (1000 kbps) |
| **ConvertVideoByConvertDataAction** | Conversione parametrizzata via ConvertData DTO |
| **ConvertVideoByMediaConvertAction** | Conversione con tracking via MediaConvert model |
| **GetVideoDurationAction** | Estrae durata video |
| **GetVideoScreenshotAction** | Genera thumbnail/frame capture |

### S3 (5)

| Action | Funzione |
|--------|----------|
| **UploadFileAction** | Upload file su S3 |
| **CheckFileExistsAction** | Verifica esistenza file su S3 |
| **GetFileInfoAction** | Metadata file da S3 |
| **DeleteFileAction** | Eliminazione file da S3 |
| **BaseS3Action** | Base class per operazioni S3 |

### CloudFront & Images

| Action | Funzione |
|--------|----------|
| **GetCloudFrontSignedUrlAction** | URL firmati AWS CloudFront |
| **SvgExistsAction** | Verifica esistenza SVG |

---

## DTO (Spatie Data)

| DTO | Funzione |
|-----|----------|
| **ConvertData** | Parametri FFMpeg: disk, format, codec_video/audio, preset, bitrate, width, height, threads, speed |
| **CloudFrontData** | Configurazione CloudFront: region, base_url, private_key, key_pair_id (singleton) |

---

## Filament Integration

| Resource | Funzione |
|----------|----------|
| **MediaResource** | CRUD media library con upload, metadata, conversione |
| **MediaConvertResource** | Gestione job conversione video |
| **TemporaryUploadResource** | Gestione upload temporanei |

| Componente | Funzione |
|------------|----------|
| **ConvertWidget** | Widget progresso conversioni |
| **VideoEntry** | Infolist component per video player |
| **IconMediaColumn** | Colonna tabella con icona media |
| **CloudFrontIconMediaColumn** | Colonna con URL CloudFront |
| **ConvertAction** | Table action per conversione |
| **MediaRelationManager** | Relation manager per HasMedia |

| Pagina | Funzione |
|--------|----------|
| **Dashboard** | Overview modulo media |
| **S3Test** | Test connettivita S3 |
| **ConvertMedia** | Interfaccia conversione video |

---

## Servizi

| Service | Funzione |
|---------|----------|
| **VideoStream** | Streaming video con range requests |
| **SubtitleService** | Gestione sottotitoli video |

---

## Enum

| Enum | Valori |
|------|--------|
| **AttachmentTypeEnum** | IMAGE, VIDEO, DOCUMENT, MANUAL |

---

## Artisan Command

```bash
# Accoda conversione video
php artisan media:convert-video {media_id}
```

---

## Integrazione con altri moduli

```
Media <── Cms       (allegati pagine/sezioni)
Media <── healthcare_app   (allegati survey, immagini report)
Media <── User      (avatar, documenti utente)
Media <── Notify    (allegati email)
Media ──> CloudStorage (storage S3/CloudFront)
Media ──> Job       (conversioni video in coda)
Media ──> Activity  (audit trail operazioni file)
```

---

## Quick Start

```bash
php artisan module:enable Media
php artisan migrate

# Configurare S3 in .env (opzionale)
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=
AWS_BUCKET=

# FFMpeg per conversioni video
sudo apt install ffmpeg
```

---

## Metriche

| Metrica | Valore |
|---------|--------|
| **Modelli** | 3 |
| **Azioni** | 17 |
| **Resource Filament** | 3 |
| **Componenti Filament** | 6 (widget, columns, actions, relation manager) |
| **DTO** | 2 (ConvertData, CloudFrontData) |
| **Servizi** | 2 (VideoStream, SubtitleService) |
| **Enum** | 1 (AttachmentTypeEnum) |
| **Artisan Commands** | 1 |
| **PHPStan Level** | 10 |

---

## Documentazione

| Guida | Link |
|-------|------|
| **Indice** | [docs/00-index.md](docs/00-index.md) |
| **Architettura** | [docs/architecture/structure.md](docs/architecture/structure.md) |
| **Configurazione** | [docs/configuration.md](docs/configuration.md) |
| **Core Functionality** | [docs/core-functionality.md](docs/core-functionality.md) |
| **Best Practices** | [docs/best-practices.md](docs/best-practices.md) |

---

**Module Type**: File & Media Management
**Architecture**: Spatie Media Library, FFMpeg conversions, S3/CloudFront, session-based uploads
**Quality**: PHPStan Level 10

*Gestione media enterprise: da upload temporaneo a streaming video, da S3 a CloudFront, con conversioni FFMpeg tracciate.*
