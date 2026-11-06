# ImageSpatie / SpatieDocumentUpload: Filament Blueprint

## Component Design (BMAD + Ponytail)
- `SpatieDocumentUpload::make()` standardizes upload: `SpatieMediaLibraryFileUpload`, `disk('private')`, `preserveFilenames()`, `maxSize(10240)`, `acceptedFileTypes` includes `image/heic`, `image/webp`
- `ImageSpatie` block uses `SpatieMediaLibraryFileUpload::make('image')` with `live()`, `imagePreviewHeight('666')`, `maxSize(102400)` (100MB), `disk('local')`
- After state update: `$record->addMedia($state)->withResponsiveImages()->toMediaCollection($collectionName)`

## Mobile Upload Fix Integration
- `media-library` config: `image_driver=imagick` (required for HEIC), `max_file_size=50MB`
- PHP limits: `upload_max_filesize=20M`, `post_max_size=20M`
- Without Imagick active (`conf.d/20-imagick.ini` linked), `withResponsiveImages()` fails on iPhone HEIC

## Verification
- `php -m | grep imagick`: active
- `php artisan config:clear`: apply media-library settings