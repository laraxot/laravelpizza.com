<?php

declare(strict_types=1);

use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;

uses(TestCase::class);

it('can create media with minimal data', function (): void {
    $media = Media::factory()->create([
        'model_type' => 'Modules\User\Models\User',
        'model_id' => '1',
        'collection_name' => 'avatars',
        'name' => 'test-image',
        'file_name' => 'test-image.jpg',
        'disk' => 'public',
        'size' => 1024,
    ]);

    $this->assertDatabaseHas('media', [
        'id' => (int) $media->getKey(),
        'collection_name' => 'avatars',
        'name' => 'test-image',
        'file_name' => 'test-image.jpg',
        'disk' => 'public',
        'size' => 1024,
    ], 'media');
});

it('can create media with all fields', function (): void {
    $mediaData = [
        'model_type' => 'App\\Models\\Post',
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
        'custom_properties' => [
            'alt' => 'Alternative text',
            'title' => 'Image title',
            'description' => 'Image description',
            'caption' => 'Image caption',
            'exif' => ['camera' => 'Canon', 'iso' => 100],
            'curations' => ['featured' => true, 'gallery' => false],
        ],
        'generated_conversions' => ['thumb' => true, 'medium' => true],
        'responsive_images' => ['thumb' => 'thumb.jpg', 'medium' => 'medium.jpg'],
        'order_column' => 1,
    ];

    $media = Media::factory()->create($mediaData);

    $this->assertDatabaseHas('media', [
        'id' => (int) $media->getKey(),
        'collection_name' => 'images',
        'name' => 'full-image',
        'file_name' => 'full-image.png',
        'mime_type' => 'image/png',
        'disk' => 's3',
        'conversions_disk' => 's3-conversions',
        'size' => 2048,
        'order_column' => 1,
    ], 'media');

    // Verifica campi JSON
    expect($media->manipulations)->toBe(['resize' => ['width' => 800, 'height' => 600]]);
    expect($media->custom_properties)->toBe([
        'alt' => 'Alternative text',
        'title' => 'Image title',
        'description' => 'Image description',
        'caption' => 'Image caption',
        'exif' => ['camera' => 'Canon', 'iso' => 100],
        'curations' => ['featured' => true, 'gallery' => false],
    ]);
    expect($media->generated_conversions)->toBe(['thumb' => true, 'medium' => true]);
    expect($media->responsive_images)->toBe(['thumb' => 'thumb.jpg', 'medium' => 'medium.jpg']);
});

it('media delete removes the record', function (): void {
    $media = Media::factory()->create();
    $mediaId = (int) $media->getKey();

    $media->delete();

    $this->assertDatabaseMissing('media', ['id' => $mediaId], 'media');
});

it('can find media by model type', function (): void {
    $media = Media::factory()->create(['model_type' => 'App\Models\UniqueModel']);

    $foundMedia = Media::where('model_type', 'App\Models\UniqueModel')->first();

    expect($foundMedia)->not()->toBeNull();
    expect($media->id)->toBe($foundMedia->id);
});

it('can find media by model id', function (): void {
    $media = Media::factory()->create(['model_id' => '999']);

    $foundMedia = Media::where('model_id', '999')->first();

    expect($foundMedia)->not()->toBeNull();
    expect($media->id)->toBe($foundMedia->id);
});

it('can find media by collection name', function (): void {
    Media::factory()->create(['collection_name' => 'avatars']);
    Media::factory()->create(['collection_name' => 'images']);
    Media::factory()->create(['collection_name' => 'documents']);

    $avatarMedia = Media::where('collection_name', 'avatars')->get();

    expect($avatarMedia)->toHaveCount(1);
    expect($avatarMedia->first()->collection_name)->toBe('avatars');
});

it('can find media by name', function (): void {
    $media = Media::factory()->create(['name' => 'unique-media-name']);

    $foundMedia = Media::where('name', 'unique-media-name')->first();

    expect($foundMedia)->not()->toBeNull();
    expect($media->id)->toBe($foundMedia->id);
});

it('can find media by file name', function (): void {
    $media = Media::factory()->create(['file_name' => 'unique-file.jpg']);

    $foundMedia = Media::where('file_name', 'unique-file.jpg')->first();

    expect($foundMedia)->not()->toBeNull();
    expect($media->id)->toBe($foundMedia->id);
});

it('can find media by disk', function (): void {
    Media::factory()->create(['disk' => 'public']);
    Media::factory()->create(['disk' => 's3']);
    Media::factory()->create(['disk' => 'local']);

    $publicMedia = Media::where('disk', 'public')->get();

    expect($publicMedia)->toHaveCount(1);
    expect($publicMedia->first()->disk)->toBe('public');
});

it('can find media by mime type', function (): void {
    Media::factory()->create(['mime_type' => 'image/jpeg']);
    Media::factory()->create(['mime_type' => 'image/png']);
    Media::factory()->create(['mime_type' => 'application/pdf']);

    $jpegMedia = Media::where('mime_type', 'image/jpeg')->get();

    expect($jpegMedia)->toHaveCount(1);
    expect($jpegMedia->first()->mime_type)->toBe('image/jpeg');
});

it('can find media by size range', function (): void {
    Media::factory()->create(['size' => 512]);
    Media::factory()->create(['size' => 1024]);
    Media::factory()->create(['size' => 2048]);

    $largeMedia = Media::where('size', '>', 1000)->get();

    expect($largeMedia)->toHaveCount(2);
    expect($largeMedia->every(fn ($media) => $media->size > 1000))->toBeTrue();
});

it('can find media by name pattern', function (): void {
    Media::factory()->create(['name' => 'profile-avatar']);
    Media::factory()->create(['name' => 'cover-image']);
    Media::factory()->create(['name' => 'logo-brand']);

    $profileMedia = Media::where('name', 'like', '%profile%')->get();

    expect($profileMedia->count())->toBeGreaterThanOrEqual(1);
    expect($profileMedia->contains(fn ($media) => str_contains($media->name, 'profile')))->toBeTrue();
});

it('can find media by custom properties', function (): void {
    Media::factory()->create([
        'custom_properties' => ['alt' => 'Profile picture', 'category' => 'avatar'],
    ]);

    Media::factory()->create([
        'custom_properties' => ['alt' => 'Cover image', 'category' => 'banner'],
    ]);

    $avatarMedia = Media::whereJsonContains('custom_properties->category', 'avatar')->get();

    expect($avatarMedia->count())->toBeGreaterThanOrEqual(1);
    expect($avatarMedia->contains(fn ($media) => ($media->custom_properties['category'] ?? null) === 'avatar'))->toBeTrue();
});

it('can find media by manipulations', function (): void {
    Media::factory()->create([
        'manipulations' => ['resize' => ['width' => 800, 'height' => 600]],
    ]);

    Media::factory()->create([
        'manipulations' => ['crop' => ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 300]],
    ]);

    $resizeMedia = Media::whereJsonContains('manipulations->resize', ['width' => 800, 'height' => 600])->get();

    expect($resizeMedia->count())->toBeGreaterThanOrEqual(1);
    expect($resizeMedia->contains(fn ($media) => array_key_exists('resize', $media->manipulations ?? [])))->toBeTrue();
});

it('can update media', function (): void {
    $media = Media::factory()->create(['name' => 'Old Name']);

    $media->update(['name' => 'New Name']);

    $this->assertDatabaseHas('media', [
        'id' => (int) $media->getKey(),
        'name' => 'New Name',
    ], 'media');
});

it('can handle null values', function (): void {
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
        'manipulations' => [],
        'custom_properties' => [],
        'generated_conversions' => [],
        'responsive_images' => [],
        'order_column' => null,
    ]);

    // Spatie Media may generate a UUID even if null is provided.
    // Verify via casts (less brittle than DB JSON string matching).
    $fresh = $media->fresh();
    expect($fresh)->not()->toBeNull();
    expect($fresh->mime_type)->toBeNull();
    expect($fresh->conversions_disk)->toBeNull();
    expect($fresh->order_column)->toBeNull();
    expect($fresh->manipulations)->toBe([]);
    expect($fresh->custom_properties)->toBe([]);
    expect($fresh->generated_conversions)->toBe([]);
    expect($fresh->responsive_images)->toBe([]);
});

it('media has media converts relationship', function (): void {
    $media = Media::factory()->create();

    expect(method_exists($media, 'mediaConverts'))->toBeTrue();
});

it('media has temporary upload relationship', function (): void {
    $media = Media::factory()->create();

    expect(method_exists($media, 'temporaryUpload'))->toBeTrue();
});

it('media has creator relationship', function (): void {
    $media = Media::factory()->create();

    expect(method_exists($media, 'creator'))->toBeTrue();
});

it('media can get url conversion', function (): void {
    $media = Media::factory()->create([
        'file_name' => 'test-image.jpg',
    ]);

    $thumbUrl = $media->getUrlConv('thumb');
    expect($thumbUrl)->toContain('thumb.jpg');

    $url800 = $media->getUrlConv('800');
    expect($url800)->toContain('800.jpg');

    $url400 = $media->getUrlConv('400');
    expect($url400)->toContain('400.jpg');
});

it('media has entry conversions attribute', function (): void {
    $media = Media::factory()->create([
        'generated_conversions' => ['thumb' => true, 'medium' => false],
    ]);

    $entryConversions = $media->entry_conversions;

    expect($entryConversions)->toBeArray();
    expect($entryConversions)->toHaveCount(2);
    expect($entryConversions[0])->toHaveKey('name');
    expect($entryConversions[0])->toHaveKey('generated');
    expect($entryConversions[0])->toHaveKey('src');
});

it('media has factory', function (): void {
    $media = Media::factory()->create();

    expect($media->id)->not()->toBeNull();
    expect($media)->toBeInstanceOf(Media::class);
});

it('media has casts', function (): void {
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

    $actualCasts = $media->getCasts();

    ksort($expectedCasts);
    ksort($actualCasts);

    expect($actualCasts)->toBe($expectedCasts);
});
