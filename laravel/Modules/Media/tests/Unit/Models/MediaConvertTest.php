<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

uses(\Modules\Media\Tests\TestCase::class);

use Modules\Media\Models\BaseModel;
use Modules\Media\Models\MediaConvert;

describe('MediaConvert Model', function () {
    it('extends BaseModel', function (): void {
        // Assert
        expect(is_a(MediaConvert::class, BaseModel::class, true))->toBeTrue();
    });

    it('has correct fillable fields', function (): void {
        // Arrange
        $model = new MediaConvert;

        // Assert
        expect($model->getFillable())->toContain('media_id');
        expect($model->getFillable())->toContain('format');
        expect($model->getFillable())->toContain('codec_video');
        expect($model->getFillable())->toContain('codec_audio');
        expect($model->getFillable())->toContain('preset');
        expect($model->getFillable())->toContain('bitrate');
        expect($model->getFillable())->toContain('width');
        expect($model->getFillable())->toContain('height');
        expect($model->getFillable())->toContain('threads');
        expect($model->getFillable())->toContain('speed');
        expect($model->getFillable())->toContain('percentage');
        expect($model->getFillable())->toContain('remaining');
        expect($model->getFillable())->toContain('rate');
        expect($model->getFillable())->toContain('execution_time');
    });

    it('has media relationship', function (): void {
        // Arrange
        $model = new MediaConvert;

        // Assert
        expect(method_exists($model, 'media'))->toBeTrue();
    });

    it('has getDiskAttribute accessor', function (): void {
        // Assert
        expect(method_exists(MediaConvert::class, 'getDiskAttribute'))->toBeTrue();
    });

    it('has getFileAttribute accessor', function (): void {
        // Assert
        expect(method_exists(MediaConvert::class, 'getFileAttribute'))->toBeTrue();
    });

    it('has getConvertedFileAttribute accessor', function (): void {
        // Assert
        expect(method_exists(MediaConvert::class, 'getConvertedFileAttribute'))->toBeTrue();
    });

    it('has connection', function (): void {
        // Arrange
        $model = new MediaConvert;

        // Assert
        expect($model->getConnectionName())->toBe('media');
    });

    it('uses HasXotFactory trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(MediaConvert::class);

        // Assert
        expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', $traits, true))->toBeTrue();
    });
});
