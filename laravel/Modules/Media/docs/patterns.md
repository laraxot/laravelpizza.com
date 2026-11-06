---
created: 2026-09-26
updated: 2026-09-26
qmd: "patterns"
issues: []
discussions: []
title: "Architectural Patterns: Media Module"
module: "Media"
type: architecture
tags: [patterns, best-practices]
last_updated: 2026-07-28
status: draft
---

# Architectural Patterns: Media Module

**Last updated:** 2026-07-28

This document describes common architectural patterns in the Media module and anti-patterns to avoid.

---

## 1. Media Processing Pipeline Pattern

**Purpose:** Decouple upload, validation, and processing into discrete, testable steps.

**Core Idea:**
```
Input → Validation → Temporary Storage → Processing Queue → Final Storage → Attach to Model
```

**Implementation:**

```php
// Pattern: Use Actions for each step
public function handle(UploadRequest $request): void
{
    $tempPath = app(GenerateTemporaryUploadPathAction::class)->execute();
    
    $tempFile = $request->file('media')->storeAs(
        dirname($tempPath),
        basename($tempPath),
        'temporary'
    );
    
    app(SaveAttachmentsAction::class)->execute(
        model: $this->model,
        attachments: [
            new AttachmentToSaveData(
                disk: 'public',
                path: 'uploads/media',
                temporaryPath: $tempFile,
            )
        ]
    );
}
```

**Benefits:**
- Testable steps (mock storage, temporary paths)
- Reusable actions across controllers/commands
- Clear error boundaries for recovery

**Checklist:**
- [ ] Use separate Actions for upload, validation, processing
- [ ] Store temporary files with unique session identifiers
- [ ] Implement atomic attachment operations
- [ ] Log each step for debugging

---

## 2. Video Transformation Pattern

**Purpose:** Standardize video encoding workflows with FFmpeg for consistency and performance.

**Core Idea:**
```
Input Video → FFmpeg Pipeline → Multiple Formats → Storage → Link to Model
```

**Implementation:**

```php
// Pattern: FFmpeg conversion with format chaining
public function execute(string $disk, string $inputPath, string $outputDir): void
{
    FFMpeg::fromDisk($disk)
        ->open($inputPath)
        ->export()
        ->toDisk($disk)
        ->inFormat(new X264)
        ->save("{$outputDir}/video.mp4");
    
    FFMpeg::fromDisk($disk)
        ->open($inputPath)
        ->export()
        ->toDisk($disk)
        ->inFormat(new WebM)
        ->save("{$outputDir}/video.webm");
}
```

**Why not shell_exec:**
- No manual FFmpeg command construction
- Proper error handling via EncodingException
- Built-in progress tracking hooks
- Version management via composer

**Checklist:**
- [ ] Always use FFMpeg facade, never shell_exec
- [ ] Implement format fallback chains (MP4 → WebM → fallback)
- [ ] Use QueueableAction for background encoding
- [ ] Catch EncodingException and log getCommand() + getErrorOutput()
- [ ] Store conversion metadata in MediaConvert table

---

## 3. Image Transformation Pattern

**Purpose:** Optimize images at upload time with multiple output formats.

**Core Idea:**
```
Uploaded Image → Intervention Image → Multiple Sizes + Formats → Disk → Attach
```

**Implementation:**

```php
// Pattern: Generate variants (original, webp, thumbnail)
public function execute(string $sourcePath): array
{
    $image = Image::read("disk://public/{$sourcePath}");
    
    // Original: optimize and validate
    $image->save("disk://public/{$sourcePath}", quality: 85);
    
    // WebP variant for modern browsers
    $webpPath = str_replace('.jpg', '.webp', $sourcePath);
    $image->toWebp(quality: 80)->save("disk://public/{$webpPath}");
    
    // Thumbnail for listings
    $thumbPath = "thumbnails/" . basename($sourcePath, '.jpg') . '-thumb.jpg';
    $image->scaleDown(width: 200)->save("disk://public/{$thumbPath}", quality: 75);
    
    return [
        'original' => $sourcePath,
        'webp' => $webpPath,
        'thumbnail' => $thumbPath,
    ];
}
```

**Benefits:**
- Lazy-load WebP with jpg fallback
- Consistent thumbnail sizing
- Reduced storage with format optimization
- Progressive enhancement for older browsers

**Checklist:**
- [ ] Generate at least 3 variants (original, webp, thumb)
- [ ] Use quality: 75-85 for web delivery
- [ ] Store variant paths in media_conversions table
- [ ] Implement cache-busting strategy for CDN
- [ ] Test EXIF sanitization for security

---

## 4. Cloud Storage Strategy Pattern

**Purpose:** Abstract cloud provider differences behind a unified disk interface.

**Core Idea:**
```
Local Upload → Validate → Sync to Cloud (S3/CloudFront) → Serve via CDN
```

**Implementation:**

```php
// Pattern: Disk-agnostic storage with fallback
$disk = config('media.default_disk', 'local');

$path = $file->storeAs(
    'uploads',
    $file->hashName(),
    disk: $disk  // config controls cloud vs local
);

// For S3: generate signed URLs for private content
if ($disk === 's3') {
    $url = Storage::disk('s3')->temporaryUrl(
        $path,
        now()->addHours(24)
    );
}
```

**Why CloudFront:**
- Lower latency globally via CDN
- Automatic compression + caching
- Cost reduction for high-volume serving
- DDoS protection at CDN edge

**Checklist:**
- [ ] Configure default disk in config/media.php
- [ ] Implement disk fallback (s3 → local → error)
- [ ] Use temporary URLs for private content
- [ ] Set CloudFront cache-control headers
- [ ] Implement S3 bucket policy validation
- [ ] Test Minio compatibility for self-hosted

---

## 5. Cache Strategy Pattern

**Purpose:** Reduce compute cost with strategic caching of transformations.

**Core Idea:**
```
Image Request → Cache Hit → Serve → Or → Transform → Cache → Serve
```

**Implementation:**

```php
// Pattern: Cache-aware transformation
public function execute(string $path, int $width): string
{
    $cacheKey = "media:transform:{$path}:{$width}";
    
    return cache()->remember($cacheKey, hours: 24, function () use ($path, $width) {
        $image = Image::read("disk://public/{$path}");
        $transformed = $image->scaleDown(width: $width);
        
        $cachePath = "cache/{$width}/" . basename($path);
        $transformed->save("disk://public/{$cachePath}");
        
        return $cachePath;
    });
}
```

**Cache Invalidation:**
- On original image update: flush cache
- On config change: flush specific pattern
- Daily: auto-refresh stale transforms

**Checklist:**
- [ ] Cache key includes all transform parameters
- [ ] Use cache()->remember() for atomic generation
- [ ] Implement cache flush on image update
- [ ] Monitor cache hit rates in logs
- [ ] Set appropriate TTL based on usage patterns

---

## Anti-Patterns to Avoid

### ❌ Anti-Pattern 1: Direct shell_exec for FFmpeg

**Wrong:**
```php
$output = shell_exec("ffmpeg -i {$input} {$output}");
```

**Why it breaks:**
- No error context from EncodingException
- Security vulnerability (command injection)
- Impossible to test
- Version mismatch with composer package
- No progress tracking

**Correct:**
```php
FFMpeg::fromDisk('public')
    ->open($input)
    ->export()
    ->inFormat(new X264)
    ->save($output);
```

---

### ❌ Anti-Pattern 2: Storing raw files without validation

**Wrong:**
```php
$path = $request->file('media')->store('uploads');
// No format check, size check, MIME validation
```

**Why it breaks:**
- Malicious uploads (executables masked as images)
- Uncontrolled storage growth
- No audit trail for compliance
- Vulnerable to XXE attacks in XML metadata

**Correct:**
```php
$request->validate([
    'media' => 'required|image|mimes:jpg,png,webp|max:10240|dimensions:min_width=100',
]);

$path = $request->file('media')->storeAs(
    'uploads',
    $this->generateSecureFileName(),
    config('media.default_disk')
);
```

---

### ❌ Anti-Pattern 3: Synchronous processing for large files

**Wrong:**
```php
public function store(Request $request)
{
    $video = $request->file('video')->store('uploads');
    
    // Blocks request for 5+ minutes
    FFMpeg::fromDisk('public')->open($video)->export()->save(...);
    
    return response('Done');
}
```

**Why it breaks:**
- Client timeout (default 30-60s)
- User sees spinner indefinitely
- No recovery mechanism
- Locks database connections

**Correct:**
```php
public function store(Request $request)
{
    $video = $request->file('video')->store('uploads');
    
    // Queue processing in background
    ConvertVideoAction::dispatch(
        disk: 'public',
        path: $video,
        formats: ['mp4', 'webm']
    );
    
    return response()->json(['message' => 'Processing started']);
}
```

---

## Summary Table

| Pattern | Use When | Key Files |
|---------|----------|-----------|
| **Media Processing Pipeline** | Handling file uploads | AttachMediaAction, SaveAttachmentsAction |
| **Video Transformation** | Encoding video formats | ConvertVideoAction, VideoGenerators |
| **Image Transformation** | Optimizing images | Image generators, Intervention Image |
| **Cloud Storage Strategy** | Multi-disk deployments | Storage facade, CloudFront config |
| **Cache Strategy** | High-volume image serving | Cache drivers, Redis integration |

---

**Related:** [Architecture](./ARCHITECTURE.md) | [Troubleshooting](./troubleshooting.md) | [Contributing](./CONTRIBUTING.md)
