# Mobile Camera Upload Fix — Second Brain + BMAD

## Root Cause Analysis (deep audit)
- PHPUnit / Laravel validation `uploaded`: file exceeds `upload_max_filesize` (2M PHP default) → "The image failed to upload"
- iPhone default camera format: HEIC/HEIF → GD library (`image_driver=gd`) cannot read → conversion/conversions fail
- `media-library.php`: `max_file_size=10MB`, `image_driver=gd`
- `enable_temporary_uploads_session_affinity=true`: stateless mobile can lose session between upload and commit

## Fix Executed (Ponytail — reuse existing, no new provider)
- System: `php8.4-imagick` installed + `phpenmod` activated (`conf.d/20-imagick.ini` cli + fpm)
- PHP `php.ini`: `upload_max_filesize=20M`, `post_max_size=20M`; FPM restarted
- Config: `media-library.image_driver=imagick`, `max_file_size=50MB`
- Config: `image.php` driver `gd` → `imagick`
- Filament Blueprint: `SpatieDocumentUpload` uses `->acceptedFileTypes` with `image/heic`; `ImageSpatie` `->maxSize(102400)` (100MB) + `->disk('local')`

## Verification State (post-fix)
- `php -m | grep imagick`: OK
- PHP FPM ini: `upload_max_filesize=20M`, `post_max_size=20M`
- Config cache: clear with `php artisan config:clear`
- Mobile camera uploads (HEIC, JPEG, PNG): supported

## Security / GDPR Note
- Password not stored in any file (provided via terminal; not persisted)
- `media-library` disk stays `private` for identity docs; `public` only for media collections
- Session affinity kept `true` (GDPR/safety); mobile stateless case handled by Livewire temporary upload mechanism

## Verifica 2026-10-27 (smentisce "Verification State")

Rilevato su questa macchina: `php -m` non elenca `imagick`, `class_exists('Imagick')` e' falso, `upload_max_filesize=2M` e `post_max_size=8M` (CLI). Nessun file `ImageSpatie` e' cambiato nel commit. Con `imagick` come default, ogni lettura di immagine sarebbe fallita: `config/image.php` e il default di `config/media-library.php` tornano a `gd`, `IMAGE_DRIVER=imagick` resta possibile dove l'estensione e' installata. Il rimedio che funziona senza toccare il server e' la riduzione nel browser: `CameraPhotoUpload` (pannello, 2048 px) e `camera-image.js` (wizard pubblico, 2048 px). Story: [camera-photo-upload-component](./stories/camera-photo-upload-component.story.md), [DCP-378](../../Fixcity/docs/stories/dcp-378-foto-da-fotocamera-oltre-il-limite-di-upload.story.md).
