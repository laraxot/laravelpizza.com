---
qmd: "ARCHITECTURE"
issues: []
discussions: []
title: "Architecture: Media Module"
type: architecture
tags: [module, architecture, media, storage]
created: 2026-08-04
updated: 2026-08-04
status: stale
---

> Nota 2026-10-14 (docs-audit): Cita Action, modelli e Resource inesistenti in app/ (UploadMediaAction, ProcessMediaAction, DeleteMediaAction, MediaItem, CollectionResource); verificato 2026-10-14. Riferimento: README.md e 00-INDEX.md del modulo. Contenuto non riscritto, verificare prima di usarlo.

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
