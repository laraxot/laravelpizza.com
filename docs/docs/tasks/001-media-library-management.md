# Task 001: Implement Media Library Management System

## Description
Create comprehensive media library with file upload, processing, transformations, optimization, and CDN integration.

## Context
The Media module needs a robust media management system for handling images, videos, documents, and other media files with processing capabilities and CDN integration.

## Requirements

### Functional Requirements
- File upload (drag-drop, multiple files)
- Media library browser
- Image processing (resize, crop, filters)
- Video transcoding
- Document conversion
- File optimization
- CDN integration
- Media organization (folders, tags, collections)
- Media search and filtering
- Access control and permissions

### Technical Requirements
- Use PHP 8.3 strict typing
- PHPStan Level 10 compliance
- Laravel Filesystem
- Intervention Image for images
- FFmpeg for video
- DatabaseTransactions for tests

## Implementation Steps

### 1. Database Schema
- [ ] Create `media_files` table
  - id (uuid/ulid)
  - tenant_id
  - user_id (uploaded_by)
  - folder_id (nullable)
  - name (string)
  - original_name (string)
  - mime_type (string)
  - size (bigint)
  - disk (string)
  - path (string)
  - file_hash (string, sha256)
  - width (int, nullable)
  - height (int, nullable)
  - duration (int, nullable, for video/audio)
  - alt_text (string, nullable)
  - caption (text, nullable)
  - description (text, nullable)
  - is_public (boolean, default false)
  - metadata (json, nullable)
  - deleted_at (nullable)
  - timestamps

- [ ] Create `media_folders` table
  - id, tenant_id, parent_id (nullable), name, slug, path, is_public, metadata

- [ ] Create `media_collections` table
  - id, tenant_id, name, slug, description, is_public

- [ ] Create `media_tags` table
  - id, tenant_id, name, slug, color (nullable)

- [ ] Create `media_file_collection` pivot table
- [ ] Create `media_file_tag` pivot table
- [ ] Create `media_conversions` table
  - id, media_file_id, name, disk, path, width, height, size, mime_type, created_at

### 2. Models
- [ ] Create `MediaFile` model
- [ ] Create `MediaFolder` model
- [ ] Create `MediaCollection` model
- [ ] Create `MediaTag` model
- [ ] Create `MediaConversion` model

### 3. Upload Service
- [ ] Create `MediaUploadService`
  - `uploadFile(UploadedFile $file, array $options): MediaFile`
  - `uploadChunk(UploadedFile $chunk, string $uploadId, int $chunkIndex, int $totalChunks): array`
  - `validateFile(UploadedFile $file, array $rules): array`
  - `generateUniqueName(string $originalName): string`
  - `scanForMalware(string $path): bool`

### 4. Image Processing Service
- [ ] Create `ImageProcessingService`
  - `resizeImage(string $path, int $width, int $height): string`
  - `cropImage(string $path, int $x, int $y, int $width, int $height): string`
  - `applyFilter(string $path, string $filter): string`
  - `optimizeImage(string $path): bool`
  - `generateThumbnail(string $path, int $width, int $height): string`
  - `convertFormat(string $path, string $format): string`
  - `extractExifData(string $path): array`

### 5. Video Processing Service
- [ ] Create `VideoProcessingService`
  - `extractThumbnail(string $path, int $second = 0): string`
  - `transcodeVideo(string $path, string $format, array $options): string`
  - `optimizeVideo(string $path): bool`
  - `getVideoInfo(string $path): array`
  - `extractSubtitles(string $path): array`
  - `generatePreview(string $path): string`

### 6. Document Processing Service
- [ ] Create `DocumentProcessingService`
  - `extractText(string $path): string`
  - `generateThumbnail(string $path): string`
  - `convertToPdf(string $path): string`
  - `mergeDocuments(array $paths): string`
  - `splitDocument(string $path, array $pages): array`
  - `compressDocument(string $path): bool`

### 7. Media Library Service
- [ ] Create `MediaLibraryService`
  - `getFiles(array $filters): Collection`
  - `searchFiles(string $query): Collection`
  - `getFilesByFolder(string $folderId): Collection`
  - `getFilesByTag(string $tagId): Collection`
  - `getFilesByCollection(string $collectionId): Collection`
  - `organizeFiles(array $fileIds, string $folderId): bool`
  - `moveFiles(array $fileIds, string $targetFolderId): bool`
  - `copyFiles(array $fileIds, string $targetFolderId): array`

### 8. CDN Integration Service
- [ ] Create `CdnIntegrationService`
  - `syncToCdn(MediaFile $file): string`
  - `invalidateCdnCache(string $path): bool`
  - `getCdnUrl(string $path): string`
  - `purgeCdn(array $paths): bool`

### 9. Conversion Manager
- [ ] Create `MediaConversionManager`
  - `registerConversion(string $name, array $config): void`
  - `generateConversions(MediaFile $file): array`
  - `getConversion(string $fileId, string $conversionName): MediaConversion`
  - `deleteConversions(string $fileId): bool`

### 10. Filament Resources
- [ ] Create `MediaFileResource`
  - Media browser
  - Upload interface
  - File details
  - Edit metadata

- [ ] Create `MediaFolderResource`
  - Folder management
  - Folder tree view
  - Drag-drop organization

- [ ] Create `MediaCollectionResource`
  - Collection management
  - Add/remove files
  - Collection sharing

- [ ] Create `MediaTagResource`
  - Tag management
  - Tag colors
  - Tag analytics

- [ ] Create `MediaLibraryWidget`
  - Quick access
  - Recent uploads
  - Storage stats

### 11. API Endpoints
- [ ] `POST /api/media/upload` - Upload file
- [ ] `POST /api/media/upload-chunk` - Upload chunk
- [ ] `GET /api/media/files` - List files
- [ ] `GET /api/media/files/{id}` - Get file details
- [ ] `PUT /api/media/files/{id}` - Update file
- [ ] `DELETE /api/media/files/{id}` - Delete file
- [ ] `POST /api/media/files/{id}/convert` - Generate conversion

### 12. Actions
- [ ] Create `UploadMediaAction`
- [ ] Create `OptimizeMediaAction`
- [ ] Create `GenerateConversionsAction`
- [ ] Create `SyncToCdnAction`

### 13. Tests
- [ ] Create `MediaUploadServiceTest`
- [ ] Create `ImageProcessingServiceTest`
- [ ] Create `VideoProcessingServiceTest`
- [ ] Create `MediaLibraryServiceTest`

### 14. Documentation
- [ ] Create media library guide
- [ ] Document image processing
- [ ] Create video processing guide
- [ ] Add CDN integration guide

## Acceptance Criteria
- [ ] Files upload successfully
- [ ] Image processing works
- [ ] Video transcoding completes
- [ ] Document extraction works
- [ ] CDN sync functions
- [ ] Media organization is intuitive
- [ ] Search returns relevant results
- [ ] All tests pass with 85%+ coverage
- [ ] PHPStan Level 10 compliant

## Dependencies
- Xot module (base classes)
- CloudStorage module (storage)
- Intervention Image
- FFmpeg
- Filament 5.x (admin UI)

## Estimated Time
- Database schema: 4 hours
- Models: 3 hours
- Upload service: 5 hours
- Image processing: 6 hours
- Video processing: 5 hours
- Document processing: 4 hours
- Media library: 4 hours
- CDN integration: 4 hours
- Conversion manager: 3 hours
- Filament integration: 6 hours
- API endpoints: 3 hours
- Actions: 2 hours
- Tests: 8 hours
- Documentation: 3 hours

**Total: 60 hours (~8 days)**

## Priority
**High** - Core media functionality

## Related Tasks
- Task 002: Advanced Media Features

## Notes
- Use queues for heavy processing
- Implement chunked upload for large files
- Cache processed conversions
- Use WebP for image optimization
- Implement adaptive bitrate for videos
- Scan uploads for malware
- Implement proper access controls

---

**Status**: Pending
**Assignee**: TBD