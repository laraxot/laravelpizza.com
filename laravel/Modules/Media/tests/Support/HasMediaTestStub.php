<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Support;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use Spatie\MediaLibrary\Conversions\Conversion;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\MediaCollections\FileAdder;
use Spatie\MediaLibrary\MediaCollections\MediaCollection;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Doppio di test per HasMedia con update() — compatibile PHPUnit 11+ (no addMethods).
 */
abstract class HasMediaTestStub implements HasMedia
{
    /**
     * @param  array<string, mixed>  $attributes
     * @param  array<string, mixed>  $options
     */
    public function update(array $attributes = [], array $options = []): bool
    {
        return true;
    }

    /**
     * @return MorphMany<Media, Model>
     */
    public function media(): MorphMany
    {
        throw new \BadMethodCallException(__METHOD__);
    }

    public function addMedia(UploadedFile|string $file): FileAdder
    {
        throw new \BadMethodCallException(__METHOD__);
    }

    public function copyMedia(UploadedFile|string $file): FileAdder
    {
        throw new \BadMethodCallException(__METHOD__);
    }

    public function hasMedia(string $collectionName = ''): bool
    {
        return false;
    }

    /**
     * @param  callable|array<string, mixed>  $filters
     * @return Collection<int, Media>
     */
    public function getMedia(string $collectionName = 'default', callable|array $filters = []): Collection
    {
        return new Collection;
    }

    public function clearMediaCollection(string $collectionName = 'default'): HasMedia
    {
        return $this;
    }

    /**
     * @param  Collection<int, Media>|array<int, Media>  $excludedMedia
     */
    public function clearMediaCollectionExcept(string $collectionName = 'default', Collection|array $excludedMedia = []): HasMedia
    {
        return $this;
    }

    public function shouldDeletePreservingMedia(): bool
    {
        return false;
    }

    /**
     * Il contratto Spatie (`InteractsWithMedia`) restituisce `Collection`;
     * il tipo nativo si restringe rispetto al docblock dell'interfaccia (non tipizzato).
     *
     * @return Collection<int, Media>
     */
    public function loadMedia(string $collectionName): Collection
    {
        return new Collection;
    }

    public function addMediaConversion(string $name): Conversion
    {
        throw new \BadMethodCallException(__METHOD__);
    }

    public function registerMediaConversions(?Media $media = null): void {}

    public function registerMediaCollections(): void {}

    public function registerAllMediaConversions(): void {}

    public function getMediaCollection(string $collectionName = 'default'): ?MediaCollection
    {
        return null;
    }

    public function getMediaModel(): string
    {
        return Media::class;
    }
}
