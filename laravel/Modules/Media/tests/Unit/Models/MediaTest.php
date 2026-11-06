<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Modules\Media\Database\Factories\MediaFactory;
use Modules\Media\Models\Media;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Tests\XotBasePest;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/**
 * @param  array<string, mixed>  $attributes
 */
function mediaTestCreate(array $attributes = []): Media
{
    return MediaFactory::new()->createOne($attributes);
}

describe('Media model (database)', function (): void {
    it('can create media with minimal data', function (): void {
        $media = mediaTestCreate([
            'model_type' => 'Modules\User\Models\User',
            'model_id' => '1',
            'collection_name' => 'avatars',
            'name' => 'test-image',
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
            'size' => 1024,
        ]);

        XotBasePest::assertTableHas('media', 'media', [
            'id' => SafeIntCastAction::cast($media->getKey()),
            'collection_name' => 'avatars',
            'name' => 'test-image',
            'file_name' => 'test-image.jpg',
            'disk' => 'public',
            'size' => 1024,
        ]);
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

        $media = mediaTestCreate($mediaData);

        XotBasePest::assertTableHas('media', 'media', [
            'id' => SafeIntCastAction::cast($media->getKey()),
            'collection_name' => 'images',
            'name' => 'full-image',
            'file_name' => 'full-image.png',
            'mime_type' => 'image/png',
            'disk' => 's3',
            'conversions_disk' => 's3-conversions',
            'size' => 2048,
            'order_column' => 1,
        ]);

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
        $media = mediaTestCreate();
        $mediaId = SafeIntCastAction::cast($media->getKey());

        $media->delete();

        XotBasePest::assertTableMissing('media', 'media', ['id' => $mediaId]);
    });

    it('can find media by model type', function (): void {
        $media = mediaTestCreate(['model_type' => 'App\Models\UniqueModel']);

        $foundMedia = Media::where('model_type', 'App\Models\UniqueModel')->first();

        Assert::assertInstanceOf(Media::class, $foundMedia);
        expect($media->id)->toBe($foundMedia->id);
    });

    it('can find media by model id', function (): void {
        $media = mediaTestCreate(['model_id' => '999']);

        $foundMedia = Media::where('model_id', '999')->first();

        Assert::assertInstanceOf(Media::class, $foundMedia);
        expect($media->id)->toBe($foundMedia->id);
    });

    it('can find media by collection name', function (): void {
        MediaFactory::new()->createOne(['collection_name' => 'avatars']);
        MediaFactory::new()->createOne(['collection_name' => 'images']);
        MediaFactory::new()->createOne(['collection_name' => 'documents']);

        $avatarMedia = Media::where('collection_name', 'avatars')->get();

        expect($avatarMedia)->toHaveCount(1);
        $firstAvatarMedia = $avatarMedia->first();
        Assert::assertInstanceOf(Media::class, $firstAvatarMedia);
        expect($firstAvatarMedia->collection_name)->toBe('avatars');
    });

    it('can find media by name', function (): void {
        $media = mediaTestCreate(['name' => 'unique-media-name']);

        $foundMedia = Media::where('name', 'unique-media-name')->first();

        Assert::assertInstanceOf(Media::class, $foundMedia);
        expect($media->id)->toBe($foundMedia->id);
    });

    it('can find media by file name', function (): void {
        $media = mediaTestCreate(['file_name' => 'unique-file.jpg']);

        $foundMedia = Media::where('file_name', 'unique-file.jpg')->first();

        Assert::assertInstanceOf(Media::class, $foundMedia);
        expect($media->id)->toBe($foundMedia->id);
    });

    it('can find media by disk', function (): void {
        MediaFactory::new()->createOne(['disk' => 'public']);
        MediaFactory::new()->createOne(['disk' => 's3']);
        MediaFactory::new()->createOne(['disk' => 'local']);

        $publicMedia = Media::where('disk', 'public')->get();

        expect($publicMedia)->toHaveCount(1);
        $firstPublicMedia = $publicMedia->first();
        Assert::assertInstanceOf(Media::class, $firstPublicMedia);
        expect($firstPublicMedia->disk)->toBe('public');
    });

    it('can find media by mime type', function (): void {
        MediaFactory::new()->createOne(['mime_type' => 'image/jpeg']);
        MediaFactory::new()->createOne(['mime_type' => 'image/png']);
        MediaFactory::new()->createOne(['mime_type' => 'application/pdf']);

        $jpegMedia = Media::where('mime_type', 'image/jpeg')->get();

        expect($jpegMedia)->toHaveCount(1);
        $firstJpegMedia = $jpegMedia->first();
        Assert::assertInstanceOf(Media::class, $firstJpegMedia);
        expect($firstJpegMedia->mime_type)->toBe('image/jpeg');
    });

    it('can find media by size range', function (): void {
        MediaFactory::new()->createOne(['size' => 512]);
        MediaFactory::new()->createOne(['size' => 1024]);
        MediaFactory::new()->createOne(['size' => 2048]);

        $largeMedia = Media::where('size', '>', 1000)->get();

        expect($largeMedia)->toHaveCount(2);
        expect($largeMedia->every(fn (Media $media): bool => $media->size > 1000))->toBeTrue();
    });

    it('can find media by name pattern', function (): void {
        MediaFactory::new()->createOne(['name' => 'profile-avatar']);
        MediaFactory::new()->createOne(['name' => 'cover-image']);
        MediaFactory::new()->createOne(['name' => 'logo-brand']);

        $profileMedia = Media::where('name', 'like', '%profile%')->get();

        expect($profileMedia->count())->toBeGreaterThanOrEqual(1);
        expect($profileMedia->contains(fn (Media $media): bool => str_contains($media->name, 'profile')))->toBeTrue();
    });

    it('can find media by custom properties', function (): void {
        MediaFactory::new()->createOne([
            'custom_properties' => ['alt' => 'Profile picture', 'category' => 'avatar'],
        ]);

        MediaFactory::new()->createOne([
            'custom_properties' => ['alt' => 'Cover image', 'category' => 'banner'],
        ]);

        $avatarMedia = Media::whereJsonContains('custom_properties->category', 'avatar')->get();

        expect($avatarMedia->count())->toBeGreaterThanOrEqual(1);
        expect($avatarMedia->contains(fn (Media $media): bool => ($media->custom_properties['category'] ?? null) === 'avatar'))->toBeTrue();
    });

    it('can find media by manipulations', function (): void {
        MediaFactory::new()->createOne([
            'manipulations' => ['resize' => ['width' => 800, 'height' => 600]],
        ]);

        MediaFactory::new()->createOne([
            'manipulations' => ['crop' => ['x' => 0, 'y' => 0, 'width' => 400, 'height' => 300]],
        ]);

        // `whereJsonContains` con un valore array non è traducibile su SQLite: Laravel lo
        // rende con `json_each(...) where value is <array>` e il driver risponde
        // «column index out of range». Il path esplicito passa da `json_extract` ed è
        // portabile su entrambi i motori, senza cambiare ciò che il test verifica.
        $resizeMedia = Media::query()
            ->where('manipulations->resize->width', 800)
            ->where('manipulations->resize->height', 600)
            ->get();

        expect($resizeMedia->count())->toBeGreaterThanOrEqual(1);
        expect($resizeMedia->contains(fn (Media $media): bool => array_key_exists('resize', $media->manipulations ?? [])))->toBeTrue();
    });

    it('can update media', function (): void {
        $media = mediaTestCreate(['name' => 'Old Name']);

        $media->update(['name' => 'New Name']);

        XotBasePest::assertTableHas('media', 'media', [
            'id' => SafeIntCastAction::cast($media->getKey()),
            'name' => 'New Name',
        ]);
    });

    it('can handle null values', function (): void {
        $media = mediaTestCreate([
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
        Assert::assertInstanceOf(Media::class, $fresh);
        expect($fresh->mime_type)->toBeNull();
        expect($fresh->conversions_disk)->toBeNull();
        // `order_column` non resta null: Spatie usa il trait `SortableTrait`, che in
        // `creating` assegna il numero d'ordine più alto disponibile. Passargli null non lo
        // disattiva — asserire il contrario significava dare per rotto il comportamento
        // documentato della libreria.
        expect($fresh->order_column)->toBeInt()->toBeGreaterThan(0);
        expect($fresh->manipulations)->toBe([]);
        expect($fresh->custom_properties)->toBe([]);
        expect($fresh->generated_conversions)->toBe([]);
        expect($fresh->responsive_images)->toBe([]);
    });

    it('media has media converts relationship', function (): void {
        $media = mediaTestCreate();
        $reflection = new \ReflectionClass($media);

        expect($reflection->hasMethod('mediaConverts'))->toBeTrue();
    });

    it('media has temporary upload relationship', function (): void {
        $media = mediaTestCreate();
        $reflection = new \ReflectionClass($media);

        expect($reflection->hasMethod('temporaryUpload'))->toBeTrue();
    });

    it('media has creator relationship', function (): void {
        $media = mediaTestCreate();
        $reflection = new \ReflectionClass($media);

        expect($reflection->hasMethod('creator'))->toBeTrue();
    });

    it('media can get url conversion', function (): void {
        $media = mediaTestCreate([
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
        $media = mediaTestCreate([
            'generated_conversions' => ['thumb' => true, 'medium' => false],
        ]);

        $entryConversions = $media->entry_conversions;

        expect($entryConversions)->toHaveCount(2);
        expect($entryConversions[0])->toHaveKey('name');
        expect($entryConversions[0])->toHaveKey('generated');
        expect($entryConversions[0])->toHaveKey('src');
    });

    it('media has factory', function (): void {
        $media = mediaTestCreate();

        expect($media->id)->toBeGreaterThan(0);
    });
})->group('media-db');

it('media has casts', function (): void {
    $media = new Media;

    $expectedCasts = [
        'id' => 'integer',
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
