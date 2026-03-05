<?php

declare(strict_types=1);

uses(\Modules\Media\Tests\TestCase::class);

use Modules\Media\Models\BaseModel;

describe('Media BaseModel', function () {
    it('extends XotBaseModel', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        expect($model)->toBeInstanceOf(BaseModel::class);
    });

    it('has media connection', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        expect($model->getConnectionName())->toBe('media');
    });

    it('casts id to string', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        $casts = $model->getCasts();
        expect($casts['id'] ?? null)->toBe('string');
    });

    it('casts uuid to string', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        $casts = $model->getCasts();
        expect($casts['uuid'] ?? null)->toBe('string');
    });

    it('casts datetime fields', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        $casts = $model->getCasts();
        expect($casts['published_at'] ?? null)->toBe('datetime');
        expect($casts['created_at'] ?? null)->toBe('datetime');
        expect($casts['updated_at'] ?? null)->toBe('datetime');
        expect($casts['deleted_at'] ?? null)->toBe('datetime');
    });

    it('casts user fields to string', function (): void {
        // Arrange
        $model = new class extends BaseModel {
            protected $table = 'test_table';
        };

        // Assert
        $casts = $model->getCasts();
        expect($casts['updated_by'] ?? null)->toBe('string');
        expect($casts['created_by'] ?? null)->toBe('string');
        expect($casts['deleted_by'] ?? null)->toBe('string');
    });
});
