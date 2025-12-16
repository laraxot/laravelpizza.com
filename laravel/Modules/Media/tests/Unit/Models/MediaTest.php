<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Modules\Media\Models\Media;
use Tests\TestCase;

class MediaTest extends TestCase
{
    use RefreshDatabase;

    public function test_can_create_media_with_minimal_data(): void
    {
        $media = Media::factory()->create([
            'model_type' => 'App\Models\User',
            'model_id' => '1',
            'collection_name' => 'avatars',
            'name' => 'test-image',
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
            'size' => 1024,
        ]);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'model_type' => 'App\Models\User',
            'model_id' => '1',
            'collection_name' => 'avatars',
            'name' => 'test-image',
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
            'size' => 1024,
        ]);
    }

    public function test_can_create_media_with_all_fields(): void
    {
        $mediaData = [
            'model_type' => 'App\Models\Post',
            'model_id' => '123',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'collection_name' => 'images',
            'name' => 'full-image',
            'file_name' => 'full-image.png',
            'mime_type' => 'image/png',
            'disk' => 's3',
            'conversions_disk' => 's3-conversions',
            'size' => 2048,
            'manipulations' => ['resize' => ['width' => 800, 'height' => 600]],
            'custom_properties' => ['alt' => 'Test Image', 'caption' => 'A test image'],
            'generated_conversions' => ['thumb' => true, 'medium' => true],
            'responsive_images' => ['thumb' => 'thumb.jpg', 'medium' => 'medium.jpg'],
            'order_column' => 1,
            'directory' => 'posts/images',
            'path' => 'posts/images/full-image.png',
            'width' => 1920,
            'height' => 1080,
            'type' => 'image',
            'ext' => 'png',
            'alt' => 'Alternative text',
            'title' => 'Image title',
            'description' => 'Image description',
            'caption' => 'Image caption',
            'exif' => ['camera' => 'Canon', 'iso' => 100],
            'curations' => ['featured' => true, 'gallery' => false],
        ];

        $media = Media::factory()->create($mediaData);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'model_type' => 'App\Models\Post',
            'model_id' => '123',
            'uuid' => '550e8400-e29b-41d4-a716-446655440000',
            'collection_name' => 'images',
            'name' => 'full-image',
            'file_name' => 'full-image.png',
            'mime_type' => 'image/png',
            'disk' => 's3',
            'conversions_disk' => 's3-conversions',
            'size' => 2048,
            'order_column' => 1,
            'directory' => 'posts/images',
            'path' => 'posts/images/full-image.png',
            'width' => 1920,
            'height' => 1080,
            'type' => 'image',
            'ext' => 'png',
            'alt' => 'Alternative text',
            'title' => 'Image title',
            'description' => 'Image description',
            'caption' => 'Image caption',
        ]);

        // Verifica campi JSON
        static::assertSame(['resize' => ['width' => 800, 'height' => 600]], $media->manipulations);
        static::assertSame(['alt' => 'Test Image', 'caption' => 'A test image'], $media->custom_properties);
        static::assertSame(['thumb' => true, 'medium' => true], $media->generated_conversions);
        static::assertSame(['thumb' => 'thumb.jpg', 'medium' => 'medium.jpg'], $media->responsive_images);
        static::assertSame(['camera' => 'Canon', 'iso' => 100], $media->exif);
        static::assertSame(['featured' => true, 'gallery' => false], $media->curations);
    }

    public function test_media_has_soft_deletes(): void
    {
        $media = Media::factory()->create();
        $mediaId = $media->id;

        $media->delete();

        $this->assertSoftDeleted('media', ['id' => $mediaId]);
        $this->assertDatabaseMissing('media', ['id' => $mediaId]);
    }

    public function test_can_restore_soft_deleted_media(): void
    {
        $media = Media::factory()->create();
        $mediaId = $media->id;

        $media->delete();
        $this->assertSoftDeleted('media', ['id' => $mediaId]);

        $restoredMedia = Media::withTrashed()->find($mediaId);
        $restoredMedia->restore();

        $this->assertDatabaseHas('media', ['id' => $mediaId]);
        static::assertNull($restoredMedia->deleted_at);
    }

    public function test_can_find_media_by_model_type(): void
    {
        $media = Media::factory()->create(['model_type' => 'App\Models\UniqueModel']);

        $foundMedia = Media::where('model_type', 'App\Models\UniqueModel')->first();

        static::assertNotNull($foundMedia);
        static::assertSame($media->id, $foundMedia->id);
    }

    public function test_can_find_media_by_model_id(): void
    {
        $media = Media::factory()->create(['model_id' => '999']);

        $foundMedia = Media::where('model_id', '999')->first();

        static::assertNotNull($foundMedia);
        static::assertSame($media->id, $foundMedia->id);
    }

    public function test_can_find_media_by_collection_name(): void
    {
        Media::factory()->create(['collection_name' => 'avatars']);
        Media::factory()->create(['collection_name' => 'images']);
        Media::factory()->create(['collection_name' => 'documents']);

        $avatarMedia = Media::where('collection_name', 'avatars')->get();

        static::assertCount(1, $avatarMedia);
        static::assertSame('avatars', $avatarMedia->first()->collection_name);
    }

    public function test_can_find_media_by_name(): void
    {
        $media = Media::factory()->create(['name' => 'unique-media-name']);

        $foundMedia = Media::where('name', 'unique-media-name')->first();

        static::assertNotNull($foundMedia);
        static::assertSame($media->id, $foundMedia->id);
    }

    public function test_can_find_media_by_file_name(): void
    {
        $media = Media::factory()->create(['file_name' => 'unique-file.jpg']);

        $foundMedia = Media::where('file_name', 'unique-file.jpg')->first();

        static::assertNotNull($foundMedia);
        static::assertSame($media->id, $foundMedia->id);
    }

    public function test_can_find_media_by_disk(): void
    {
        Media::factory()->create(['disk' => 'public']);
        Media::factory()->create(['disk' => 's3']);
        Media::factory()->create(['disk' => 'local']);

        $publicMedia = Media::where('disk', 'public')->get();

        static::assertCount(1, $publicMedia);
        static::assertSame('public', $publicMedia->first()->disk);
    }

    public function test_can_find_media_by_mime_type(): void
    {
        Media::factory()->create(['mime_type' => 'image/jpeg']);
        Media::factory()->create(['mime_type' => 'image/png']);
        Media::factory()->create(['mime_type' => 'application/pdf']);

        $jpegMedia = Media::where('mime_type', 'image/jpeg')->get();

        static::assertCount(1, $jpegMedia);
        static::assertSame('image/jpeg', $jpegMedia->first()->mime_type);
    }

    public function test_can_find_media_by_size_range(): void
    {
        Media::factory()->create(['size' => 512]);
        Media::factory()->create(['size' => 1024]);
        Media::factory()->create(['size' => 2048]);

        $largeMedia = Media::where('size', '>', 1000)->get();

        static::assertCount(2, $largeMedia);
        static::assertTrue($largeMedia->every(fn ($media) => $media->size > 1000));
    }

    public function test_can_find_media_by_type(): void
    {
        Media::factory()->create(['type' => 'image']);
        Media::factory()->create(['type' => 'video']);
        Media::factory()->create(['type' => 'document']);

        $imageMedia = Media::where('type', 'image')->get();

        static::assertCount(1, $imageMedia);
        static::assertSame('image', $imageMedia->first()->type);
    }

    public function test_can_find_media_by_extension(): void
    {
        Media::factory()->create(['ext' => 'jpg']);
        Media::factory()->create(['ext' => 'png']);
        Media::factory()->create(['ext' => 'pdf']);

        $jpgMedia = Media::where('ext', 'jpg')->get();

        static::assertCount(1, $jpgMedia);
        static::assertSame('jpg', $jpgMedia->first()->ext);
    }

    public function test_can_find_media_by_dimensions(): void
    {
        Media::factory()->create(['width' => 1920, 'height' => 1080]);
        Media::factory()->create(['width' => 800, 'height' => 600]);
        Media::factory()->create(['width' => 400, 'height' => 300]);

        $hdMedia = Media::where('width', '>=', 1920)->get();

        static::assertCount(1, $hdMedia);
        static::assertSame(1920, $hdMedia->first()->width);
    }

    public function test_can_find_media_by_name_pattern(): void
    {
        Media::factory()->create(['name' => 'profile-avatar']);
        Media::factory()->create(['name' => 'cover-image']);
        Media::factory()->create(['name' => 'logo-brand']);

        $profileMedia = Media::where('name', 'like', '%profile%')->get();

        static::assertCount(1, $profileMedia);
        static::assertTrue($profileMedia->every(fn ($media) => str_contains($media->name, 'profile')));
    }

    public function test_can_find_media_by_custom_properties(): void
    {
        Media::factory()->create([
            'custom_properties' => ['alt' => 'Profile picture', 'category' => 'avatar'],
        ]);

        Media::factory()->create([
            'custom_properties' => ['alt' => 'Cover image', 'category' => 'banner'],
        ]);

        $avatarMedia = Media::whereJsonContains('custom_properties->category', 'avatar')->get();

        static::assertCount(1, $avatarMedia);
        static::assertSame('avatar', $avatarMedia->first()->custom_properties['category']);
    }

    public function test_can_find_media_by_manipulations(): void
    {
        Media::factory()->create([
            'manipulations' => ['resize' => ['width' => 800, 'height' => 600]],
        ]);

        Media::factory()->create([
            'manipulations' => ['crop' => ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 300]],
        ]);

        $resizeMedia = Media::whereJsonContains('manipulations->resize', ['width' => 800, 'height' => 600])->get();

        static::assertCount(1, $resizeMedia);
        static::assertArrayHasKey('resize', $resizeMedia->first()->manipulations);
    }

    public function test_can_update_media(): void
    {
        $media = Media::factory()->create(['name' => 'Old Name']);

        $media->update(['name' => 'New Name']);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'name' => 'New Name',
        ]);
    }

    public function test_can_handle_null_values(): void
    {
        $media = Media::factory()->create([
            'model_type' => 'App\Models\Test',
            'model_id' => '1',
            'collection_name' => 'test',
            'name' => 'test',
            'file_name' => 'test.jpg',
            'disk' => 'public',
            'size' => 1024,
            'uuid' => null,
            'mime_type' => null,
            'conversions_disk' => null,
            'manipulations' => null,
            'custom_properties' => null,
            'generated_conversions' => null,
            'responsive_images' => null,
            'order_column' => null,
            'directory' => null,
            'path' => null,
            'width' => null,
            'height' => null,
            'type' => null,
            'ext' => null,
            'alt' => null,
            'title' => null,
            'description' => null,
            'caption' => null,
            'exif' => null,
            'curations' => null,
        ]);

        $this->assertDatabaseHas('media', [
            'id' => $media->id,
            'uuid' => null,
            'mime_type' => null,
            'conversions_disk' => null,
            'order_column' => null,
            'directory' => null,
            'path' => null,
            'width' => null,
            'height' => null,
            'type' => null,
            'ext' => null,
            'alt' => null,
            'title' => null,
            'description' => null,
            'caption' => null,
        ]);
    }

    public function test_can_find_media_by_multiple_criteria(): void
    {
        Media::factory()->create([
            'collection_name' => 'avatars',
            'type' => 'image',
            'ext' => 'jpg',
        ]);

        Media::factory()->create([
            'collection_name' => 'documents',
            'type' => 'document',
            'ext' => 'pdf',
        ]);

        $avatarImages = Media::where('collection_name', 'avatars')->where('type', 'image')->get();

        static::assertCount(1, $avatarImages);
        static::assertSame('avatars', $avatarImages->first()->collection_name);
        static::assertSame('image', $avatarImages->first()->type);
    }

    public function test_media_has_media_converts_relationship(): void
    {
        $media = Media::factory()->create();

        static::assertTrue(method_exists($media, 'mediaConverts'));
    }

    public function test_media_has_temporary_upload_relationship(): void
    {
        $media = Media::factory()->create();

        static::assertTrue(method_exists($media, 'temporaryUpload'));
    }

    public function test_media_has_creator_relationship(): void
    {
        $media = Media::factory()->create();

        static::assertTrue(method_exists($media, 'creator'));
    }

    public function test_media_can_get_url_conversion(): void
    {
        $media = Media::factory()->create([
            'file_name' => 'test-image.jpg',
            'directory' => 'test',
        ]);

        $thumbUrl = $media->getUrlConv('thumb');
        static::assertStringContainsString('thumb.jpg', $thumbUrl);

        $url800 = $media->getUrlConv('800');
        static::assertStringContainsString('800.jpg', $url800);

        $url400 = $media->getUrlConv('400');
        static::assertStringContainsString('400.jpg', $url400);
    }

    public function test_media_has_entry_conversions_attribute(): void
    {
        $media = Media::factory()->create([
            'generated_conversions' => ['thumb' => true, 'medium' => false],
        ]);

        $entryConversions = $media->entry_conversions;

        static::assertIsArray($entryConversions);
        static::assertCount(2, $entryConversions);
        static::assertArrayHasKey('name', $entryConversions[0]);
        static::assertArrayHasKey('generated', $entryConversions[0]);
        static::assertArrayHasKey('src', $entryConversions[0]);
    }

    public function test_media_has_factory(): void
    {
        $media = Media::factory()->create();

        static::assertNotNull($media->id);
        static::assertInstanceOf(Media::class, $media);
    }

    public function test_media_has_casts(): void
    {
        $media = new Media;

        $expectedCasts = [
            'id' => 'string',
            'uuid' => 'string',
            'created_at' => 'datetime',
            'updated_at' => 'datetime',
            'deleted_at' => 'datetime',
            'updated_by' => 'string',
            'created_by' => 'string',
            'deleted_by' => 'string',
            'manipulations' => 'array',
            'custom_properties' => 'array',
            'generated_conversions' => 'array',
            'responsive_images' => 'array',
        ];

        static::assertSame($expectedCasts, $media->getCasts());
    }
}
