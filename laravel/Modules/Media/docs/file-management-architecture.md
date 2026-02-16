# Media Module - File Management Architecture

## 🎯 Module Overview

Il modulo Media è il sistema centrale per la gestione di file, immagini, video e media assets nell'applicazione. Fornisce upload sicuro, processing automatico, storage distribuito (locale/S3), conversioni on-demand, e gestione avanzata di attachment con metadata completi.

## 🏗️ Core Architecture

### Multi-Layer Media System
```
Media Management Stack
├── Upload Layer
│   ├── Temporary Uploads (Session-based)
│   ├── Direct S3 Uploads
│   ├── Chunked Uploads (Large Files)
│   └── Drag & Drop Interface
├── Processing Layer
│   ├── Image Conversions
│   ├── Video Transcoding
│   ├── Thumbnail Generation
│   └── Metadata Extraction
├── Storage Layer
│   ├── Local Filesystem
│   ├── AWS S3
│   ├── CloudFront CDN
│   └── Multi-Region Replication
├── Access Layer
│   ├── Security Policies
│   ├── Signed URLs
│   ├── Access Logging
│   └── Rate Limiting
└── Analytics Layer
    ├── Usage Tracking
    ├── Performance Metrics
    ├── Cost Analysis
    └── Storage Optimization
```

## 📁 File Upload System

### Temporary Upload System
```php
// Secure temporary file handling
class TemporaryUpload extends BaseModel
{
    protected $fillable = [
        'session_id', 'file_name', 'mime_type', 'size',
        'disk', 'path', 'hash', 'metadata', 'expires_at'
    ];

    protected function casts(): array
    {
        return [
            'metadata' => 'json',
            'expires_at' => 'datetime',
            'uploaded_at' => 'datetime',
        ];
    }

    // Automatic cleanup of expired uploads
    public function scopeExpired(Builder $query): Builder
    {
        return $query->where('expires_at', '<', now());
    }

    // Convert temporary upload to permanent media
    public function convertToPermanentMedia(Model $model, string $collection = 'default'): Media
    {
        // Move file from temporary to permanent storage
        $permanentPath = $this->generatePermanentPath($model, $collection);
        Storage::disk($this->disk)->move($this->path, $permanentPath);

        // Create permanent media record
        $media = $model->addMedia(Storage::disk($this->disk)->path($permanentPath))
            ->usingName($this->file_name)
            ->usingFileName($this->generateSafeFileName())
            ->withCustomProperties($this->metadata ?? [])
            ->toMediaCollection($collection);

        // Clean up temporary record
        $this->delete();

        return $media;
    }
}

// Advanced upload service
class FileUploadService
{
    public function __construct(
        private readonly StorageManager $storageManager,
        private readonly SecurityService $securityService,
        private readonly ConversionService $conversionService
    ) {}

    public function uploadTemporary(UploadedFile $file, array $options = []): TemporaryUpload
    {
        // Security validation
        $this->validateFileUpload($file, $options);

        // Generate secure paths and names
        $sessionId = session()->getId();
        $hash = hash_file('sha256', $file->getRealPath());
        $safeName = $this->generateSafeFileName($file);
        $path = $this->generateTemporaryPath($sessionId, $safeName);

        // Store file
        $disk = $options['disk'] ?? config('media.temporary_disk', 'local');
        $storedPath = $file->storeAs(dirname($path), basename($path), $disk);

        // Extract metadata
        $metadata = $this->extractMetadata($file);

        // Create temporary record
        return TemporaryUpload::create([
            'session_id' => $sessionId,
            'file_name' => $file->getClientOriginalName(),
            'safe_name' => $safeName,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => $disk,
            'path' => $storedPath,
            'hash' => $hash,
            'metadata' => $metadata,
            'expires_at' => now()->addHours(config('media.temporary_ttl', 24)),
        ]);
    }

    public function uploadDirect(UploadedFile $file, Model $model, string $collection = 'default'): Media
    {
        // Security and validation
        $this->validateFileUpload($file, ['direct' => true]);

        // Direct upload to permanent storage
        $mediaAdder = $model->addMediaFromRequest('file');

        if ($this->shouldConvert($file)) {
            $mediaAdder->performOnConversions(function (ConversionConfiguration $conversion) {
                $conversion->quality(85)->optimize();
            });
        }

        return $mediaAdder->toMediaCollection($collection);
    }

    private function validateFileUpload(UploadedFile $file, array $options = []): void
    {
        // File size validation
        $maxSize = $options['max_size'] ?? config('media.max_file_size', 10 * 1024 * 1024);
        if ($file->getSize() > $maxSize) {
            throw new FileTooLargeException("File size exceeds maximum allowed size of {$maxSize} bytes");
        }

        // MIME type validation
        $allowedMimes = $options['allowed_mimes'] ?? config('media.allowed_mime_types', []);
        if (!empty($allowedMimes) && !in_array($file->getMimeType(), $allowedMimes)) {
            throw new InvalidMimeTypeException("MIME type {$file->getMimeType()} is not allowed");
        }

        // Virus scanning (if enabled)
        if (config('media.virus_scanning_enabled', false)) {
            $this->securityService->scanForViruses($file);
        }

        // Content validation (check file headers)
        $this->securityService->validateFileContent($file);
    }
}
```

### Direct S3 Upload System
```php
// S3 direct upload for large files
class S3DirectUploadService
{
    public function generatePresignedUrl(array $parameters): array
    {
        $bucket = config('filesystems.disks.s3.bucket');
        $region = config('filesystems.disks.s3.region');
        $key = $this->generateSecureKey($parameters);

        $s3Client = new S3Client([
            'version' => 'latest',
            'region' => $region,
            'credentials' => [
                'key' => config('filesystems.disks.s3.key'),
                'secret' => config('filesystems.disks.s3.secret'),
            ],
        ]);

        $cmd = $s3Client->getCommand('PutObject', [
            'Bucket' => $bucket,
            'Key' => $key,
            'ContentType' => $parameters['content_type'],
            'ContentLength' => $parameters['file_size'],
            'Metadata' => [
                'uploaded-by' => auth()->id(),
                'session-id' => session()->getId(),
                'upload-timestamp' => now()->toISOString(),
            ],
        ]);

        $presignedUrl = $s3Client->createPresignedRequest($cmd, '+20 minutes');

        return [
            'url' => (string) $presignedUrl->getUri(),
            'key' => $key,
            'bucket' => $bucket,
            'expires_at' => now()->addMinutes(20)->toISOString(),
            'fields' => [
                'Content-Type' => $parameters['content_type'],
                'Content-Length' => $parameters['file_size'],
            ],
        ];
    }

    public function confirmUpload(string $key, array $metadata = []): Media
    {
        // Verify file exists in S3
        $s3Client = $this->getS3Client();

        try {
            $result = $s3Client->headObject([
                'Bucket' => config('filesystems.disks.s3.bucket'),
                'Key' => $key,
            ]);

            // Create media record
            $media = new Media([
                'file_name' => basename($key),
                'path' => $key,
                'disk' => 's3',
                'mime_type' => $result['ContentType'],
                'size' => $result['ContentLength'],
                'metadata' => array_merge($metadata, [
                    's3_etag' => $result['ETag'],
                    's3_last_modified' => $result['LastModified']->toISOString(),
                ]),
                'uploaded_at' => now(),
            ]);

            $media->save();

            // Queue post-processing if needed
            if ($this->shouldProcessAfterUpload($media)) {
                dispatch(new ProcessMediaJob($media));
            }

            return $media;

        } catch (S3Exception $e) {
            throw new MediaNotFoundException("File not found in S3: {$key}");
        }
    }
}
```

## 🖼️ Image & Video Processing

### Advanced Media Conversions
```php
// Media conversion system with Spatie integration
class MediaConversionService
{
    public function registerConversions(Media $media): void
    {
        $media->addMediaConversion('thumb')
            ->width(300)
            ->height(300)
            ->quality(85)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');

        $media->addMediaConversion('medium')
            ->width(800)
            ->height(600)
            ->quality(90)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');

        $media->addMediaConversion('large')
            ->width(1920)
            ->height(1080)
            ->quality(95)
            ->format('webp')
            ->optimize()
            ->performOnCollections('images');

        // Video conversions
        if ($media->mime_type && str_starts_with($media->mime_type, 'video/')) {
            $this->registerVideoConversions($media);
        }
    }

    private function registerVideoConversions(Media $media): void
    {
        // Video thumbnail
        $media->addMediaConversion('video-thumb')
            ->extractVideoFrameAtSecond(5)
            ->width(640)
            ->height(480)
            ->quality(85)
            ->format('jpg');

        // Video preview (animated GIF)
        $media->addMediaConversion('video-preview')
            ->extractVideoFrameAtSecond(5, 3) // 3 frames starting at 5 seconds
            ->width(320)
            ->height(240)
            ->format('gif');

        // Compressed video versions
        $media->addMediaConversion('video-720p')
            ->width(1280)
            ->height(720)
            ->videoCodec('libx264')
            ->audioCodec('aac')
            ->format('mp4');

        $media->addMediaConversion('video-480p')
            ->width(854)
            ->height(480)
            ->videoCodec('libx264')
            ->audioCodec('aac')
            ->format('mp4');
    }

    public function convertImage(Media $media, string $conversionName, array $options = []): string
    {
        $conversion = $media->getMediaConversion($conversionName);

        if (!$conversion) {
            throw new ConversionNotFoundException("Conversion '{$conversionName}' not found for media {$media->id}");
        }

        // Check if conversion already exists
        if ($media->hasGeneratedConversion($conversionName)) {
            return $media->getUrl($conversionName);
        }

        // Queue conversion job for large files
        if ($media->size > config('media.sync_conversion_threshold', 5 * 1024 * 1024)) {
            dispatch(new ConvertMediaJob($media, $conversionName, $options));
            return $media->getUrl(); // Return original while converting
        }

        // Synchronous conversion for small files
        $media->performConversions();
        return $media->getUrl($conversionName);
    }
}

// Advanced image manipulation
class ImageProcessingService
{
    public function applyWatermark(Media $media, array $watermarkConfig): Media
    {
        $conversionName = 'watermarked';

        $media->addMediaConversion($conversionName)
            ->watermark($watermarkConfig['path'])
            ->watermarkOpacity($watermarkConfig['opacity'] ?? 50)
            ->watermarkPosition($watermarkConfig['position'] ?? 'bottom-right')
            ->watermarkPadding($watermarkConfig['padding'] ?? 10)
            ->quality($watermarkConfig['quality'] ?? 90);

        $media->performConversions();

        return $media;
    }

    public function cropImage(Media $media, int $width, int $height, int $x = 0, int $y = 0): Media
    {
        $conversionName = "cropped_{$width}x{$height}";

        $media->addMediaConversion($conversionName)
            ->crop($width, $height, $x, $y)
            ->quality(90);

        $media->performConversions();

        return $media;
    }

    public function resizeImage(Media $media, int $width, int $height, bool $maintainAspectRatio = true): Media
    {
        $conversionName = "resized_{$width}x{$height}";

        $conversion = $media->addMediaConversion($conversionName)
            ->quality(90);

        if ($maintainAspectRatio) {
            $conversion->fit(Manipulations::FIT_CONTAIN, $width, $height);
        } else {
            $conversion->width($width)->height($height);
        }

        $media->performConversions();

        return $media;
    }
}
```

### Video Processing System
```php
// Advanced video processing
class VideoProcessingService
{
    public function extractSubtitles(Media $videoMedia): Collection
    {
        if (!$this->isVideo($videoMedia)) {
            throw new InvalidMediaTypeException('Media is not a video file');
        }

        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoMedia->getPath());

        $subtitles = collect();

        // Extract embedded subtitles
        foreach ($video->getStreams()->subtitles() as $index => $subtitle) {
            $subtitlePath = $this->extractSubtitleTrack($video, $index);

            $subtitleMedia = $videoMedia->model->addMedia($subtitlePath)
                ->usingName("Subtitles Track {$index}")
                ->withCustomProperties([
                    'subtitle_index' => $index,
                    'language' => $subtitle->get('language'),
                    'codec' => $subtitle->get('codec_name'),
                ])
                ->toMediaCollection('subtitles');

            $subtitles->push($subtitleMedia);
        }

        return $subtitles;
    }

    public function generateVideoPreview(Media $videoMedia, int $durationSeconds = 10): Media
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoMedia->getPath());

        // Extract frames at regular intervals
        $frames = [];
        $interval = $durationSeconds / 10; // 10 frames

        for ($i = 0; $i < 10; $i++) {
            $timeCode = $i * $interval;
            $framePath = $this->extractFrame($video, $timeCode);
            $frames[] = $framePath;
        }

        // Create animated GIF from frames
        $gifPath = $this->createAnimatedGif($frames);

        // Add as media conversion
        return $videoMedia->model->addMedia($gifPath)
            ->usingName($videoMedia->name . ' - Preview')
            ->withCustomProperties([
                'type' => 'video_preview',
                'duration' => $durationSeconds,
                'parent_media_id' => $videoMedia->id,
            ])
            ->toMediaCollection('previews');
    }

    public function transcodeVideo(Media $videoMedia, string $format, array $options = []): Media
    {
        $ffmpeg = FFMpeg::create();
        $video = $ffmpeg->open($videoMedia->getPath());

        // Configure video codec
        $videoCodec = match($format) {
            'mp4' => new X264(),
            'webm' => new WebM(),
            'avi' => new X264('libxvid'),
            default => throw new UnsupportedFormatException("Format {$format} not supported")
        };

        // Configure audio codec
        $audioCodec = match($format) {
            'mp4' => new AAC(),
            'webm' => new Vorbis(),
            'avi' => new Mp3(),
            default => new AAC()
        };

        // Apply options
        if (isset($options['bitrate'])) {
            $videoCodec->setKiloBitrate($options['bitrate']);
        }

        if (isset($options['width'], $options['height'])) {
            $video->filters()->resize(new Dimension($options['width'], $options['height']));
        }

        // Save transcoded video
        $outputPath = $this->generateTranscodedPath($videoMedia, $format);
        $video->save($videoCodec, $outputPath);

        // Create media record for transcoded version
        return $videoMedia->model->addMedia($outputPath)
            ->usingName($videoMedia->name . " - {$format}")
            ->withCustomProperties([
                'type' => 'transcoded_video',
                'format' => $format,
                'parent_media_id' => $videoMedia->id,
                'transcode_options' => $options,
            ])
            ->toMediaCollection('videos');
    }
}
```

## 🔐 Security & Access Control

### Advanced Security System
```php
// Media security service
class MediaSecurityService
{
    public function validateFileContent(UploadedFile $file): void
    {
        // Check file signature against MIME type
        $expectedSignatures = $this->getMimeTypeSignatures($file->getMimeType());
        $fileSignature = $this->getFileSignature($file);

        if (!in_array($fileSignature, $expectedSignatures)) {
            throw new SuspiciousFileException("File signature doesn't match declared MIME type");
        }

        // Scan for embedded malicious content
        $this->scanForEmbeddedMalware($file);

        // Check for suspicious metadata
        $this->validateMetadata($file);
    }

    private function scanForEmbeddedMalware(UploadedFile $file): void
    {
        // Use ClamAV or similar antivirus
        if (config('media.antivirus.enabled', false)) {
            $scanner = new ClamAVScanner();
            $result = $scanner->scan($file->getRealPath());

            if ($result->isInfected()) {
                throw new MalwareDetectedException("Malware detected: {$result->getVirusName()}");
            }
        }
    }

    public function generateSecureUrl(Media $media, array $options = []): string
    {
        // Check access permissions
        if (!$this->canAccess(auth()->user(), $media)) {
            throw new UnauthorizedAccessException("User cannot access this media");
        }

        $expiration = $options['expires'] ?? now()->addHours(1);
        $action = $options['action'] ?? 'read';

        // Generate signed URL
        $signature = hash_hmac('sha256', implode('|', [
            $media->id,
            $action,
            $expiration->timestamp,
            auth()->id(),
        ]), config('app.key'));

        return route('media.secure', [
            'media' => $media->id,
            'action' => $action,
            'expires' => $expiration->timestamp,
            'signature' => $signature,
            'user' => auth()->id(),
        ]);
    }

    public function validateSecureAccess(string $mediaId, string $action, int $expires, string $signature, string $userId): bool
    {
        // Check expiration
        if (now()->timestamp > $expires) {
            throw new ExpiredUrlException("Secure URL has expired");
        }

        // Verify signature
        $expectedSignature = hash_hmac('sha256', implode('|', [
            $mediaId,
            $action,
            $expires,
            $userId,
        ]), config('app.key'));

        if (!hash_equals($expectedSignature, $signature)) {
            throw new InvalidSignatureException("Invalid URL signature");
        }

        // Verify user permissions
        $media = Media::findOrFail($mediaId);
        $user = User::findOrFail($userId);

        return $this->canAccess($user, $media, $action);
    }

    private function canAccess(User $user, Media $media, string $action = 'read'): bool
    {
        // Check if user owns the media
        if ($media->user_id === $user->id) {
            return true;
        }

        // Check if user has access to the model that owns the media
        if ($media->model && method_exists($media->model, 'canBeAccessedBy')) {
            return $media->model->canBeAccessedBy($user, $action);
        }

        // Check permissions based on collection
        return $user->can("{$action}_media", $media);
    }
}

// Access logging and analytics
class MediaAccessLogger
{
    public function logAccess(Media $media, User $user, string $action, array $context = []): void
    {
        MediaAccessLog::create([
            'media_id' => $media->id,
            'user_id' => $user->id,
            'action' => $action,
            'ip_address' => request()->ip(),
            'user_agent' => request()->header('User-Agent'),
            'context' => $context,
            'accessed_at' => now(),
        ]);

        // Real-time analytics
        $this->updateAccessMetrics($media, $action);
    }

    private function updateAccessMetrics(Media $media, string $action): void
    {
        // Update access counters
        $media->increment("{$action}_count");
        $media->touch('last_accessed_at');

        // Update daily metrics
        $today = now()->format('Y-m-d');
        MediaMetrics::updateOrCreate([
            'media_id' => $media->id,
            'date' => $today,
        ], [
            "{$action}_count" => DB::raw("{$action}_count + 1"),
        ]);
    }

    public function getAccessAnalytics(Media $media, string $period = '30d'): array
    {
        $startDate = match($period) {
            '24h' => now()->subDay(),
            '7d' => now()->subWeek(),
            '30d' => now()->subMonth(),
            '1y' => now()->subYear(),
            default => now()->subMonth()
        };

        return [
            'total_views' => $media->view_count,
            'total_downloads' => $media->download_count,
            'unique_viewers' => MediaAccessLog::where('media_id', $media->id)
                ->where('action', 'view')
                ->where('accessed_at', '>=', $startDate)
                ->distinct('user_id')
                ->count(),
            'popular_times' => $this->getPopularAccessTimes($media, $startDate),
            'geographic_distribution' => $this->getGeographicDistribution($media, $startDate),
            'device_breakdown' => $this->getDeviceBreakdown($media, $startDate),
        ];
    }
}
```

## 📊 Storage Management & Optimization

### Multi-Storage Architecture
```php
// Storage manager with intelligent routing
class StorageManager
{
    public function __construct(
        private array $disks = [],
        private StorageOptimizer $optimizer
    ) {}

    public function getBestDiskForFile(UploadedFile $file, array $requirements = []): string
    {
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();

        // Route based on file type and size
        if (str_starts_with($mimeType, 'image/') && $fileSize < 5 * 1024 * 1024) {
            return 'images_fast'; // SSD storage for small images
        }

        if (str_starts_with($mimeType, 'video/')) {
            return 'videos_archive'; // Archive storage for videos
        }

        if ($fileSize > 100 * 1024 * 1024) {
            return 's3_ia'; // S3 Infrequent Access for large files
        }

        // Default to standard storage
        return 'standard';
    }

    public function migrateToOptimalStorage(Media $media): bool
    {
        $currentDisk = $media->disk;
        $optimalDisk = $this->getOptimalDiskForMedia($media);

        if ($currentDisk === $optimalDisk) {
            return true; // Already on optimal storage
        }

        try {
            // Copy file to new storage
            $sourceFile = Storage::disk($currentDisk)->get($media->path);
            $newPath = $this->generatePathForDisk($media, $optimalDisk);

            Storage::disk($optimalDisk)->put($newPath, $sourceFile);

            // Update media record
            $media->update([
                'disk' => $optimalDisk,
                'path' => $newPath,
                'migrated_at' => now(),
            ]);

            // Clean up old file after delay (safety measure)
            dispatch(new CleanupOldMediaFileJob($currentDisk, $media->path))
                ->delay(now()->addHours(24));

            return true;

        } catch (Exception $e) {
            Log::error('Failed to migrate media to optimal storage', [
                'media_id' => $media->id,
                'from_disk' => $currentDisk,
                'to_disk' => $optimalDisk,
                'error' => $e->getMessage(),
            ]);

            return false;
        }
    }

    private function getOptimalDiskForMedia(Media $media): string
    {
        $accessFrequency = $this->getAccessFrequency($media);
        $fileAge = $media->created_at->diffInDays(now());

        // Frequently accessed recent files -> Fast storage
        if ($accessFrequency > 10 && $fileAge < 30) {
            return 'fast_ssd';
        }

        // Moderately accessed files -> Standard storage
        if ($accessFrequency > 1 && $fileAge < 180) {
            return 'standard';
        }

        // Rarely accessed old files -> Archive storage
        return 'archive';
    }
}

// Storage cost optimization
class StorageCostOptimizer
{
    public function analyzeStorageCosts(): array
    {
        $disks = config('filesystems.disks');
        $analysis = [];

        foreach ($disks as $diskName => $config) {
            $analysis[$diskName] = [
                'total_files' => Media::where('disk', $diskName)->count(),
                'total_size' => Media::where('disk', $diskName)->sum('size'),
                'estimated_monthly_cost' => $this->calculateMonthlyCost($diskName),
                'optimization_opportunities' => $this->getOptimizationOpportunities($diskName),
            ];
        }

        return $analysis;
    }

    public function getOptimizationRecommendations(): array
    {
        return [
            'migrate_to_archive' => $this->getFilesForArchive(),
            'compress_images' => $this->getImagesForCompression(),
            'delete_unused' => $this->getUnusedFiles(),
            'cleanup_temp' => $this->getTempFilesForCleanup(),
        ];
    }

    private function getFilesForArchive(): Collection
    {
        return Media::where('created_at', '<', now()->subMonths(6))
            ->whereHas('accessLogs', function ($query) {
                $query->where('accessed_at', '<', now()->subMonths(3));
            }, '<', 5) // Less than 5 accesses in last 3 months
            ->where('disk', '!=', 'archive')
            ->get();
    }

    private function getImagesForCompression(): Collection
    {
        return Media::where('mime_type', 'like', 'image/%')
            ->where('size', '>', 1024 * 1024) // Larger than 1MB
            ->whereNull('compressed_at')
            ->get();
    }
}
```

## 🎨 Media Collections & Organization

### Advanced Collection System
```php
// Media collection with advanced features
class MediaCollectionManager
{
    public function createSmartCollection(string $name, array $rules): MediaCollection
    {
        $collection = MediaCollection::create([
            'name' => $name,
            'rules' => $rules,
            'auto_organize' => true,
        ]);

        // Apply rules to existing media
        $this->applyCollectionRules($collection);

        return $collection;
    }

    public function applyCollectionRules(MediaCollection $collection): void
    {
        $rules = $collection->rules;

        $query = Media::query();

        // Apply MIME type filters
        if (isset($rules['mime_types'])) {
            $query->whereIn('mime_type', $rules['mime_types']);
        }

        // Apply size filters
        if (isset($rules['min_size'])) {
            $query->where('size', '>=', $rules['min_size']);
        }
        if (isset($rules['max_size'])) {
            $query->where('size', '<=', $rules['max_size']);
        }

        // Apply date filters
        if (isset($rules['created_after'])) {
            $query->where('created_at', '>=', $rules['created_after']);
        }

        // Apply custom metadata filters
        if (isset($rules['metadata'])) {
            foreach ($rules['metadata'] as $key => $value) {
                $query->whereJsonContains("custom_properties->{$key}", $value);
            }
        }

        // Add matching media to collection
        $matchingMedia = $query->get();
        foreach ($matchingMedia as $media) {
            $media->update(['collection_name' => $collection->name]);
        }
    }

    public function organizeByAI(Collection $mediaItems): array
    {
        // Use AI/ML to automatically categorize media
        $categories = [];

        foreach ($mediaItems as $media) {
            if ($media->isImage()) {
                $category = $this->categorizeImage($media);
            } elseif ($media->isVideo()) {
                $category = $this->categorizeVideo($media);
            } else {
                $category = $this->categorizeDocument($media);
            }

            $categories[$category][] = $media;
        }

        // Create collections for each category
        foreach ($categories as $categoryName => $items) {
            $this->createOrUpdateCollection($categoryName, $items);
        }

        return $categories;
    }

    private function categorizeImage(Media $media): string
    {
        // Extract image features and categorize
        $metadata = $media->custom_properties;

        // Check for faces
        if (isset($metadata['faces_detected']) && $metadata['faces_detected'] > 0) {
            return 'people';
        }

        // Check dimensions for category
        if ($media->width > $media->height && ($media->width / $media->height) > 2) {
            return 'panoramic';
        }

        // Use image analysis service
        return $this->analyzeImageContent($media);
    }
}
```

## 📈 Analytics & Performance Monitoring

### Comprehensive Media Analytics
```php
// Media analytics service
class MediaAnalyticsService
{
    public function getUsageStatistics(string $period = '30d'): array
    {
        $startDate = $this->getPeriodStartDate($period);

        return [
            'storage_usage' => $this->getStorageUsage($startDate),
            'bandwidth_usage' => $this->getBandwidthUsage($startDate),
            'popular_media' => $this->getPopularMedia($startDate),
            'upload_trends' => $this->getUploadTrends($startDate),
            'conversion_metrics' => $this->getConversionMetrics($startDate),
            'cost_analysis' => $this->getCostAnalysis($startDate),
        ];
    }

    private function getStorageUsage(Carbon $startDate): array
    {
        $disks = config('filesystems.disks');
        $usage = [];

        foreach (array_keys($disks) as $diskName) {
            $diskUsage = Media::where('disk', $diskName)
                ->where('created_at', '>=', $startDate)
                ->select([
                    DB::raw('COUNT(*) as file_count'),
                    DB::raw('SUM(size) as total_size'),
                    DB::raw('AVG(size) as average_size'),
                ])
                ->first();

            $usage[$diskName] = [
                'file_count' => $diskUsage->file_count,
                'total_size' => $diskUsage->total_size,
                'average_size' => $diskUsage->average_size,
                'size_formatted' => $this->formatBytes($diskUsage->total_size),
            ];
        }

        return $usage;
    }

    private function getBandwidthUsage(Carbon $startDate): array
    {
        return [
            'downloads' => MediaAccessLog::where('action', 'download')
                ->where('accessed_at', '>=', $startDate)
                ->join('media', 'media_access_logs.media_id', '=', 'media.id')
                ->sum('media.size'),
            'streams' => MediaAccessLog::where('action', 'stream')
                ->where('accessed_at', '>=', $startDate)
                ->join('media', 'media_access_logs.media_id', '=', 'media.id')
                ->sum('media.size'),
            'previews' => MediaAccessLog::where('action', 'preview')
                ->where('accessed_at', '>=', $startDate)
                ->count(),
        ];
    }

    public function generateOptimizationReport(): array
    {
        return [
            'duplicate_files' => $this->findDuplicateFiles(),
            'large_unused_files' => $this->findLargeUnusedFiles(),
            'conversion_opportunities' => $this->findConversionOpportunities(),
            'archive_candidates' => $this->findArchiveCandidates(),
            'cost_optimization' => $this->getCostOptimizationSuggestions(),
        ];
    }

    private function findDuplicateFiles(): Collection
    {
        return Media::select('hash', DB::raw('COUNT(*) as count'))
            ->whereNotNull('hash')
            ->groupBy('hash')
            ->having('count', '>', 1)
            ->with('media')
            ->get();
    }

    private function findConversionOpportunities(): Collection
    {
        return Media::where('mime_type', 'like', 'image/%')
            ->where('size', '>', 500 * 1024) // Larger than 500KB
            ->whereDoesntHave('conversions', function ($query) {
                $query->where('conversion_name', 'webp');
            })
            ->get();
    }
}
```

## 🚀 Modern Laravel 12 + PHP 8.3 Optimizations

### Enhanced Type Safety & Enums
```php
// Modern media enums
enum MediaType: string
{
    case IMAGE = 'image';
    case VIDEO = 'video';
    case AUDIO = 'audio';
    case DOCUMENT = 'document';
    case ARCHIVE = 'archive';

    public function allowedMimeTypes(): array
    {
        return match($this) {
            self::IMAGE => ['image/jpeg', 'image/png', 'image/gif', 'image/webp'],
            self::VIDEO => ['video/mp4', 'video/webm', 'video/quicktime'],
            self::AUDIO => ['audio/mpeg', 'audio/wav', 'audio/ogg'],
            self::DOCUMENT => ['application/pdf', 'application/msword'],
            self::ARCHIVE => ['application/zip', 'application/x-rar'],
        };
    }

    public function maxFileSize(): int
    {
        return match($this) {
            self::IMAGE => 10 * 1024 * 1024,    // 10MB
            self::VIDEO => 500 * 1024 * 1024,   // 500MB
            self::AUDIO => 50 * 1024 * 1024,    // 50MB
            self::DOCUMENT => 25 * 1024 * 1024, // 25MB
            self::ARCHIVE => 100 * 1024 * 1024, // 100MB
        };
    }
}

enum StorageTier: string
{
    case HOT = 'hot';           // Frequently accessed
    case WARM = 'warm';         // Occasionally accessed
    case COLD = 'cold';         // Rarely accessed
    case ARCHIVE = 'archive';   // Long-term storage

    public function diskName(): string
    {
        return match($this) {
            self::HOT => 'fast_ssd',
            self::WARM => 'standard',
            self::COLD => 's3_standard',
            self::ARCHIVE => 's3_glacier',
        };
    }

    public function costPerGB(): float
    {
        return match($this) {
            self::HOT => 0.25,
            self::WARM => 0.15,
            self::COLD => 0.10,
            self::ARCHIVE => 0.05,
        };
    }
}
```

### Readonly Configuration Objects
```php
// Immutable upload configuration
readonly class UploadConfiguration
{
    public function __construct(
        public MediaType $mediaType,
        public StorageTier $storageTier,
        public bool $virusScanning,
        public bool $autoConversions,
        public array $allowedMimes,
        public int $maxFileSize,
        public string $uploadPath,
        public ?int $expiresAfterDays = null
    ) {}
}

readonly class ConversionConfiguration
{
    public function __construct(
        public string $name,
        public int $width,
        public int $height,
        public int $quality,
        public string $format,
        public bool $optimize,
        public array $filters = []
    ) {}
}
```

## 🎯 Success Metrics & Monitoring

### Performance Targets
- **Upload Speed**: <5s for files up to 10MB
- **Conversion Time**: <30s for standard image conversions
- **Storage Efficiency**: >95% utilization
- **Access Speed**: <200ms for cached files
- **Uptime**: 99.9% availability

### Quality Metrics
- **File Integrity**: 100% (hash verification)
- **Security Compliance**: Zero breaches
- **Storage Cost Optimization**: 20% reduction through tiering
- **User Satisfaction**: >95% upload success rate
- **System Performance**: <2GB memory usage per worker

Il modulo Media rappresenta un componente critico per user experience e richiede particolare attenzione per security, performance e scalabilità, specialmente con grandi volumi di file e traffico elevato.