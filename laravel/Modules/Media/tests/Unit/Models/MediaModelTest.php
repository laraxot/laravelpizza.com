<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Modules\Media\Models\Media;
use Spatie\MediaLibrary\MediaCollections\Models\Media as SpatieMedia;

uses(\Modules\Media\Tests\TestCase::class);

describe('Media Model', function (): void {
    it('extends SpatieMedia', function (): void {
        expect(new Media)->toBeInstanceOf(SpatieMedia::class);
    });

    it('uses HasXotFactory trait', function (): void {
        $traits = class_uses_recursive(Media::class);

        expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', $traits, true))->toBeTrue();
    });

    it('uses Updater trait', function (): void {
        $traits = class_uses_recursive(Media::class);

        expect(in_array('Modules\Xot\Traits\Updater', $traits, true))->toBeTrue();
    });

    it('has media connection', function (): void {
        $model = new Media;

        expect($model->getConnectionName())->toBe('media');
    });

    it('has findWithTemporaryUploadInCurrentSession static method', function (): void {
        expect((new \ReflectionClass(Media::class))->hasMethod('findWithTemporaryUploadInCurrentSession'))->toBeTrue();
    });

    it('has temporaryUpload relationship', function (): void {
        $model = new Media;

        expect((new \ReflectionClass($model))->hasMethod('temporaryUpload'))->toBeTrue();
    });

    it('has creator relationship', function (): void {
        $model = new Media;

        expect((new \ReflectionClass($model))->hasMethod('creator'))->toBeTrue();
    });

    it('has mediaConverts relationship', function (): void {
        $model = new Media;

        expect((new \ReflectionClass($model))->hasMethod('mediaConverts'))->toBeTrue();
    });

    it('has getUrlConv method', function (): void {
        expect((new \ReflectionClass(Media::class))->hasMethod('getUrlConv'))->toBeTrue();
    });

    it('has getEntryConversionsAttribute accessor', function (): void {
        expect((new \ReflectionClass(Media::class))->hasMethod('getEntryConversionsAttribute'))->toBeTrue();
    });

    it('casts id to string', function (): void {
        $model = new Media;

        $casts = $model->getCasts();
        expect($casts['id'] ?? null)->toBe('string');
    });

    it('casts uuid to string', function (): void {
        $model = new Media;

        $casts = $model->getCasts();
        expect($casts['uuid'] ?? null)->toBe('string');
    });

    it('casts datetime fields', function (): void {
        $model = new Media;

        $casts = $model->getCasts();
        expect($casts['created_at'] ?? null)->toBe('datetime');
        expect($casts['updated_at'] ?? null)->toBe('datetime');
        expect($casts['deleted_at'] ?? null)->toBe('datetime');
    });

    it('casts user fields to string', function (): void {
        $model = new Media;

        $casts = $model->getCasts();
        expect($casts['updated_by'] ?? null)->toBe('string');
        expect($casts['created_by'] ?? null)->toBe('string');
        expect($casts['deleted_by'] ?? null)->toBe('string');
    });

    it('casts array fields', function (): void {
        $model = new Media;

        $casts = $model->getCasts();
        expect($casts['manipulations'] ?? null)->toBe('array');
        expect($casts['custom_properties'] ?? null)->toBe('array');
        expect($casts['generated_conversions'] ?? null)->toBe('array');
        expect($casts['responsive_images'] ?? null)->toBe('array');
    });

    it('has entry_conversions attribute', function (): void {
        // entry_conversions is a dynamic attribute from getEntryConversionsAttribute accessor
        expect((new \ReflectionClass(Media::class))->hasMethod('getEntryConversionsAttribute'))->toBeTrue();
    });
});
