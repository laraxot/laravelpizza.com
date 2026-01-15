# Media Module - Testing Guidelines

## Testing Framework Requirements

### Environment Configuration
All tests MUST use `.env.testing` configuration:
```env
APP_ENV=testing
DB_CONNECTION=sqlite
DB_DATABASE=<nome progetto>_data_test
FILESYSTEM_DISK=local
MEDIA_DISK=local
```

### Pest Framework Usage
All tests MUST be written in Pest format. Convert any PHPUnit tests to Pest syntax.

## Business Logic Test Coverage

### 1. Media Management Tests

#### Core Media Operations
```php
<?php

declare(strict_types=1);

use Modules\Media\Models\Media;
use Modules\Media\Models\MediaCollection;
use Modules\User\Models\User;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

describe('Media Management Business Logic', function () {
    beforeEach(function () {
        Storage::fake('local');
    });

    it('uploads and stores media files securely', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('test-image.jpg', 800, 600);

        $media = Media::createFromUpload($file, [
            'collection' => 'patient_documents',
            'user_id' => $user->id,
            'is_sensitive' => true,
        ]);

        expect($media)->toBeInstanceOf(Media::class)
            ->and($media->file_name)->toBe('test-image.jpg')
            ->and($media->mime_type)->toBe('image/jpeg')
            ->and($media->is_encrypted)->toBeTrue();

        Storage::disk('local')->assertExists($media->getPath());
    });

    it('validates file types and sizes', function () {
        $user = User::factory()->create();

        // Valid file
        $validFile = UploadedFile::fake()->image('valid.jpg', 800, 600);
        $validMedia = Media::createFromUpload($validFile, ['user_id' => $user->id]);

        expect($validMedia)->toBeInstanceOf(Media::class);

        // Invalid file type
        $invalidFile = UploadedFile::fake()->create('malicious.exe', 1000);

        expect(function () use ($invalidFile, $user) {
            Media::createFromUpload($invalidFile, ['user_id' => $user->id]);
        })->toThrow(\Modules\Media\Exceptions\InvalidFileTypeException::class);
    });

    it('generates thumbnails for images', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('large-image.jpg', 2000, 1500);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'generate_thumbnails' => true,
        ]);

        expect($media->hasGeneratedConversion('thumb'))->toBeTrue()
            ->and($media->hasGeneratedConversion('preview'))->toBeTrue();

        $thumbnailPath = $media->getPath('thumb');
        Storage::disk('local')->assertExists($thumbnailPath);
    });

    it('extracts and stores metadata', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('metadata-test.jpg', 1024, 768);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'extract_metadata' => true,
        ]);

        expect($media->getCustomProperty('width'))->toBe(1024)
            ->and($media->getCustomProperty('height'))->toBe(768)
            ->and($media->size)->toBeGreaterThan(0);
    });
});
```

### 2. Patient Document Tests

```php
describe('Patient Document Business Logic', function () {
    it('creates patient documents with proper encryption', function () {
        $patient = Patient::factory()->create();
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('medical-report.pdf', 500);

        $document = PatientDocument::createSecureDocument($file, [
            'patient_id' => $patient->id,
            'document_type' => 'medical_report',
            'uploaded_by' => $user->id,
            'access_level' => 'restricted',
        ]);

        expect($document)->toBeInstanceOf(PatientDocument::class)
            ->and($document->is_encrypted)->toBeTrue()
            ->and($document->access_level)->toBe('restricted')
            ->and($document->patient_id)->toBe($patient->id);
    });

    it('enforces access controls based on user roles', function () {
        $patient = Patient::factory()->create();
        $doctor = User::factory()->create(['role' => 'doctor']);
        $nurse = User::factory()->create(['role' => 'nurse']);
        $admin = User::factory()->create(['role' => 'admin']);

        $document = PatientDocument::factory()->create([
            'patient_id' => $patient->id,
            'access_level' => 'doctor_only',
        ]);

        expect($document->canBeAccessedBy($doctor))->toBeTrue()
            ->and($document->canBeAccessedBy($nurse))->toBeFalse()
            ->and($document->canBeAccessedBy($admin))->toBeTrue();
    });

    it('logs all document access attempts', function () {
        $patient = Patient::factory()->create();
        $user = User::factory()->create();
        $document = PatientDocument::factory()->create(['patient_id' => $patient->id]);

        $document->recordAccess($user, 'view');

        $accessLog = $document->accessLogs()->latest()->first();

        expect($accessLog)->not->toBeNull()
            ->and($accessLog->user_id)->toBe($user->id)
            ->and($accessLog->action)->toBe('view')
            ->and($accessLog->accessed_at)->not->toBeNull();
    });

    it('handles document retention and expiration', function () {
        $document = PatientDocument::factory()->create([
            'retention_period' => '1_year',
            'created_at' => now()->subYears(2),
        ]);

        expect($document->isExpired())->toBeTrue()
            ->and($document->shouldBeDeleted())->toBeTrue();

        $recentDocument = PatientDocument::factory()->create([
            'retention_period' => '7_years',
            'created_at' => now()->subYears(2),
        ]);

        expect($recentDocument->isExpired())->toBeFalse()
            ->and($recentDocument->shouldBeDeleted())->toBeFalse();
    });
});
```

### 3. Image Processing Tests

```php
describe('Image Processing Business Logic', function () {
    it('converts images to standardized formats', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('test.png', 800, 600);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'convert_to' => 'jpg',
            'quality' => 85,
        ]);

        expect($media->mime_type)->toBe('image/jpeg')
            ->and($media->getExtensionAttribute())->toBe('jpg');
    });

    it('compresses images without significant quality loss', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('large.jpg', 3000, 2000);

        $originalSize = $file->getSize();

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'compress' => true,
            'max_width' => 1920,
            'quality' => 80,
        ]);

        expect($media->size)->toBeLessThan($originalSize)
            ->and($media->getCustomProperty('width'))->toBeLessThanOrEqual(1920)
            ->and($media->getCustomProperty('quality_score'))->toBeGreaterThan(0.7);
    });

    it('processes medical images with DICOM compliance', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('xray.dcm', 2000, 'application/dicom');

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'collection' => 'medical_images',
            'preserve_dicom_metadata' => true,
        ]);

        expect($media->mime_type)->toBe('application/dicom')
            ->and($media->getCustomProperty('is_medical_image'))->toBeTrue()
            ->and($media->getCustomProperty('dicom_metadata'))->not->toBeNull();
    });

    it('generates multiple conversion sizes', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->image('original.jpg', 2000, 1500);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'conversions' => ['thumb', 'medium', 'large'],
        ]);

        expect($media->hasGeneratedConversion('thumb'))->toBeTrue()
            ->and($media->hasGeneratedConversion('medium'))->toBeTrue()
            ->and($media->hasGeneratedConversion('large'))->toBeTrue();

        $thumbPath = $media->getPath('thumb');
        $mediumPath = $media->getPath('medium');

        Storage::disk('local')->assertExists($thumbPath);
        Storage::disk('local')->assertExists($mediumPath);
    });
});
```

### 4. Security Tests

```php
describe('Media Security Business Logic', function () {
    it('encrypts sensitive patient documents', function () {
        $patient = Patient::factory()->create();
        $file = UploadedFile::fake()->create('sensitive-report.pdf', 1000);

        $document = PatientDocument::createSecureDocument($file, [
            'patient_id' => $patient->id,
            'is_sensitive' => true,
            'encryption_required' => true,
        ]);

        expect($document->is_encrypted)->toBeTrue()
            ->and($document->encryption_key)->not->toBeNull()
            ->and($document->getDecryptedContent())->not->toBe($file->getContent());
    });

    it('scans uploaded files for malware', function () {
        $user = User::factory()->create();
        $cleanFile = UploadedFile::fake()->image('clean.jpg', 800, 600);

        $media = Media::createFromUpload($cleanFile, [
            'user_id' => $user->id,
            'scan_for_malware' => true,
        ]);

        expect($media->getCustomProperty('malware_scan_result'))->toBe('clean')
            ->and($media->getCustomProperty('scan_timestamp'))->not->toBeNull();
    });

    it('validates file integrity with checksums', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('document.pdf', 1000);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'generate_checksum' => true,
        ]);

        expect($media->getCustomProperty('checksum'))->not->toBeNull()
            ->and($media->getCustomProperty('checksum_algorithm'))->toBe('sha256');

        $isValid = $media->validateIntegrity();
        expect($isValid)->toBeTrue();
    });

    it('implements secure file deletion', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('to-delete.pdf', 500);

        $media = Media::createFromUpload($file, ['user_id' => $user->id]);
        $filePath = $media->getPath();

        Storage::disk('local')->assertExists($filePath);

        $media->secureDelete();

        Storage::disk('local')->assertMissing($filePath);
        expect($media->fresh())->toBeNull();
    });
});
```

### 5. Integration Tests

```php
describe('Media Integration Tests', function () {
    it('integrates with patient management system', function () {
        $patient = Patient::factory()->create();
        $file = UploadedFile::fake()->image('patient-photo.jpg', 400, 400);

        $media = $patient->addMediaFromUpload($file, 'profile_photos');

        expect($patient->getMedia('profile_photos'))->toHaveCount(1)
            ->and($patient->getFirstMediaUrl('profile_photos'))->not->toBeEmpty();
    });

    it('handles bulk file uploads efficiently', function () {
        $user = User::factory()->create();
        $files = [];

        for ($i = 0; $i < 10; $i++) {
            $files[] = UploadedFile::fake()->image("bulk-{$i}.jpg", 800, 600);
        }

        $startTime = microtime(true);

        $mediaItems = Media::createBulkFromUploads($files, [
            'user_id' => $user->id,
            'collection' => 'bulk_upload',
        ]);

        $duration = microtime(true) - $startTime;

        expect($mediaItems)->toHaveCount(10)
            ->and($duration)->toBeLessThan(5.0); // Should complete in under 5 seconds
    });

    it('synchronizes with external storage systems', function () {
        $user = User::factory()->create();
        $file = UploadedFile::fake()->create('sync-test.pdf', 1000);

        $media = Media::createFromUpload($file, [
            'user_id' => $user->id,
            'sync_to_external' => true,
            'external_storage' => 's3',
        ]);

        expect($media->getCustomProperty('external_sync_status'))->toBe('completed')
            ->and($media->getCustomProperty('external_url'))->not->toBeNull();
    });

    it('generates audit reports for compliance', function () {
        $patient = Patient::factory()->create();
        $user = User::factory()->create();

        // Create multiple documents with access logs
        $documents = PatientDocument::factory()->count(5)->create([
            'patient_id' => $patient->id,
        ]);

        foreach ($documents as $document) {
            $document->recordAccess($user, 'view');
            $document->recordAccess($user, 'download');
        }

        $auditReport = MediaAuditReport::generateForPatient($patient);

        expect($auditReport)->toHaveKey('total_documents')
            ->and($auditReport)->toHaveKey('access_events')
            ->and($auditReport['total_documents'])->toBe(5)
            ->and($auditReport['access_events'])->toBeGreaterThan(0);
    });
});
```

### 6. Performance Tests

```php
describe('Media Performance Tests', function () {
    it('handles large file uploads efficiently', function () {
        $user = User::factory()->create();
        $largeFile = UploadedFile::fake()->create('large-file.pdf', 50000); // 50MB

        $startTime = microtime(true);

        $media = Media::createFromUpload($largeFile, [
            'user_id' => $user->id,
            'chunk_upload' => true,
        ]);

        $duration = microtime(true) - $startTime;

        expect($media)->toBeInstanceOf(Media::class)
            ->and($duration)->toBeLessThan(30.0); // Should complete in under 30 seconds
    });

    it('optimizes storage usage through compression', function () {
        $user = User::factory()->create();
        $files = [];

        // Create multiple large images
        for ($i = 0; $i < 5; $i++) {
            $files[] = UploadedFile::fake()->image("large-{$i}.jpg", 2000, 1500);
        }

        $totalOriginalSize = array_sum(array_map(fn($file) => $file->getSize(), $files));

        $mediaItems = [];
        foreach ($files as $file) {
            $mediaItems[] = Media::createFromUpload($file, [
                'user_id' => $user->id,
                'compress' => true,
                'quality' => 75,
            ]);
        }

        $totalCompressedSize = array_sum(array_map(fn($media) => $media->size, $mediaItems));

        expect($totalCompressedSize)->toBeLessThan($totalOriginalSize * 0.8); // At least 20% reduction
    });
});
```

## Quality Standards

### Test Requirements

- All tests use `declare(strict_types=1);`
- Descriptive test names explaining media scenarios
- Complete setup and teardown for file operations
- Meaningful assertions covering security and compliance
- Performance benchmarks for file operations

### Business Logic Focus

- File security and encryption
- Access control and audit trails
- Image processing and optimization
- Healthcare compliance requirements
- Performance under load

### Healthcare Compliance

- Patient document privacy protection
- Medical image processing accuracy
- Audit trail completeness
- Data retention compliance
- Security incident response

---

**Last Updated**: 2025-08-28
**Testing Framework**: Pest
**Environment**: .env.testing
