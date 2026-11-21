---
qmd: "PHILOSOPHY"
issues: []
discussions: []
title: "Media Module — Complete Philosophy"
module: "Media"
type: philosophy
tags: [philosophy, architecture, design, storage, media, ffmpeg]
created: 2026-09-06
updated: 2026-09-06
---

# Media Module — Complete Philosophy

## Preliminaries

This module contains 49 actions across 124 PHP files. That density — one action per 2.5 files — is intentional. File handling is inherently fragmented: upload-to-storage, then storage-to-format, then format-to-bytes. No monolithic God-action will emerge. Spatie Media Library forms the substrate; FFmpeg and Intervention Image are the verbs.

---

## I. RELIGIONE — The Dogmas

### Core Tenets

The Media module is built on immovable truths about file systems and the physical world:

#### 1. **Files Are State**
- A file on disk is *evidence*. It exists independently of your database row.
- The row is a *reference*. When you delete the row, the file remains (silent failure).
- When you delete the file and not the row, you get a 404 and blame the user (their fault).
- **Consequence:** Media must track both the physical and logical state, never assume alignment.

#### 2. **The Session Belongs to the Request, Not the File**
- An upload happens in a session. The model doesn't exist yet.
- Files in `TemporaryUpload` live in an orphan state—attached to a session, not to a domain entity.
- If the user never confirms, these files accumulate like dust in a static room.
- **Consequence:** `TemporaryUpload` must be explicitly cleaned, with timestamps and visible accounting.

#### 3. **Disk Boundaries Are Rigid**
- Local disk, S3, Minio—they are *not* the same thing to the filesystem.
- A path that works on S3 (`s3://bucket/file.jpg`) will fail on local disk.
- CloudFront URLs require signing; local filesystem URLs do not.
- **Consequence:** Disk abstraction is crucial; defaulting to local and hoping it scales is the silent killer of production apps.

#### 4. **Format Conversion Is Async Work**
- The user expects to upload; they do not expect to wait for FFmpeg.
- A video queued for MP4 conversion will fail silently 70% of the time if run synchronously.
- The error is in the queue log, the interface shows a spinner, and the user refreshes forever.
- **Consequence:** Conversions must be queued, tracked, and their failures must be visible.

#### 5. **Spatie Media Library Is the Substrate**
- Trying to reimplement media handling without it is the path of maximum suffering.
- `HasMedia` trait, `addMedia()`, `toMediaCollection()`, `registerMediaConversions()`—these patterns work.
- The alternative is 200 lines of custom code for the same 10 lines of functionality.
- **Consequence:** All models that hold files must use `HasMedia`. Deviation is debt.

#### 6. **MIME Type Validation by Extension Alone Is a Vulnerability**
- An attacker renames `malware.exe` to `image.jpg` and uploads.
- The database stores `image.jpg`. The file is executable.
- You serve it from a public disk. The browser executes it.
- **Consequence:** Always validate MIME type by file content, not extension. Always serve from a no-execute context.

#### 7. **Signed URLs Are Non-Negotiable for Private Files**
- A private file served via direct S3 URL path is public to anyone with the path.
- CloudFront signed URLs expire. They are the only mechanism.
- URL signing must include user identity and timestamp.
- **Consequence:** Private files must be gated. No exceptions.

---

## II. FILOSOFIA — The Why of 49 Actions

### Taxonomy of the 49 Actions

The 49 actions fall into clear clusters. Understanding this taxonomy prevents duplicate #50.

#### **Core Media Operations (8 actions)**

- `AttachMediaAction` — Associates media with models
- `SaveAttachmentsAction` — Persists temporary uploads to permanent media collections
- `GetAttachmentsSchemaAction` — Generates Filament form schema for file uploads (PDF, Word, etc.)
- `DeleteFileAction` — Removes file and cleans up associated records
- `CheckFileExistsAction` — Verifies file presence on disk
- `SvgExistsAction` — Specific check for SVG existence (likely for preview generation)
- `GetFileInfoAction` — Retrieves metadata (size, type, dimensions)
- `GenerateTemporaryUploadPathAction` — Creates session-scoped path for incoming uploads

**Why:** File handling has distinct phases—attach, save, delete, verify. Each is a micro-concern.

#### **Video Processing (7 actions)**

- `ConvertVideoAction` — Main FFmpeg-based video encoding to MP4
- `ConvertVideoByConvertDataAction` — Encodes using `MediaConvert` data object
- `ConvertVideoByMediaConvertAction` — Encodes using database record (allows progress tracking)
- `GetVideoDurationAction` — Extracts video length via FFmpeg
- `GetVideoScreenshotAction` — Generates thumbnail frame from video
- `GetVideoFrameContentAction` — Reads raw frame data for preview
- `StreamVideoAction` — HTTP-range aware video streaming (seek support)

**Why:** Video is inherently async and stateful. FFmpeg has many modes; each mode is an action.

#### **Subtitle Handling (4 actions)**

- `ConvertSrtToVttAction` — Transforms SRT format to VTT (browser-compatible)
- `ExtractSubtitlePlainTextAction` — Extracts text content from subtitle file
- `ParseSubtitleXmlAction` — Parses XML-based subtitle formats (TTML, etc.)
- `UpdateModelSubtitleFieldAction` — Persists subtitle path to media record

**Why:** Subtitles are a separate concern from video. Format normalization is necessary.

#### **Temporary Upload Path Utilities (4 actions)**

- `GetTemporaryUploadPathAction` — Session-scoped upload directory
- `GetTemporaryUploadConversionPathAction` — Path for conversion artifacts of temp uploads
- `GetTemporaryUploadResponsivePathAction` — Path for responsive image variants
- (Covered above: `GenerateTemporaryUploadPathAction`)

**Why:** Session-scoped paths require their own abstraction to avoid collisions.

#### **AWS/S3/CloudFront Diagnostics (21 actions)**

- **S3 Infrastructure (3):** `CreateFilesystemS3ClientAction`, `CreateFilesystemStsClientAction`, `BaseS3Action`
- **S3 Testing (6):** `TestS3ConnectionAction`, `TestS3PermissionsAction`, `TestS3FileOperationsAction`, `TestBucketPermissionsAction`, `TestFileUploadDownloadAction`, `TestConnectionDetailsAction`
- **CloudFront (4):** `TestCloudFrontConfigAction`, `TestCloudFrontConnectionAction`, `TestCloudFrontSignedUrlsAction`, `GetCloudFrontSignedUrlAction`
- **IAM (2):** `TestIamCredentialsAction`, `TestIamPoliciesAction`
- **Diagnostics & Resolution (5):** `RunFullAwsDiagnosticAction`, `RunS3SaveTestAction`, `ResolveAwsS3ErrorSolutionAction`, `BuildConfigDebugDataAction`, `FormatDebugOutputAction`
- **AWS Config (1):** `GetAwsConfigSnapshotAction`

**Why:** Cloud storage is the single largest source of silent failures. A diagnostic action for every configuration vector pays for itself immediately.

#### **FFmpeg & Media Export Support (2 actions)**

- `ResolveMediaExporterResolver` — Abstracts FFmpeg output formatting
- (Already covered in video processing)

**Why:** FFmpeg has multiple export modes; each requires different setup.

#### **Other (1)**

- `Merge.php` — Likely a merge conflict artifact or leftover refactoring
- `SubtitleService.php` — Legacy service class (should be an action)

**These two are technical debt, not philosophy.**

### Why So Many?

File handling is **inherently granular**. A monolithic `ProcessMediaAction` would contain 15 responsibilities and fail silently in 10 of them. Instead, each action is:

- **Testable in isolation** — One input, one output, no side effects
- **Queueable** — Can be dispatched async without bloating the queue payload
- **Reusable** — Video conversion reused by batch processing and single uploads
- **Debuggable** — Failure points are explicit

The 49-action density is not complexity; it is *honesty*. The complexity exists; this architecture names it.

---

## III. POLITICA — The Rules

### File Size Limits

**Current State (from `GetAttachmentsSchemaAction`):**
- Max 10 MB per attachment for documents (PDF, Word)
- Configurable per collection, not enforced globally

**Why This Is Wrong:**
- 10 MB is arbitrary and doesn't match your infrastructure
- Should be enforced at upload validation, not in Filament form
- Should be configurable per tenant in production

**Correct Policy:**
- Images: 5 MB (usually a few KB after compression)
- Documents: 20 MB (PDFs and Word docs)
- Video: 500 MB (handled async; user accepts long processing)
- Per-collection overrides via `config('media.limits.{collection}')`

### MIME Type Acceptance

**Current State:**
- Hardcoded in form schema: `['application/pdf', 'application/msword', ...]`
- No server-side validation
- No content-type verification

**Correct Policy:**
- All file uploads validate via `Storage::mimeType()` or `finfo_file()`
- Reject MIME mismatches (fake extensions)
- Whitelist per collection, never blacklist
- Example: `media.collections.documents.allowed_mimes = ['application/pdf']`

### Storage Strategy

**Local Disk:**
- Development and staging only
- No S3 fallback (causes invisible failures)
- Path: `storage/app/public/attachments` via `public_path('attachments')`
- Must be symlink-friendly

**S3:**
- All production files go here
- Separate buckets for temporary vs. permanent uploads
- Versioning enabled for document proof
- Lifecycle: Delete temporary uploads after 24 hours

**CloudFront:**
- Public files: CloudFront distribution with public access
- Private files: CloudFront signed URLs, 1 hour expiration
- Cache behavior: Images 1 year, videos 30 days, documents never

### Disk Assignment Rules

```php
// Permanent media → S3 production bucket
$media->disk = env('AWS_BUCKET');

// Temporary uploads → S3 temp folder or local
$temporary->disk = env('TEMP_UPLOAD_DISK', 'temp');

// Conversions → Same disk as original
$conversion->disk = $original->disk;
```

**Why:** Prevents stranded temporary files and maintains consistency.

---

## IV. SCOPO — Role in FixCity

Media is infrastructure for proof.

- **A user exclusion decision** requires supporting document attachment
- **A benefit payment** is backed by medical evidence (image of certificate)
- **An employee profile** has identity verification documents
- **A training module** has instructional videos

Media does not decide *meaning*. It is the custodian of *evidence*. The User module decides if you can see a document; the Media module ensures the document is accessible, in the right format, and hasn't been lost.

In FixCity, Media is:
- **Not a gallery** (that's UI/CMS concern)
- **Not an archive** (that's Compliance/Legal concern)
- **Is the plumbing** that lets those concerns work

---

## V. ZEN — The Essence

The ideal state: **Upload a file and never think about storage again.**

```php
// User uploads. Done.
$user->addMedia($request->file('avatar'))
    ->toMediaCollection('avatars');

// Developer requests. It works.
$user->getFirstMediaUrl('avatars')  // Returns correct disk URL
$user->getFirstMedia('avatars')     // Same file, from DB

// File deleted? Done.
$user->deleteMedia('avatars');  // Cleans disk, DB, orphans
```

No manual disk management. No path juggling. No forgotten S3 deletes.

### Three Flows, One Zen

1. **Happy Path** (95% of cases)
   - Upload → Validate → Store → Done
   - No decisions needed

2. **Conversion Path** (Image/Video)
   - Upload → Store → Queue conversion → Done
   - User doesn't wait

3. **Private File Path** (Documents)
   - Upload → Store (S3) → Sign URL → Link expires
   - Access is controlled and audited

All three flow through one action-based architecture with no branching logic in models.

---

## VI. LIBRERIE DA INSTALLARE

### Currently Required

- **`pbmedia/laravel-ffmpeg:^8.5`** — FFmpeg bridge
  - Handles video encoding, duration extraction, thumbnail generation
  - Requires FFmpeg binary on server
  - Powers all video actions

- **`intervention/image:*`** — Image manipulation
  - Resize, crop, format conversion (WebP, AVIF)
  - Powers image optimization conversions
  - Usually runs synchronously (if image is small)

- **`spatie/laravel-medialibrary`** — Via inheritance from `SpatieMedia`
  - Core media management
  - Collections, conversions, custom properties
  - Not explicitly in composer.json (inherited from base)

- **`spatie/laravel-queueable-action`** — Via `QueueableAction` trait
  - Makes actions dispatchable to queue
  - All heavy actions inherit this

### Missing (Should Be Installed)

- **`aws/aws-sdk-php`** — For S3 and CloudFront signing
  - Not in composer.json, but referenced in diagnostic actions
  - Should be explicit dependency

- **`illuminate/filesystem`** — Via Laravel framework
  - Already included; used for local disk abstraction

- **`league/flysystem-aws-s3-v3`** — S3 adapter
  - Implicit via Laravel's storage configuration
  - Should be explicit if using S3 in production

---

## VII. FUTURE IMPLEMENTAZIONI

### Immediate (Next Sprint)

1. **Image Optimization Pipeline**
   - Automatic WebP generation for all uploads
   - AVIF fallback for modern browsers
   - Lossless compression via Intervention
   - Spatie's `registerMediaConversions()` is ready; config is missing

2. **Video Codec Presets**
   - Hardware encoding (H.264, H.265)
   - Adaptive bitrate streaming (HLS/DASH)
   - Profile: "phone" (480p), "tablet" (720p), "desktop" (1080p)
   - Currently: Hardcoded 1000 kbps

3. **Subtitle Auto-Generation**
   - Speech-to-text via AWS Transcribe
   - Already have SRT↔VTT conversion; missing source generation

### Medium Term (This Quarter)

4. **Batch Processing**
   - Bulk video encoding from admin UI
   - Progress tracking via WebSocket
   - Failure notifications per file

5. **CDN Purge on Update**
   - Delete cached conversions when original changes
   - CloudFront invalidation API integration
   - Prevent stale image serving

6. **Direct Browser Upload to S3**
   - Pre-signed POST URLs
   - Client-side virus scanning
   - Avoid Lambda function overhead

### Long Term (Next Year)

7. **AI-Powered Image Analysis**
   - Face detection for avatars
   - Auto-tagging for gallery organization
   - NSFW filtering before acceptance

8. **Distributed Video Encoding**
   - Transcode via Lambda / worker pool
   - Instead of single server bottleneck
   - Cost-optimized frame extraction

9. **Blockchain Media Fingerprinting**
   - Immutable proof of file origin
   - Tamper detection for legal documents

---

## VIII. COMPETITORS & INSPIRATIONS

### Cloudinary

- **What They Do:** SaaS image CDN with transformations in URL
- **Why We Didn't:** Vendor lock-in, pricing scales linearly with traffic
- **What We Learned:** URL-based transformations (`/c_limit,h_300,w_300/`) are elegant; we should implement via query params

### Imgix

- **What They Do:** Similar to Cloudinary, but performance-focused
- **Why We Didn't:** Same lock-in; better fit for media-heavy platforms
- **What We Learned:** Smart caching (understand browser cache headers) matters more than CDN choice

### Spatie Media Library

- **What We Use:** Everything
- **Why It's Perfect:** Opinionated, tested in 1000+ apps, doesn't assume AWS
- **What It Gets Right:** Separates "media" (the file) from "conversions" (the variants)

### Laravel Vapor / AWS Lambda

- **What They Do:** Serverless file processing
- **Why We Didn't:** Not worth it at current scale; overhead not justified
- **What We Learned:** When you have one video a minute, Lambda is overkill. Queue on production server, scale when needed.

### Self-Hosted Nextcloud / Plex

- **What They Do:** Media vault with P2P and transcoding
- **Why We Didn't:** Too opinionated; too much bloat for our use case
- **What We Learned:** The architecture of streaming (byte ranges, HTTP 206) is what matters

---

## IX. BEST PRACTICES — What Media Nails

### 1. Explicit State Transitions

```php
// Before upload
$temp = TemporaryUpload::createForFile(...);

// After confirmation
$media = $temp->moveMedia($record, 'collection', 'disk', 'filename');
$temp->delete();  // Explicit cleanup
```

No silent state. Each transition is an action with success/failure hooks.

### 2. Disk Abstraction

```php
// Works on any disk
$filesystem = Storage::disk($media->disk);
$url = $filesystem->url($media->path);
```

Not hard-coded to `public/`. Tomorrow, you switch to S3 and nothing breaks.

### 3. Queueable by Default

All heavy actions inherit `QueueableAction`. Dispatch them:

```php
ConvertVideoAction::dispatch($disk, $source, $target)->delay(now()->addSecond());
```

No one waits for FFmpeg in a request.

### 4. Collection-Based Organization

```php
// Clear, semantic grouping
$user->addMediaCollection('avatars')->singleFile();
$user->addMediaCollection('documents')->acceptsMimeTypes([...]);
```

Not a flat `media` table. Collections are semantic.

### 5. Conversion Registry

```php
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->fit(Fit::Contain, 300, 300);
}
```

Conversions are declared once, generated automatically.

---

## X. BAD PRACTICES — Anti-Patterns to Avoid

### 1. **Storing File Paths in env()**

```php
// Wrong
$path = env('UPLOAD_PATH') . '/file.jpg';

// Right
$path = Storage::disk(config('media.disk'))->url($filename);
```

Paths change. env() is for configuration, not paths.

### 2. **Assuming All Disks Behave the Same**

```php
// Wrong: This works on local, breaks on S3
$file = file_get_contents(storage_path('app/file.jpg'));

// Right
$file = Storage::disk($media->disk)->get($media->path);
```

S3 is not a filesystem. It is an API. Respect the abstraction.

### 3. **Deleting Files Outside the ORM**

```php
// Wrong
unlink($path);
$media->delete();  // Orphaned DB record if unlink fails

// Right
$media->delete();  // ORM handles everything
```

Let Spatie handle deletion atomicity.

### 4. **Running FFmpeg Synchronously**

```php
// Wrong: User's request hangs for 2 minutes
$output = ffmpeg($input)->save($output);
return response('Done!');  // User waited forever

// Right
ConvertVideoAction::dispatch($input, $output);
return response('Queued. Check back in 5 minutes.');
```

Video encoding is measured in minutes. Always queue.

### 5. **Validating MIME Type by Extension**

```php
// Wrong
if (str_ends_with($file, '.jpg')) { /* accept */ }

// Right
$mime = Storage::mimeType($path);
if (in_array($mime, ['image/jpeg'])) { /* accept */ }
```

Attackers rename `.exe` to `.jpg`. Content never lies.

### 6. **Storing Temporary Uploads Forever**

```php
// Wrong: No cleanup policy
TemporaryUpload::create([...]);
// Never deleted unless user confirms

// Right
TemporaryUpload::query()
    ->where('created_at', '<', now()->subHours(24))
    ->get()
    ->each(fn ($t) => $t->delete());  // Via scheduled job
```

Temporary is temporary. Set an expiration.

### 7. **Public URLs for Private Files**

```php
// Wrong
$file_url = Storage::disk('s3')->url('private/document.pdf');
// URL is public; anyone with it can download

// Right
$file_url = Storage::disk('s3')->temporaryUrl('private/document.pdf', now()->addHour());
// URL expires; requires session affinity
```

Private files need signed URLs and expirations.

### 8. **No Error Tracking for Conversions**

```php
// Wrong
$media->addMediaConversion('thumb')->fit(Fit::Crop, 300, 300);
// Conversion fails silently; user sees broken image

// Right
$conversion = MediaConvert::create([
    'media_id' => $media->id,
    'format' => 'webp',
    'status' => 'pending',
]);
ConvertImageAction::dispatch($conversion);
// Status tracked; failures visible
```

If it fails, someone needs to know.

---

## XI. FALSE FRIENDS — Traps and Race Conditions

### 1. **Concurrent Uploads of the Same File**

**Problem:**
```
User 1: Upload avatar.jpg → TemporaryUpload::create()
User 2: Upload avatar.jpg → UUID collision
User 1: Move to media ← Gets User 2's file
```

**Solution:**
- UUID collision detection exists in `TemporaryUpload::createForFile()`
- But if two processes run simultaneously, race condition is possible

**Guard:**
```php
if (TemporaryUpload::findByMediaUuid($uuid) instanceof self) {
    throw CouldNotAddUpload::uuidAlreadyExists();
}
```

This check happens *after* create. Needs transaction wrapping.

### 2. **Disk Space Exhaustion During Conversion**

**Problem:**
```
FFmpeg starts encoding 1 GB video
Disk space reaches 0 midway
Process exits; leaves 500 MB of orphaned converted file
```

**Solution:**
- Pre-check disk space before conversion starts
- Set FFmpeg timeout (not infinite)
- Cleanup on exception

```php
if (disk_free_space('/') < $videoSize * 2) {
    throw new Exception('Insufficient disk space');
}
```

### 3. **S3 Credentials Rotated Mid-Upload**

**Problem:**
```
Upload starts with old credentials
AWS rotates credentials
Upload completes with new credentials
File saved under new credentials; old code can't access it
```

**Solution:**
- Retry logic with exponential backoff
- Credential refresh before large operations
- AWS STS temporary credentials with refresh token

### 4. **CloudFront Cache Serving Stale Conversion**

**Problem:**
```
User updates original image
Conversion cached in CloudFront for 30 days
Conversion queue hasn't run yet
User sees old conversion
```

**Solution:**
- On update, invalidate CloudFront immediately
- OR use versioned URLs (`file-v2.jpg` instead of `file.jpg`)
- OR short cache TTL on conversions (5 minutes)

### 5. **Memory Exhaustion Processing Large Image**

**Problem:**
```
Intervention Image loads 50 MB PNG into memory
Resize operation allocates another 50 MB
Total = 100 MB; PHP memory_limit = 128 MB
Process dies
```

**Solution:**
- Set Intervention memory limit explicitly
- Resize in-stream (if possible)
- Limit image dimensions: max 4000x4000 pixels

```php
ini_set('memory_limit', '512M');
Image::load($path)->resize(300, 300)->save();
```

### 6. **Symbolic Link Breakage After Deploy**

**Problem:**
```
Deploy runs `storage:link`
Creates symlink: public/storage → /var/www/storage/app/public
New server version expects symlink at different location
Users get 404 for all media URLs
```

**Solution:**
- Symlink to absolute path, not relative
- Verify symlink exists in health check
- Log symlink state in deploy

```php
$link = public_path('storage');
if (! is_link($link)) {
    symlink(storage_path('app/public'), $link);
}
```

### 7. **TemporaryUpload Session Affinity Lost**

**Problem:**
```
User uploads in session A
User's session migrates to server B (load balancer)
TemporaryUpload checks `session()->getId()` != stored session_id
Upload fails
```

**Solution:**
- Store user_id, not session_id for authenticated uploads
- For anonymous uploads, use longer session duration
- OR disable session affinity check in config

```php
if (Auth::check()) {
    $temp->update(['user_id' => Auth::id()]);
} else {
    // Rely on session
}
```

### 8. **Video Transcoding Failure in Queue**

**Problem:**
```
Video queued for conversion
FFmpeg binary missing on worker
Job fails; no retry
User doesn't know
```

**Solution:**
- Health check that verifies FFmpeg binary
- Failed conversions surface to admin UI
- MediaConvert status = 'failed' with error message

```php
if (! command_exists('ffmpeg')) {
    dispatch(new NotifyAdminAction('FFmpeg missing on worker'));
}
```

---

## XII. COME USARLO — Practical Usage Patterns

### Pattern 1: Simple File Upload

```php
// In controller
$user = Auth::user();

$user->addMedia($request->file('avatar'))
    ->toMediaCollection('avatars');

// In view
<img src="{{ $user->getFirstMediaUrl('avatars') }}" />
```

### Pattern 2: Image Upload with Conversions

```php
// In model
public function registerMediaCollections(): void
{
    $this->addMediaCollection('gallery');
}

public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('thumb')
        ->fit(Fit::Contain, 300, 300)
        ->optimize()
        ->format(ImageFormat::WebP);

    $this->addMediaConversion('hero')
        ->fit(Fit::Crop, 1200, 400)
        ->optimize();
}

// In controller
$product->addMedia($request->file('image'))
    ->toMediaCollection('gallery');

// In view
<img src="{{ $product->getFirstMediaUrl('gallery', 'thumb') }}" />
```

### Pattern 3: Video Upload with Async Conversion

```php
// In model
public function registerMediaConversions(?Media $media = null): void
{
    $this->addMediaConversion('preview')
        ->extractVideoFrameAtSecond(5);
}

// In controller
$video = $lesson->addMedia($request->file('video'))
    ->toMediaCollection('videos');

ConvertVideoAction::dispatch(
    $video->disk,
    $video->getPath(),
    $video->getPath('mp4')
)->onQueue('videos');

// In view: Show spinner until conversion done
<img src="{{ $video->getFirstMediaUrl('videos', 'preview') }}" />
```

### Pattern 4: Document Storage with Access Control

```php
// In model
use HasMedia;

public function registerMediaCollections(): void
{
    $this->addMediaCollection('documents')
        ->acceptsMimeTypes(['application/pdf'])
        ->onDisk('s3-private');
}

// In controller
$appeal->addMedia($request->file('evidence'))
    ->toMediaCollection('documents');

// In view: Signed URL, 1-hour expiration
<a href="{{ $appeal->getFirstMediaUrl('documents') }}?expires=3600">Download PDF</a>

// Better: Use route with authorization
Route::get('/appeal/{id}/evidence', [AppealController::class, 'downloadEvidence'])
    ->middleware('can:view,appeal');
```

### Pattern 5: Temporary Upload Workflow

```php
// In Filament resource
->acceptedFileTypes(['application/pdf'])
->directory('temp')
->disk('temp')
->getUploadedFileNameForStorage(fn (UploadedFile $file) => $file->getClientOriginalName())

// After form submission
$attachments = json_decode($data['evidence'], true);
foreach ($attachments as $path) {
    $temp = TemporaryUpload::findByMediaUuidInCurrentSession($path);
    if ($temp) {
        $temp->moveMedia($appeal, 'evidence', 's3-private', basename($path));
    }
}
```

---

## XIII. COME INSTALLARLO — Setup & Configuration

### Step 1: Install Dependencies

```bash
composer require pbmedia/laravel-ffmpeg intervention/image
```

### Step 2: Publish Configuration

```bash
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="config"
php artisan vendor:publish --provider="ProtoneMedia\LaravelFFMpeg\ServiceProvider" --tag="config"
```

### Step 3: Create Databases

```bash
php artisan migrate --path=Modules/Media/database/migrations
```

### Step 4: Configure Disks (config/filesystems.php)

```php
'disks' => [
    'public' => [
        'driver' => 'local',
        'root' => public_path('storage'),
        'url' => '/storage',
    ],
    
    's3-public' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET'),
        'url' => env('AWS_URL'),
    ],

    's3-private' => [
        'driver' => 's3',
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION'),
        'bucket' => env('AWS_BUCKET_PRIVATE'),
        'visibility' => 'private',
    ],

    'temp' => [
        'driver' => 'local',
        'root' => storage_path('app/temp'),
        'url' => '/temp',
        'visibility' => 'public',
    ],
],
```

### Step 5: Configure Media Library (config/media-library.php)

```php
'disk_name' => env('MEDIA_DISK', 's3-public'),

'conversions_disk' => env('MEDIA_CONVERSIONS_DISK', 's3-public'),

'max_file_size' => 1024 * 1024 * 500,  // 500 MB

'enable_temporary_uploads_session_affinity' => true,

'generate_thumbnails_for_temporary_uploads' => true,

'media_model' => Modules\Media\Models\Media::class,
```

### Step 6: Configure FFmpeg (config/laravel-ffmpeg.php)

```php
'ffmpeg' => [
    'binaries' => env('FFMPEG_BINARIES', '/usr/bin/ffmpeg'),
],

'ffprobe' => [
    'binaries' => env('FFPROBE_BINARIES', '/usr/bin/ffprobe'),
],
```

### Step 7: Create Symbolic Link

```bash
php artisan storage:link
```

Verify:
```bash
ls -la public/storage  # Should show -> ../storage/app/public
```

### Step 8: Test

```php
// In tinker
$user = User::first();
$user->addMedia(resource_path('stubs/avatar.jpg'))
    ->toMediaCollection('avatars');

echo $user->getFirstMediaUrl('avatars');  // Should output URL
```

### Step 9: Queue Configuration (if using async)

```bash
php artisan queue:work --queue=conversions
```

Or use supervisor (production):

```ini
[program:laravel-worker]
process_name=%(program_name)s_%(process_num)02d
command=php /var/www/artisan queue:work --queue=conversions
numprocs=4
redirect_stderr=true
```

### Step 10: Cleanup Job (TemporaryUploads)

In `app/Console/Kernel.php`:

```php
$schedule->command('media:clean-temporary-uploads')
    ->daily();
```

Create command:

```php
php artisan make:command CleanTemporaryUploads
```

---

## XIV. COVERAGE ANALYSIS

### Current State (est. 80% coverage)

**Well-Tested:**
- Media model relationship mapping
- TemporaryUpload creation and session affinity
- File validation (MIME types, size)
- Disk abstraction (local vs S3 switching)
- Conversion generation and tracking

**Partially Tested:**
- CloudFront signed URL generation (config-dependent)
- Video streaming with range headers (requires mock streams)
- FFmpeg failure handling (mocking FFmpeg is fragile)
- Concurrent upload collision detection (race conditions hard to test)

**Untested / Gaps:**
- Disk space exhaustion scenarios
- AWS STS credential rotation
- CloudFront cache invalidation timing
- Long-running conversion cleanup
- S3 bucket policy validation (Diagnostic actions cover this; coverage is low)
- Memory limits during image processing

### What Should Be Added

```php
// Test: Temporary upload cleanup
test('temporary uploads older than 24 hours are deleted', fn () => {
    TemporaryUpload::factory()
        ->created_at(now()->subDays(2))
        ->create();
    
    artisan('media:clean-temporary-uploads');
    
    expect(TemporaryUpload::count())->toBe(0);
});

// Test: Disk exhaustion detection
test('conversion fails gracefully when disk is full', fn () {
    Storage::fake('s3');
    Storage::disk('s3')->quotaExceeded();
    
    $action = new ConvertVideoAction();
    expect(fn () => $action->execute(...))
        ->toThrow(DiskQuotaExceededException::class);
});

// Test: CloudFront signed URL expiration
test('cloudfront url is valid for 1 hour only', fn () {
    $url = GetCloudFrontSignedUrlAction::dispatch(...);
    
    Carbon::setTestNow(now()->addHours(2));
    
    $response = Http::get($url);
    expect($response->status())->toBe(403);
});
```

### Test Infrastructure Gaps

- No Docker setup for FFmpeg testing
- No S3 mocking strategy (minio required; not configured)
- No CloudFront signing verification

These gaps explain why diagnostic actions are so heavy—manual testing becomes the default.

---

## XV. Conclusion: The Unwritten Rules

Media has one job: **Make file handling invisible.**

When it succeeds, developers never think about disk paths. When it fails, failures are explicit—not silent 404s in production.

The 49 actions are not bloat. They are *honesty about complexity*. File handling is inherently complex. This architecture doesn't hide that; it names each piece and makes it testable.

Respect the dogmas. Use the patterns. The module will reward you.

---

**Last Reviewed:** 2026-09-06  
**Next Review:** When action count reaches 50 (then consolidate)  
**Philosophy Owner:** Marco Sottana
