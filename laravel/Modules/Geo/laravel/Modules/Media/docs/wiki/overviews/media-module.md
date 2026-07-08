---
type: overview
module: Media
sources:
  - ../../../philosophy.md
  - ../../../file-management-architecture.md
  - ../../../business-logic-overview.md
  - ../../../configuration.md
confidence: high
updated: 2026-04-15
---

# Media Module — Overview

> **Ruolo**: Gestione centralizzata di tutti i digital asset — immagini, video, documenti, upload, storage, processing, CDN.

## Responsabilità del Modulo

Il modulo Media è il **sistema di digital asset management** dell'applicazione:

- Upload sicuro di file (immagini, video, documenti, audio)
- Processing automatico: resize, crop, watermark, conversione formato, video encoding
- Storage multi-layer: locale, AWS S3, CloudFront CDN, multi-region replication
- Associazione media a qualsiasi modello via Spatie MediaLibrary (polymorphic)
- Gestione metadati (alt text, caption, tags, custom properties)
- Access control con URL firmati e rate limiting

## Stack Tecnologico

| Componente | Implementazione |
|-----------|----------------|
| Media Library | `spatie/laravel-medialibrary` |
| Video encoding | `Laravel-ffmpeg` |
| Storage | Laravel Filesystem (local + S3) |
| CDN | AWS CloudFront |
| Thumbnail | On-demand via MediaConversions |
| HTML→PDF | html2pdf integration |

## Architettura Multi-Layer

```
Upload Layer    → Temporary (session), Direct S3, Chunked, Drag&Drop
Processing Layer → Image conversions, Video transcoding, Thumbnail, Metadata
Storage Layer   → Local FS, AWS S3, CloudFront CDN, Multi-region
Access Layer    → Security policies, Signed URLs, Access logging, Rate limiting
Analytics Layer → Usage tracking, Performance metrics, Cost analysis
```

## Modelli Core

| Modello | Scopo | Note |
|---------|-------|------|
| `Media` | Asset principale | Spatie MediaLibrary record |
| `TemporaryUpload` | Upload temporaneo | Session-based, con expiry e cleanup automatico |

### TemporaryUpload → Media (Flusso)

```php
// 1. Upload temporaneo (session)
class TemporaryUpload extends BaseModel {
    // session_id, file_name, mime_type, size, disk, path, hash, expires_at
    public function convertToPermanentMedia(Model $model, string $collection = 'default'): Media
    {
        // Move temp → permanent path
        Storage::disk($this->disk)->move($this->path, $permanentPath);
        // Create Spatie media record + cleanup temp
        return $model->addMedia(...)->toMediaCollection($collection);
    }
}
```

## Conversioni Immagine

```php
// Nel modello che implementa HasMedia + InteractsWithMedia
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->width(150)->height(150)->sharpen(10);

    $this->addMediaConversion('preview')
        ->width(800)->quality(80);
}
```

## Integrazione Video (FFmpeg)

```php
use Modules\Media\Actions\Video\ConvertVideoByMediaConvertAction;

// Transcoding video in background
ConvertVideoByMediaConvertAction::execute($media, [
    'format' => 'mp4',
    'quality' => 'high',
]);
```

## Filament Integration

- `MediaRelationManager` — gestione media da pannello admin di qualsiasi resource
- `FileUpload` + custom path generator (`TemporaryUploadPathGenerator`)
- `IconMediaColumn` — colonna icona in tabelle Filament
- `VideoEntry` — infolist entry per video con player integrato

## Utilizzo Cross-Module

Per associare media a un modello in qualsiasi modulo:

```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends XotBaseModel implements HasMedia {
    use InteractsWithMedia;

    public function registerMediaCollections(): void {
        $this->addMediaCollection('images');
        $this->addMediaCollection('attachments');
    }
}
```

## Configurazione Storage

```php
// config/media-library.php
'disk_name'     => env('MEDIA_DISK', 'public'),
'conversions_disk' => env('MEDIA_CONVERSIONS_DISK', 'public'),
's3' => [
    'key'    => env('AWS_ACCESS_KEY_ID'),
    'secret' => env('AWS_SECRET_ACCESS_KEY'),
    'region' => env('AWS_DEFAULT_REGION'),
    'bucket' => env('AWS_BUCKET'),
]
```

## Architettura

- Estende `XotBaseServiceProvider` (lean service provider, domain logic nei models/actions)
- PHPStan Level 10 obbligatorio
- **DRY**: un solo modulo per tutti i media dell'app — no duplicazioni in altri moduli
- Cleanup automatico upload scaduti via `scopeExpired()`

## Cross-References

- [[../../../../../../laravel/Modules/Xot/docs/wiki/overviews/xot-module|Xot Module]] — XotBaseServiceProvider, XotBaseModel
- [[../../../../../../laravel/Modules/Fixcity/docs/wiki/overviews/fixcity-module|Fixcity Module]] — FileUpload in wizard Step 2 (immagini segnalazione)

## Raw Sources Prioritari

- `philosophy.md` — design principles, zen, domain-driven approach
- `file-management-architecture.md` — multi-layer stack, TemporaryUpload, S3
- `business-logic-overview.md` — logica upload, processing, access control
- `configuration.md` — disk, S3, conversioni
- `ffmpeg.md` — video encoding, pattern FFmpeg
- `packages.md` — dipendenze esterne
