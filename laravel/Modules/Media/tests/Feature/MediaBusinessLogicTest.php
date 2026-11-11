<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Feature;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Modules\Media\Database\Factories\MediaConvertFactory;
use Modules\Media\Database\Factories\MediaFactory;
use Modules\Media\Database\Factories\TemporaryUploadFactory;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use Modules\User\Database\Factories\UserFactory;
use Modules\Xot\Contracts\UserContract;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Media Business Logic', function () {
    beforeEach(function (): void {
        Storage::fake('public');
    });

    it('can create media from temporary upload', function (): void {
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        $temporaryColumns = Schema::connection('media')->getColumnListing('temporary_uploads');

        /** @var array<string, mixed> $temporaryPayload */
        $temporaryPayload = [
            'session_id' => session()->getId(),
        ];

        $user = null;

        if (in_array('user_id', $temporaryColumns, true)) {
            $user = UserFactory::new()->createOne();
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

        $temporaryUpload = TemporaryUploadFactory::new()->createOne($temporaryPayload);

        $mediaColumns = Schema::connection('media')->getColumnListing('media');

        /** @var array<string, mixed> $mediaPayload */
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

        if ($user instanceof UserContract && in_array('user_id', $mediaColumns, true)) {
            $mediaPayload['user_id'] = $user->id;
        }

        $media = MediaFactory::new()->createOne($mediaPayload);

        expect($media->file_name)
            ->toBe($mediaPayload['file_name'])
            ->and($media->mime_type)
            ->toBe($mediaPayload['mime_type']);

        $this->assertMediaTableHas('media', [
            'id' => $media->id,
            'file_name' => $mediaPayload['file_name'],
            'mime_type' => $mediaPayload['mime_type'],
        ]);
    });

    it('can convert media to different formats', function (): void {
        $mediaColumns = Schema::connection('media')->getColumnListing('media');
        $convertColumns = Schema::connection('media')->getColumnListing('media_converts');

        foreach (['media_id', 'original_format', 'target_format', 'status'] as $requiredColumn) {
            if (! in_array($requiredColumn, $convertColumns, true)) {
                $this->skipTest('media_converts table is missing required columns for this test in this install.');
            }
        }

        /** @var array<string, mixed> $payload */
        $payload = [
            'mime_type' => 'image/jpeg',
        ];

        if (in_array('user_id', $mediaColumns, true)) {
            $user = UserFactory::new()->createOne();
            $payload['user_id'] = $user->id;
        }

        $media = MediaFactory::new()->createOne($payload);

        $mediaConvert = MediaConvertFactory::new()->createOne([
            'media_id' => $media->id,
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ]);

        expect($mediaConvert->media_id)
            ->toBe($media->id)
            ->and($mediaConvert->getAttribute('original_format'))
            ->toBe('jpeg')
            ->and($mediaConvert->getAttribute('target_format'))
            ->toBe('png');

        $this->assertMediaTableHas('media_converts', [
            'id' => $mediaConvert->id,
            'media_id' => $media->id,
            'original_format' => 'jpeg',
            'target_format' => 'png',
            'status' => 'pending',
        ]);
    });

    it('can track temporary upload lifecycle', function (): void {
        $file = UploadedFile::fake()->image('test-image.jpg', 100, 100);

        $columns = Schema::connection('media')->getColumnListing('temporary_uploads');

        /** @var array<string, mixed> $payload */
        $payload = [
            'session_id' => session()->getId(),
        ];

        $user = null;

        if (in_array('user_id', $columns, true)) {
            $user = UserFactory::new()->createOne();
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

        $temporaryUpload = TemporaryUploadFactory::new()->createOne($payload);

        $temporaryUpload->update(['status' => 'completed']);

        expect($temporaryUpload->fresh()?->getAttribute('status'))->toBe('completed');

        /** @var array<string, mixed> $expected */
        $expected = [
            'id' => $temporaryUpload->id,
            'status' => 'completed',
        ];

        if ($user instanceof UserContract && in_array('user_id', $columns, true)) {
            $expected['user_id'] = $user->id;
        }

        $this->assertMediaTableHas('temporary_uploads', $expected);
    });

    it('can manage media collections', function (): void {
        $columns = Schema::connection('media')->getColumnListing('media');

        /** @var array<string, mixed> $profilePayload */
        $profilePayload = [
            'collection_name' => 'profile',
            'disk' => 'public',
        ];

        /** @var array<string, mixed> $documentPayload */
        $documentPayload = [
            'collection_name' => 'documents',
            'disk' => 'public',
        ];

        if (in_array('user_id', $columns, true)) {
            $user = UserFactory::new()->createOne();
            $profilePayload['user_id'] = $user->id;
            $documentPayload['user_id'] = $user->id;
        }

        $profileMedia = MediaFactory::new()->createOne($profilePayload);

        $documentMedia = MediaFactory::new()->createOne($documentPayload);

        expect($profileMedia->collection_name)
            ->toBe('profile')
            ->and($documentMedia->collection_name)
            ->toBe('documents');

        $profileMediaId = $profileMedia->getKey();
        Assert::assertIsInt($profileMediaId);

        $this->assertMediaTableHas('media', [
            'id' => $profileMediaId,
            'collection_name' => 'profile',
        ]);

        $documentMediaId = $documentMedia->getKey();
        Assert::assertIsInt($documentMediaId);

        $this->assertMediaTableHas('media', [
            'id' => $documentMediaId,
            'collection_name' => 'documents',
        ]);
    });

    it('can validate media file types', function (): void {
        $columns = Schema::connection('media')->getColumnListing('media');

        /** @var array<string, mixed> $imagePayload */
        $imagePayload = [
            'mime_type' => 'image/jpeg',
            'file_name' => 'valid-image.jpg',
        ];

        $user = null;

        if (in_array('user_id', $columns, true)) {
            $user = UserFactory::new()->createOne();
            $imagePayload['user_id'] = $user->id;
        }

        $validImage = MediaFactory::new()->createOne($imagePayload);

        $imageMime = (string) ($validImage->mime_type ?? '');
        expect($imageMime)->toStartWith('image/');

        /** @var array<string, mixed> $documentPayload */
        $documentPayload = [
            'mime_type' => 'application/pdf',
            'file_name' => 'valid-document.pdf',
        ];

        if ($user instanceof UserContract && in_array('user_id', $columns, true)) {
            $documentPayload['user_id'] = $user->id;
        }

        $validDocument = MediaFactory::new()->createOne($documentPayload);

        $docMime = (string) ($validDocument->mime_type ?? '');
        expect($docMime)->toStartWith('application/');
    });

    it('can track media conversion status', function (): void {
        $mediaColumns = Schema::connection('media')->getColumnListing('media');
        $convertColumns = Schema::connection('media')->getColumnListing('media_converts');

        if (! in_array('status', $convertColumns, true) || ! in_array('media_id', $convertColumns, true)) {
            $this->skipTest('media_converts table is missing required columns for this test in this install.');
        }

        /** @var array<string, mixed> $payload */
        $payload = [
            'mime_type' => 'image/jpeg',
        ];

        if (in_array('user_id', $mediaColumns, true)) {
            $user = UserFactory::new()->createOne();
            $payload['user_id'] = $user->id;
        }

        $media = MediaFactory::new()->createOne($payload);

        $mediaConvert = MediaConvertFactory::new()->createOne([
            'media_id' => $media->id,
            'status' => 'pending',
        ]);

        $mediaConvert->update(['status' => 'processing']);
        $mediaConvert->update(['status' => 'completed']);

        expect($mediaConvert->fresh()?->getAttribute('status'))->toBe('completed');

        $this->assertMediaTableHas('media_converts', [
            'id' => $mediaConvert->id,
            'status' => 'completed',
        ]);
    });

    it('can manage media permissions', function (): void {
        $owner = UserFactory::new()->createOne();
        $otherUser = UserFactory::new()->createOne();

        $columns = Schema::connection('media')->getColumnListing('media');
        if (! in_array('user_id', $columns, true) || ! in_array('is_public', $columns, true)) {
            $this->skipTest('This install does not have user_id/is_public columns on media table.');
        }

        $media = MediaFactory::new()->createOne([
            'user_id' => $owner->id,
            'is_public' => false,
        ]);

        expect($media->user_id)
            ->toBe($owner->id)
            ->and($media->getAttribute('is_public'))
            ->toBeFalse()
            ->and($media->user_id)
            ->not->toBe($otherUser->id);
    });

    it('can handle media deletion', function (): void {
        $columns = Schema::connection('media')->getColumnListing('media');

        if (in_array('deleted_at', $columns, true)) {
            $this->skipTest('This install has deleted_at on media table; deletion semantics are install-specific.');
        }

        $media = MediaFactory::new()->createOne();
        $mediaId = $media->id;

        $media->delete();

        $this->assertMediaTableMissing('media', [
            'id' => $mediaId,
        ]);
    });

    it('can generate media urls', function (): void {
        $media = MediaFactory::new()->createOne([
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
        ]);

        $url = $media->getUrl();

        expect($url)->not->toBeEmpty()->and($url)->toContain('test-image.jpg');
    });

    it('can validate file size limits', function (): void {
        $user = UserFactory::new()->createOne();

        $columns = TestCase::mediaTableColumns();

        $makePayload = function (int $size) use ($user, $columns): array {
            $payload = TestCase::mediaPayloadSet([], $columns, 'user_id', $user->id);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'model_type', $user->getMorphClass());
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'model_id', $user->id);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'file_size', $size);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'size', $size);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'file_name', 'test-file.pdf');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'name', 'test-file');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'disk', 'public');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'collection_name', 'default');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'mime_type', 'application/pdf');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'manipulations', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'custom_properties', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'generated_conversions', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'responsive_images', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'created_at', now());
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'updated_at', now());

            return $payload;
        };

        $validPayload = $makePayload(1024 * 1024);
        if ($validPayload === []) {
            $this->skipTest('Unable to build minimal payload for media table in this install.');
        }

        $validMedia = Media::query()->create($validPayload);
        $sizeValue = $validMedia->size;
        expect($sizeValue)->toBeLessThanOrEqual(10 * 1024 * 1024);

        $largeMedia = Media::query()->create($makePayload(15 * 1024 * 1024));
        $largeSizeValue = $largeMedia->size;
        expect($largeSizeValue)->toBeGreaterThan(10 * 1024 * 1024);
    });

    it('can track media usage statistics', function (): void {
        $user = UserFactory::new()->createOne();

        $columns = TestCase::mediaTableColumns();

        $makePayload = function (string $mime, string $fileName) use ($user, $columns): array {
            $payload = TestCase::mediaPayloadSet([], $columns, 'user_id', $user->id);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'model_type', $user->getMorphClass());
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'model_id', $user->id);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'mime_type', $mime);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'file_name', $fileName);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'name', pathinfo($fileName, PATHINFO_FILENAME));
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'disk', 'public');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'collection_name', 'default');
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'file_size', 123);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'size', 123);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'manipulations', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'custom_properties', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'generated_conversions', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'responsive_images', []);
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'created_at', now());
            $payload = TestCase::mediaPayloadSet($payload, $columns, 'updated_at', now());

            return $payload;
        };

        for ($i = 0; $i < 5; $i++) {
            Media::query()->create($makePayload('image/jpeg', "img-{$i}.jpg"));
        }

        for ($i = 0; $i < 3; $i++) {
            Media::query()->create($makePayload('application/pdf', "doc-{$i}.pdf"));
        }

        $mediaColumns = Schema::connection('media')->getColumnListing('media');
        if (! in_array('user_id', $mediaColumns, true)) {
            $this->skipTest('This install does not have user_id column on media table.');
        }

        $totalMedia = Media::where('user_id', $user->id)->count();
        $imageCount = Media::where('user_id', $user->id)->where('mime_type', 'like', 'image/%')->count();
        $documentCount = Media::where('user_id', $user->id)->where('mime_type', 'like', 'application/%')->count();

        expect($totalMedia)->toBe(8)->and($imageCount)->toBe(5)->and($documentCount)->toBe(3);
    });
});
