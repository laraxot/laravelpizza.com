<?php

declare(strict_types=1);

uses(\Modules\Media\Tests\TestCase::class);

use Modules\Media\Models\BaseModel;
use Modules\Media\Models\Media;
use Modules\Media\Models\TemporaryUpload;

describe('TemporaryUpload Model', function () {
    it('extends BaseModel', function (): void {
        // Assert
        expect(is_a(TemporaryUpload::class, BaseModel::class, true))->toBeTrue();
    });

    it('uses HasXotFactory trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(TemporaryUpload::class);

        // Assert
        expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', $traits, true))->toBeTrue();
    });

    it('uses InteractsWithMedia trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(TemporaryUpload::class);

        // Assert
        expect(in_array('Spatie\MediaLibrary\InteractsWithMedia', $traits, true))->toBeTrue();
    });

    it('uses MassPrunable trait', function (): void {
        // Arrange
        $traits = class_uses_recursive(TemporaryUpload::class);

        // Assert
        expect(in_array('Illuminate\Database\Eloquent\MassPrunable', $traits, true))->toBeTrue();
    });

    it('has media connection', function (): void {
        // Arrange
        $upload = new TemporaryUpload;

        // Assert
        expect($upload->getConnectionName())->toBe('media');
    });

    it('has empty guarded array', function (): void {
        // Arrange
        $upload = new TemporaryUpload;

        // Assert
        expect($upload->getGuarded())->toBe([]);
    });

    it('has findByMediaUuid static method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'findByMediaUuid'))->toBeTrue();
    });

    it('has findByMediaUuidInCurrentSession static method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'findByMediaUuidInCurrentSession'))->toBeTrue();
    });

    it('has createForFile static method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'createForFile'))->toBeTrue();
    });

    it('has createForRemoteFile static method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'createForRemoteFile'))->toBeTrue();
    });

    it('has registerMediaConversions method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'registerMediaConversions'))->toBeTrue();
    });

    it('has moveMedia method', function (): void {
        // Assert
        expect(method_exists(TemporaryUpload::class, 'moveMedia'))->toBeTrue();
    });

    it('has static disk property', function (): void {
        // Assert
        expect(property_exists(TemporaryUpload::class, 'disk'))->toBeTrue();
    });

    it('has static manipulatePreview property', function (): void {
        // Assert
        expect(property_exists(TemporaryUpload::class, 'manipulatePreview'))->toBeTrue();
    });
});
