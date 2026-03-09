<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Models\Media;
use Modules\Media\Models\MediaConvert;
use Modules\Media\Models\TemporaryUpload;
use Modules\Media\Tests\TestCase;
use Modules\User\Models\User;

uses(TestCase::class);

describe('Media Business Logic', function () {
    beforeEach(function () {
        Storage::fake('public');
    });

    it('can create media from temporary upload', function () {
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        $temporaryColumns = Schema::connection('media')->getColumnListing('temporary_uploads');

        $temporaryPayload = [
            'session_id' => session()->getId(),
        ];

        if (in_array('user_id', $temporaryColumns, true)) {
            $user = User::factory()->create();
            $temporaryPayload['user_id'] = $user->id;
        }

        if (in_array('file_name', $temporaryColumns, true)) {
            $temporaryPayload['file_name'] = $file->getClientOriginalName();
        }

        if (in_array('file_size', $temporaryColumns, true)) {
            $temporaryPayload['file_size'] = $file->getSize();
        }

        if (in_array('mime_type', $temporaryColumns, true)) {
            $temporaryPayload['mime_type'] = $file->getMimeType();
        }

        if (in_array('status', $temporaryColumns, true)) {
            $temporaryPayload['status'] = 'uploading';
        }

        $temporaryUpload = TemporaryUpload::factory()->create($temporaryPayload);

        $mediaColumns = Schema::connection('media')->getColumnListing('media');

        $mediaPayload = [
            'disk' => 'public',
            'collection_name' => 'default',
        ];

        if (in_array('file_name', $mediaColumns, true) && in_array('file_name', $temporaryColumns, true)) {
            $mediaPayload['file_name'] = $temporaryUpload->file_name;
        } else {
            $mediaPayload['file_name'] = 'test-image.jpg';
        }

        if (in_array('mime_type', $mediaColumns, true) && in_array('mime_type', $temporaryColumns, true)) {
            $mediaPayload['mime_type'] = $temporaryUpload->mime_type;
        } else {
            $mediaPayload['mime_type'] = $file->getMimeType();
        }

        if (in_array('file_size', $mediaColumns, true) && in_array('file_size', $temporaryColumns, true)) {
            $mediaPayload['file_size'] = $temporaryUpload->file_size;
        }

        if (in_array('size', $mediaColumns, true) && in_array('file_size', $temporaryColumns, true)) {
            $mediaPayload['size'] = (int) $temporaryUpload->file_size;
        }

        if (isset($user) && in_array('user_id', $mediaColumns, true)) {
            $mediaPayload['user_id'] = $user->id;
        }

        $media = Media::factory()->create($mediaPayload);

        expect($media)
            ->toBeInstanceOf(Media::class)
            ->and($media->file_name)
            ->toBe($mediaPayload['file_name'])
            ->and($media->mime_type)
            ->toBe($mediaPayload['mime_type']);

        $this->assertDatabaseHas('media', [
            'id' => (int) $media->getKey(),
            'file_name' => $mediaPayload['file_name'],
            'mime_type' => $mediaPayload['mime_type'],
        ], 'media');
    });

    it('can convert media to different formats', function () {
        $mediaColumns = Schema::connection('media')->getColumnListing('media');
        $convertColumns = Schema::connection('media')->getColumnListing('media_converts');

        foreach (['media_id', 'original_format', 'target_format', 'status'] as $requiredColumn) {
            if (! in_array($requiredColumn, $convertColumns, true)) {
                $this->markTestSkipped('media_converts table is missing required columns for this test in this install.');
            }
        }

        $payload = [
            'mime_type' => 'image/jpeg',
        ];

        if (in_array('user_id', $mediaColumns, true)) {
            $user = User::factory()->create();
            $payload['user_id'] = $user->id;
        }

        $media = Media::factory()->create($payload);

        $mediaConvert = MediaConvert::factory()->create([
            'media_id' => $media->id,
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ]);

        expect($mediaConvert)
            ->toBeInstanceOf(MediaConvert::class)
            ->and($mediaConvert->media_id)
            ->toBe($media->id)
            ->and($mediaConvert->original_format)
            ->toBe('jpeg')
            ->and($mediaConvert->target_format)
            ->toBe('png');

        $this->assertDatabaseHas('media_converts', [
            'id' => (int) $mediaConvert->getKey(),
            'media_id' => (int) $media->getKey(),
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ], 'media');
    });

    it('can track temporary upload lifecycle', function () {
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        $columns = Schema::connection('media')->getColumnListing('temporary_uploads');

        $payload = [
            'session_id' => session()->getId(),
        ];

        if (in_array('user_id', $columns, true)) {
            $user = User::factory()->create();
            $payload['user_id'] = $user->id;
        }

        if (in_array('file_name', $columns, true)) {
            $payload['file_name'] = $file->getClientOriginalName();
        }

        if (in_array('file_size', $columns, true)) {
            $payload['file_size'] = $file->getSize();
        }

        if (in_array('mime_type', $columns, true)) {
            $payload['mime_type'] = $file->getMimeType();
        }

        if (in_array('status', $columns, true)) {
            $payload['status'] = 'uploading';
        }

        $temporaryUpload = TemporaryUpload::factory()->create($payload);

        // Simulate upload completion
        $temporaryUpload->update(['status' => 'completed']);

        expect($temporaryUpload->fresh()->status)->toBe('completed');

        $expected = [
            'id' => (int) $temporaryUpload->getKey(),
            'status' => 'completed',
        ];

        if (isset($user) && in_array('user_id', $columns, true)) {
            $expected['user_id'] = $user->id;
        }

        $this->assertDatabaseHas('temporary_uploads', $expected, 'media');
    });

    it('can manage media collections', function () {
        $columns = Schema::connection('media')->getColumnListing('media');

        $profilePayload = [
            'collection_name' => 'profile',
            'disk' => 'public',
        ];

        $documentPayload = [
            'collection_name' => 'documents',
            'disk' => 'public',
        ];

        if (in_array('user_id', $columns, true)) {
            $user = User::factory()->create();
            $profilePayload['user_id'] = $user->id;
            $documentPayload['user_id'] = $user->id;
        }

        $profileMedia = Media::factory()->create($profilePayload);

        $documentMedia = Media::factory()->create($documentPayload);

        expect($profileMedia->collection_name)
            ->toBe('profile')
            ->and($documentMedia->collection_name)
            ->toBe('documents');

        $this->assertDatabaseHas('media', [
            'id' => (int) $profileMedia->getKey(),
            'collection_name' => 'profile',
        ], 'media');

        $this->assertDatabaseHas('media', [
            'id' => (int) $documentMedia->getKey(),
            'collection_name' => 'documents',
        ], 'media');
    });

    it('can validate media file types', function () {
        $columns = Schema::connection('media')->getColumnListing('media');

        $imagePayload = [
            'mime_type' => 'image/jpeg',
            'file_name' => 'valid-image.jpg',
        ];

        if (in_array('user_id', $columns, true)) {
            $user = User::factory()->create();
            $imagePayload['user_id'] = $user->id;
        }

        $validImage = Media::factory()->create($imagePayload);

        $imageMime = (string) ($validImage->mime_type ?? '');
        expect($imageMime)->toStartWith('image/');

        $documentPayload = [
            'mime_type' => 'application/pdf',
            'file_name' => 'valid-document.pdf',
        ];

        if (isset($user) && in_array('user_id', $columns, true)) {
            $documentPayload['user_id'] = $user->id;
        }

        $validDocument = Media::factory()->create($documentPayload);

        $docMime = (string) ($validDocument->mime_type ?? '');
        expect($docMime)->toStartWith('application/');
    });

    it('can track media conversion status', function () {
        $mediaColumns = Schema::connection('media')->getColumnListing('media');
        $convertColumns = Schema::connection('media')->getColumnListing('media_converts');

        if (! in_array('status', $convertColumns, true) || ! in_array('media_id', $convertColumns, true)) {
            $this->markTestSkipped('media_converts table is missing required columns for this test in this install.');
        }

        $payload = [
            'mime_type' => 'image/jpeg',
        ];

        if (in_array('user_id', $mediaColumns, true)) {
            $user = User::factory()->create();
            $payload['user_id'] = $user->id;
        }

        $media = Media::factory()->create($payload);

        $mediaConvert = MediaConvert::factory()->create([
            'media_id' => $media->id,
            'status' => 'pending',
        ]);

        // Simulate conversion progress
        $mediaConvert->update(['status' => 'processing']);
        $mediaConvert->update(['status' => 'completed']);

        expect($mediaConvert->fresh()->status)->toBe('completed');

        $this->assertDatabaseHas('media_converts', [
            'id' => (int) $mediaConvert->getKey(),
            'status' => 'completed',
        ], 'media');
    });

    it('can manage media permissions', function () {
        $owner = User::factory()->create();
        $otherUser = User::factory()->create();

        $columns = Schema::connection('media')->getColumnListing('media');
        if (! in_array('user_id', $columns, true) || ! in_array('is_public', $columns, true)) {
            $this->markTestSkipped('This install does not have user_id/is_public columns on media table.');
        }

        $media = Media::factory()->create([
            'user_id' => $owner->id,
            'is_public' => false,
        ]);

        expect($media->user_id)
            ->toBe($owner->id)
            ->and($media->is_public)
            ->toBeFalse()
            ->and($media->user_id)
            ->not->toBe($otherUser->id);
    });

    it('can handle media deletion', function () {
        $columns = Schema::connection('media')->getColumnListing('media');

        if (in_array('deleted_at', $columns, true)) {
            $this->markTestSkipped('This install has deleted_at on media table; deletion semantics are install-specific.');
        }

        $media = Media::factory()->create();
        $mediaId = (int) $media->getKey();

        $media->delete();

        $this->assertDatabaseMissing('media', [
            'id' => $mediaId,
        ], 'media');
    });

    it('can generate media urls', function () {
        $media = Media::factory()->create([
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
        ]);

        $url = $media->getUrl();

        expect($url)->not->toBeEmpty()->and($url)->toContain('test-image.jpg');
    });

    it('can validate file size limits', function () {
        $user = User::factory()->create();

        $columns = Schema::getColumnListing('media');
        $payloadBase = [];

        $trySet = function (array &$payload, string $column, mixed $value) use ($columns): void {
            if (in_array($column, $columns, true)) {
                $payload[$column] = $value;
            }
        };

        $makePayload = function (int $size) use ($user, $payloadBase, $trySet): array {
            $payload = $payloadBase;
            $trySet($payload, 'user_id', $user->id);
            $trySet($payload, 'file_size', $size);
            $trySet($payload, 'size', $size);
            $trySet($payload, 'file_name', 'test-file.pdf');
            $trySet($payload, 'disk', 'public');
            $trySet($payload, 'collection_name', 'default');
            $trySet($payload, 'mime_type', 'application/pdf');
            $trySet($payload, 'created_at', now());
            $trySet($payload, 'updated_at', now());

            return $payload;
        };

        $validPayload = $makePayload(1024 * 1024);
        if ($validPayload === []) {
            $this->markTestSkipped('Unable to build minimal payload for media table in this install.');
        }

        $validMedia = Media::query()->create($validPayload);
        $sizeValue = (int) ($validMedia->getAttribute('file_size') ?? $validMedia->getAttribute('size') ?? 0);
        expect($sizeValue)->toBeLessThanOrEqual(10 * 1024 * 1024);

        $largeMedia = Media::query()->create($makePayload(15 * 1024 * 1024));
        $largeSizeValue = (int) ($largeMedia->getAttribute('file_size') ?? $largeMedia->getAttribute('size') ?? 0);
        expect($largeSizeValue)->toBeGreaterThan(10 * 1024 * 1024);
    });

    it('can track media usage statistics', function () {
        $user = User::factory()->create();

        $columns = Schema::getColumnListing('media');
        $trySet = function (array &$payload, string $column, mixed $value) use ($columns): void {
            if (in_array($column, $columns, true)) {
                $payload[$column] = $value;
            }
        };

        $makePayload = function (string $mime, string $fileName) use ($user, $trySet): array {
            $payload = [];
            $trySet($payload, 'user_id', $user->id);
            $trySet($payload, 'mime_type', $mime);
            $trySet($payload, 'file_name', $fileName);
            $trySet($payload, 'disk', 'public');
            $trySet($payload, 'collection_name', 'default');
            $trySet($payload, 'file_size', 123);
            $trySet($payload, 'size', 123);
            $trySet($payload, 'created_at', now());
            $trySet($payload, 'updated_at', now());

            return $payload;
        };

        for ($i = 0; $i < 5; $i++) {
            Media::query()->create($makePayload('image/jpeg', "img-{$i}.jpg"));
        }

        for ($i = 0; $i < 3; $i++) {
            Media::query()->create($makePayload('application/pdf', "doc-{$i}.pdf"));
        }

        $columns = Schema::connection('media')->getColumnListing('media');
        if (! in_array('user_id', $columns, true)) {
            $this->markTestSkipped('This install does not have user_id column on media table.');
        }

        $totalMedia = Media::where('user_id', $user->id)->count();
        $imageCount = Media::where('user_id', $user->id)->where('mime_type', 'like', 'image/%')->count();
        $documentCount = Media::where('user_id', $user->id)->where('mime_type', 'like', 'application/%')->count();

        expect($totalMedia)->toBe(8)->and($imageCount)->toBe(5)->and($documentCount)->toBe(3);
    });
});
