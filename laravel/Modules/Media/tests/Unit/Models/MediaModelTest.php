<?php

declare(strict_types=1);

uses(\Modules\Media\Tests\TestCase::class);

use Modules\Media\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

describe('Media Model', function () {
    it('extends SpatieMedia', function (): void {
        // Assert
        expect(is_a(Media::class, SpatieMedia::class, true))->toBeTrue();
    });

    it('uses HasXotFactory trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(Media::class);

        // Assert
        expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', $traits, true))->toBeTrue();
    });

    it('uses Updater trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(Media::class);

        // Assert
        expect(in_array('Modules\Xot\Traits\Updater', $traits, true))->toBeTrue();
    });

    it('has media connection', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        expect($model->getConnectionName())->toBe('media');
    });

    it('has findWithTemporaryUploadInCurrentSession static method', function (): void {
        // Assert
        expect(method_exists(Media::class, 'findWithTemporaryUploadInCurrentSession'))->toBeTrue();
    });

    it('has temporaryUpload relationship', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        expect(method_exists($model, 'temporaryUpload'))->toBeTrue();
    });

    it('has creator relationship', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        expect(method_exists($model, 'creator'))->toBeTrue();
    });

    it('has mediaConverts relationship', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        expect(method_exists($model, 'mediaConverts'))->toBeTrue();
    });

    it('has getUrlConv method', function (): void {
        // Assert
        expect(method_exists(Media::class, 'getUrlConv'))->toBeTrue();
    });

    it('has getEntryConversionsAttribute accessor', function (): void {
        // Assert
        expect(method_exists(Media::class, 'getEntryConversionsAttribute'))->toBeTrue();
    });

    it('casts id to string', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        $casts = $model->getCasts();
        expect($casts['id'] ?? null)->toBe('string');
    });

    it('casts uuid to string', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        $casts = $model->getCasts();
        expect($casts['uuid'] ?? null)->toBe('string');
    });

    it('casts datetime fields', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        $casts = $model->getCasts();
        expect($casts['created_at'] ?? null)->toBe('datetime');
        expect($casts['updated_at'] ?? null)->toBe('datetime');
        expect($casts['deleted_at'] ?? null)->toBe('datetime');
    });

    it('casts user fields to string', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        $casts = $model->getCasts();
        expect($casts['updated_by'] ?? null)->toBe('string');
        expect($casts['created_by'] ?? null)->toBe('string');
        expect($casts['deleted_by'] ?? null)->toBe('string');
    });

    it('casts array fields', function (): void {
        // Arrange
        $model = new Media;

        // Assert
        $casts = $model->getCasts();
        expect($casts['manipulations'] ?? null)->toBe('array');
        expect($casts['custom_properties'] ?? null)->toBe('array');
        expect($casts['generated_conversions'] ?? null)->toBe('array');
        expect($casts['responsive_images'] ?? null)->toBe('array');
    });

    it('has entry_conversions attribute', function (): void {
        // Assert - entry_conversions is a dynamic attribute from getEntryConversionsAttribute accessor
        expect(method_exists(Media::class, 'getEntryConversionsAttribute'))->toBeTrue();
    });
});
