---
title: "Architettura - Modulo Media"
module: "Media"
type: architecture
tags: [architecture, structure]
created: 2026-07-14
updated: 2026-08-04
status: draft
qmd: "architettura modulo media media"
---

# Architettura Modulo Media

## Panoramica

Il modulo Media gestisce la memorizzazione, elaborazione e distribuzione di file multimediali (immagini, video, documenti, audio) all'interno dell'applicazione Laravel Laraxot.

## Informazioni Generali

- **Namespace principale**: `Modules\Media`
- **Pacchetto Composer**: `laraxot/module_media_fila5`
- **Dipendenze principali**:
  - `php ^8.2`
  - `pbmedia/laravel-ffmpeg ^8.5` (conversione video)
  - `intervention/image *` (manipolazione immagini)
  - `Modules\Xot` (base framework)
  - `Modules\Tenant` (multi-tenancy)
  - `Modules\User` (autenticazione)

## Struttura PSR-4

```json
{
  "autoload": {
    "psr-4": {
      "Modules\\Media\\": "app/",
      "Modules\\Media\\Database\\Factories\\": "database/factories/",
      "Modules\\Media\\Database\\Seeders\\": "database/seeders/"
    }
  },
  "autoload-dev": {
    "psr-4": {
      "Modules\\Media\\Tests\\": "tests/"
    }
  }
}
```

## Architettura Logica

### Directory Principali

- **`app/`** - Codice applicativo
  - `Actions/` - QueueableActions per operazioni media (immagini, video)
  - `Models/` - Modelli Eloquent (Media, MediaConvert, TemporaryUpload, etc.)
  - `Contracts/` - Interfacce e contratti
  - `Conversions/` - Generatori di conversioni (immagini, video)
  - `Datas/` - Spatie Laravel Data DTOs
  - `Enums/` - Enumerazioni (tipi media, stati conversione)
  - `Filament/` - Componenti Filament (Resources, Pages, Actions)
  - `Http/` - Controllers, middleware, requests, Livewire components
  - `Services/` - Servizi (legacy, preferire Actions)
  - `Providers/` - Service Providers

- **`database/`** - Migrazioni e factories
  - `migrations/` - Migrazioni database (XotBaseMigration)
  - `factories/` - Factories per testing

- **`resources/`** - Assets frontend
  - `views/` - Blade templates
  - `assets/` - JS/SASS

- **`lang/`** - Traduzioni (es. `lang/it/`)

- **`tests/`** - Test suite (Pest)
  - `Feature/` - Test funzionali
  - `Unit/` - Test unitari

- **`config/`** - File di configurazione

- **`docs/`** - Documentazione (canonical bridge)

## Dipendenze dai Moduli Xot

Gerarchicamente il modulo Media dipende da:
- **Xot** (6+ utilizzi di `XotBaseMigration`, base Filament resources)
- **Tenant** (multi-tenancy)
- **User** (autenticazione)
- **UI** (componenti UI comuni)

## Funzionalità Principali

### Gestione File
- Upload di file multipli (drag-and-drop)
- Supporto multi-format (immagini, video, documenti, audio)
- Memorizzazione con isolamento tenant

### Elaborazione Media
- Ottimizzazione e compressione immagini
- Conversione video (FFmpeg)
- Generazione automatica di versioni (thumbnail, preview)
- Watermark automatico

### Streaming Video
- Streaming ottimizzato con supporto HLS/DASH
- Gestione sottotitoli

### Integrazione CDN
- Supporto per Content Delivery Network
- URL pubblico e privato

## Convenzioni

### Naming
- Modelli: singolare (Media, MediaConvert, TemporaryUpload)
- Actions: `{Verb}{Noun}Action` (es. `ConvertVideoAction`)
- Namespaces: Modules\Media\{Domain}\{Component}

### Testing
- Pest framework (no PHPUnit diretto)
- No `RefreshDatabase` - usare database dedicated `.env.testing`
- Coverage target: 80%+

## Dependency Injection

Il modulo utilizza l'inversion of control tramite:
- Constructor injection nelle Actions
- Service Provider per binding
- Interfacce nei Contracts per loose coupling

## Stato Corrente

- **Total file PHP**: 97
- **Classi/Interfacce**: 64
- **PHPStan Level**: 10 (strict typing)
- **Test Coverage**: In progress

## Vedere Anche

- README.md - Documentazione di base
- index.md - Bridge indice
- /docs/ root - Standard di documentazione globali

---

<!-- Merged from ARCHITECTURE.md, which collided with this file on case-insensitive filesystems. -->

---
title: "Architecture: Media Module"
type: architecture
tags: [module, architecture, media, storage]
created: 2026-08-04
updated: 2026-08-04
---
# Media Module: Architecture

## Purpose
Media module provides file handling, storage, and processing infrastructure for the Laraxot ecosystem. Manages uploads, transformations, and media metadata.

## Core Components

**Models:**
- `Media`: Primary media model (spatie/laravel-medialibrary)
- `MediaCollections`: Collection definitions
- `MediaItem`: Extended media metadata

**Actions:**
- `UploadMediaAction`: Primary entrypoint for file uploads
- `ProcessMediaAction`: Image/video processing pipeline
- `DeleteMediaAction`: Cleanup associated files

**Filament Resources:**
- `MediaResource`: Browse and manage media library
- `CollectionResource`: Manage media collections

## Database Schema
- `media` table: id, model_type, model_id, collection_name, name, file_name, mime_type, size, url, custom_properties

## Design Decisions
| Decision | Rationale |
|----------|-----------|
| Spatie MediaLibrary | Battle-tested, handles transformations |
| Custom collections | Separate by media type/use case |
| Lazy loading | Optimize performance for large libraries |

## Integration Points
**Depends On:** Xot module (BaseModel), Laravel Storage
**Depended On By:** Activity, Lang, PDF generation

## Quality Gates
- **PHPStan L10**: Pending verification
- **Storage**: Tested with local/S3 drivers
