---
issues: []
discussions: []
title: "Troubleshooting"
module: "Media"
type: concept
tags: [troubleshooting]
created: 2026-07-14
updated: 2026-07-14
qmd: "troubleshooting"
related:
  - "./webm.md"
status: draft
---
# Troubleshooting

---

<!-- Merged from TROUBLESHOOTING.md, which collided with this file on case-insensitive filesystems. -->

---
module: "Media"
type: operations
tags: [troubleshooting, errors, debugging]
last_updated: 2026-07-28
---

# Troubleshooting Guide: Media Module

**Last updated:** 2026-07-28

Systematic error resolution for file upload, storage, processing, and permissions issues.

---

## 1. File Upload Errors

### Error Pattern: "MIME type validation failed" or "413 Payload Too Large"

**Causes:**
- File exceeds `max:` size in validation rule
- Server upload limit (php.ini `upload_max_filesize`)
- Request body limit (nginx `client_max_body_size`)
- Incorrect file extension for actual MIME type

**Solution:**

1. **Check validation rules:**
   ```php
   // In your form request
   public function rules(): array
   {
       return [
           'media' => 'required|image|mimes:jpg,png,webp|max:10240', // 10MB
       ];
   }
   ```

2. **Verify server limits:**
   ```bash
   # php.ini settings
   upload_max_filesize = 100M
   post_max_size = 120M
   
   # nginx (if using)
   client_max_body_size 100M;
   
   # Restart services
   sudo systemctl restart php-fpm nginx
   ```

3. **Check file MIME type:**
   ```bash
   # Verify actual format matches extension
   file -i /path/to/file
   
   # Expected output: image/jpeg or image/png
   ```

4. **Test with curl:**
   ```bash
   curl -F "media=@test.jpg" http://localhost/media/upload
   ```

**Prevention:**
- Use `mimes:jpg,png` not `jpeg,png` (check MIME database)
- Set realistic size limits for your use case (images ≤ 10MB, videos ≤ 500MB)
- Log upload validation failures for audit trail
- Return detailed validation errors to frontend

**Reference:** [Validation Rules](#validationrules)

---

### Error Pattern: "The uploaded file could not be processed" or "Exception thrown"

**Causes:**
- Corrupted file (partial upload, network interrupt)
- Unsupported format (e.g., TIFF, BMP without handler)
- Missing or broken image/video metadata
- Insufficient server disk space

**Solution:**

1. **Enable debug logging:**
   ```php
   // In config/media.php or .env
   MEDIA_DEBUG=true
   LOG_CHANNEL=single
   ```

2. **Check disk space:**
   ```bash
   df -h /var/www/storage
   # Ensure > 10GB free for processing
   ```

3. **Validate file integrity:**
   ```php
   // In your validation
   public function rules(): array
   {
       return [
           'media' => [
               'required',
               'image',
               'mimes:jpg,png',
               function ($attribute, $value, $fail) {
                   try {
                       Image::read($value->getRealPath());
                   } catch (Exception $e) {
                       $fail("File is corrupted or invalid: {$e->getMessage()}");
                   }
               },
           ],
       ];
   }
   ```

4. **Test with sample file:**
   ```bash
   # Re-upload same file, different format
   # If WebP works but JPEG fails, likely JPEG-specific issue
   ```

**Prevention:**
- Implement chunk-based uploads for large files
- Validate files immediately after upload (before queue)
- Retry logic with exponential backoff for transient failures
- Store error details in logs with file hash for debugging

---

## 2. Storage & File Access Errors

### Error Pattern: "Could not write to disk" or "Permission denied"

**Causes:**
- Storage directory not writable (wrong permissions)
- Wrong disk configured in `config/filesystems.php`
- Disk driver mismatch (local vs S3 vs Minio)
- Running as wrong user (www-data vs root)

**Solution:**

1. **Fix directory permissions:**
   ```bash
   # Ensure storage/app is writable
   sudo chown -R www-data:www-data /var/www/storage
   sudo chmod -R 755 /var/www/storage
   sudo chmod -R 775 /var/www/storage/app/uploads
   
   # If using S3, verify IAM role permissions
   aws iam get-user-policy --user-name laravel-app --policy-name s3-media
   ```

2. **Verify disk configuration:**
   ```php
   // config/filesystems.php
   'disks' => [
       'local' => [
           'driver' => 'local',
           'root' => storage_path('app'),
       ],
       'public' => [
           'driver' => 'local',
           'root' => storage_path('app/public'),
           'url' => env('APP_URL') . '/storage',
       ],
       's3' => [
           'driver' => 's3',
           'key' => env('AWS_ACCESS_KEY_ID'),
           'secret' => env('AWS_SECRET_ACCESS_KEY'),
           'region' => env('AWS_DEFAULT_REGION'),
           'bucket' => env('AWS_BUCKET'),
       ],
   ];
   ```

3. **Test disk access:**
   ```php
   // In tinker
   Storage::disk('public')->put('test.txt', 'test');
   Storage::disk('s3')->exists('uploads/test.jpg');
   ```

**Prevention:**
- Store permission setup in deployment scripts (Ansible, Docker)
- Test disk access in health check endpoint
- Log storage errors with disk name and path for debugging
- Use different service accounts for each environment (dev/staging/prod)

---

### Error Pattern: "File not found" (404) when accessing uploaded media

**Causes:**
- Storage path mismatch in URL generation
- File deleted or storage directory moved
- Symlink missing for public disk
- Wrong disk configured for retrieval

**Solution:**

1. **Regenerate symbolic link:**
   ```bash
   # Laravel storage:link creates public/storage → storage/app/public
   php artisan storage:link
   
   # Verify symlink exists
   ls -la public/storage
   ```

2. **Check URL generation:**
   ```php
   // In your model or view
   echo $media->url;
   // Should output: /storage/uploads/xyz123.jpg
   
   // If using S3:
   echo Storage::disk('s3')->url('uploads/xyz123.jpg');
   // Should output: https://bucket.s3.amazonaws.com/uploads/xyz123.jpg
   ```

3. **Verify file exists on disk:**
   ```bash
   # Local storage
   ls -la /var/www/storage/app/public/uploads/xyz123.jpg
   
   # S3
   aws s3 ls s3://bucket/uploads/xyz123.jpg
   ```

**Prevention:**
- Store absolute paths in database (migration using `string` not `text`)
- Implement file existence check in model accessor
- Log missing files with error context for audit
- Add periodic cleanup task to remove orphaned files

---

## 3. Validation & File Type Errors

### Error Pattern: "File extension not allowed" or MIME type mismatch

**Causes:**
- Server MIME database outdated
- File extension doesn't match actual format
- Validation rule too restrictive
- Browser sending wrong Content-Type header

**Solution:**

1. **Update MIME database:**
   ```bash
   # Rebuild system MIME database
   sudo update-mime-database /usr/share/mime
   
   # Check MIME for specific file
   file -i /path/to/file
   ```

2. **Adjust validation rules:**
   ```php
   public function rules(): array
   {
       return [
           'media' => [
               'required',
               'image',
               'mimes:jpg,jpeg,png,webp,gif', // Accept common formats
               'max:10240', // 10MB
           ],
       ];
   }
   ```

3. **Implement custom MIME validation:**
   ```php
   Rule::file()->image()->mimes('jpeg', 'png', 'webp')->max(10 * 1024)
   ```

**Prevention:**
- Use `finfo_file()` instead of file extension alone
- Document supported formats in API docs
- Return allowed formats in validation error message
- Periodically audit actual vs expected MIME types in database

---

## 4. FFmpeg & Video Processing Errors

### Error Pattern: "ffmpeg: command not found" or "EncodingException"

**Causes:**
- FFmpeg not installed on server
- FFmpeg PATH not accessible to PHP process
- Incorrect codec/format specified
- Video file corrupted or unsupported format

**Solution:**

1. **Install FFmpeg:**
   ```bash
   # Ubuntu/Debian
   sudo apt-get update
   sudo apt-get install ffmpeg
   
   # Verify installation
   ffmpeg -version
   which ffmpeg
   ```

2. **Configure PATH for PHP:**
   ```php
   // In config/media.php
   'ffmpeg' => [
       'ffmpeg_path' => '/usr/bin/ffmpeg',
       'ffprobe_path' => '/usr/bin/ffprobe',
       'binaries' => [
           'ffmpeg.binaries' => '/usr/bin/ffmpeg',
           'ffprobe.binaries' => '/usr/bin/ffprobe',
       ],
   ];
   ```

3. **Debug encoding errors:**
   ```php
   try {
       FFMpeg::fromDisk('public')
           ->open('input.mp4')
           ->export()
           ->inFormat(new X264)
           ->save('output.mp4');
   } catch (EncodingException $e) {
       Log::error('FFmpeg Error', [
           'command' => $e->getCommand(),
           'output' => $e->getErrorOutput(),
           'exit_code' => $e->getExitCode(),
       ]);
   }
   ```

**Prevention:**
- Test FFmpeg on server before deploying app
- Log full EncodingException context (command, output, timing)
- Implement retry logic for transient encoding failures
- Set reasonable timeouts for video processing (per format)

---

### Error Pattern: "Unsupported format" or "Invalid input"

**Causes:**
- Video codec not supported (e.g., H.265 without libx265)
- Audio stream compatibility issue
- Container format mismatch
- Metadata corruption

**Solution:**

1. **Inspect video format:**
   ```bash
   ffprobe -v error -show_format -show_streams input.mp4
   
   # Look for codec_name, codec_type
   # Expected: video codec (h264, h265), audio codec (aac, mp3)
   ```

2. **Test conversion with fallback format:**
   ```php
   // Try multiple formats with fallback
   $formats = ['X264', 'WebM', 'CopyFormat'];
   
   foreach ($formats as $format) {
       try {
           FFMpeg::fromDisk('public')
               ->open('input.mp4')
               ->export()
               ->inFormat(new $format())
               ->save("output.{$ext}");
           break; // Success
       } catch (EncodingException $e) {
           Log::warning("Format {$format} failed, trying next");
       }
   }
   ```

**Prevention:**
- Document supported input/output codecs
- Implement codec detection in pre-processing
- Use CopyFormat when possible to avoid re-encoding
- Set bitrate limits to prevent huge output files

---

## 5. Permissions & Authentication Errors

### Error Pattern: "Unauthorized" (403) when accessing private media

**Causes:**
- User doesn't have permission to view file
- Storage policy not implemented
- Signed URL expired
- S3 bucket policy misconfigured

**Solution:**

1. **Implement storage policy:**
   ```php
   // app/Policies/MediaPolicy.php
   public function view(User $user, Media $media): bool
   {
       return $user->id === $media->user_id || $user->isAdmin();
   }
   ```

2. **Use in model accessor:**
   ```php
   // app/Models/Media.php
   public function getUrlAttribute(): string
   {
       if (auth()->user() && auth()->user()->can('view', $this)) {
           if ($this->disk === 's3') {
               return Storage::disk('s3')->temporaryUrl(
                   $this->path,
                   now()->addHours(24)
               );
           }
           return Storage::url($this->path);
       }
       return null;
   }
   ```

3. **Verify S3 bucket policy:**
   ```json
   {
       "Version": "2012-10-17",
       "Statement": [
           {
               "Effect": "Allow",
               "Principal": {"AWS": "arn:aws:iam::ACCOUNT:role/laravel-app"},
               "Action": ["s3:GetObject", "s3:PutObject"],
               "Resource": "arn:aws:s3:::bucket-name/*"
           }
       ]
   }
   ```

**Prevention:**
- Always gate file access through policy checks
- Use temporary URLs for S3 (not permanent public access)
- Audit access logs monthly
- Implement rate limiting on download endpoints

---

## 6. Image Processing & Conversion Errors

### Error Pattern: "Could not process image" or "Intervention Image exception"

**Causes:**
- Image library (GD or ImageMagick) not installed
- Unsupported image format
- Insufficient memory for large image
- Corrupt image metadata

**Solution:**

1. **Install image libraries:**
   ```bash
   # GD (lightweight, recommended)
   sudo apt-get install php8.2-gd
   
   # Or ImageMagick (more features)
   sudo apt-get install php8.2-imagick
   
   # Verify in php.ini
   php -i | grep -i gd
   php -i | grep -i imagick
   ```

2. **Increase memory limit for processing:**
   ```php
   // In your action
   ini_set('memory_limit', '512M');
   
   // Or in .env
   MEMORY_LIMIT=512M
   ```

3. **Debug image processing:**
   ```php
   try {
       $image = Image::read($filePath);
       $image->scaleDown(width: 2000);
       $image->save($outputPath);
   } catch (Exception $e) {
       Log::error('Image Processing Failed', [
           'file' => $filePath,
           'error' => $e->getMessage(),
           'memory_used' => memory_get_peak_usage(true),
       ]);
   }
   ```

**Prevention:**
- Test image processing with sample files of various sizes
- Monitor memory usage during batch operations
- Implement chunked processing for large batches
- Set PHP memory limit higher than largest expected image

---

## Quick Reference: Error Codes

| Code | Meaning | Typical Cause | Check |
|------|---------|--------------|-------|
| 413 | Payload Too Large | Upload > server limit | php.ini, nginx config |
| 422 | Validation Failed | MIME type, size | Validation rules |
| 500 | Internal Server Error | Storage write, FFmpeg | PHP error logs |
| 503 | Service Unavailable | Queue failed, no FFmpeg | Background job logs |
| 507 | Insufficient Storage | Disk full | `df -h` |

---

## Debug Checklist

- [ ] Enable `APP_DEBUG=true` in .env (dev only)
- [ ] Check `storage/logs/laravel.log` for full exception traces
- [ ] Verify permissions: `ls -la` on storage directories
- [ ] Test with curl: `curl -F "media=@file" http://localhost/upload`
- [ ] Inspect headers: `curl -I http://localhost/media/xyz.jpg`
- [ ] Check database: `SELECT * FROM medias WHERE path LIKE '%.jpg'`
- [ ] Monitor queue: `php artisan queue:work --timeout=600`
- [ ] Profile with XDebug: `php -d xdebug.mode=profile`

---

**Related:** [Patterns](./PATTERNS.md) | [Architecture](./architecture.md) | [Performance](./performance-optimization.md)
---
# Troubleshooting
