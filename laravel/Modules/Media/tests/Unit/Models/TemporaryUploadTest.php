<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Modules\Media\Models\BaseModel;
use Modules\Media\Models\TemporaryUpload;
use Modules\Media\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_parents;

uses(TestCase::class)->group('no-media-db');

describe('TemporaryUpload Model', function (): void {
    it('extends BaseModel', function (): void {
        Assert::assertArrayHasKey(BaseModel::class, class_parents(TemporaryUpload::class));
    });

    it('uses HasXotFactory trait', function (): void {
        $traits = class_uses_recursive(TemporaryUpload::class);

        expect(in_array('Modules\Xot\Models\Traits\HasXotFactory', $traits, true))->toBeTrue();
    });

    it('uses InteractsWithMedia trait', function (): void {
        $traits = class_uses_recursive(TemporaryUpload::class);

        expect(in_array('Spatie\MediaLibrary\InteractsWithMedia', $traits, true))->toBeTrue();
    });

    it('uses MassPrunable trait', function (): void {
        $traits = class_uses_recursive(TemporaryUpload::class);

        expect(in_array('Illuminate\Database\Eloquent\MassPrunable', $traits, true))->toBeTrue();
    });

    it('has media connection', function (): void {
        $upload = new TemporaryUpload;

        expect($upload->getConnectionName())->toBe('media');
    });

    it('has empty guarded array', function (): void {
        $upload = new TemporaryUpload;

        expect($upload->getGuarded())->toBe([]);
    });

    it('has findByMediaUuid static method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('findByMediaUuid'))->toBeTrue();
    });

    it('has findByMediaUuidInCurrentSession static method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('findByMediaUuidInCurrentSession'))->toBeTrue();
    });

    it('has createForFile static method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('createForFile'))->toBeTrue();
    });

    it('has createForRemoteFile static method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('createForRemoteFile'))->toBeTrue();
    });

    it('has registerMediaConversions method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('registerMediaConversions'))->toBeTrue();
    });

    it('has moveMedia method', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasMethod('moveMedia'))->toBeTrue();
    });

    it('has static disk property', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasProperty('disk'))->toBeTrue();
    });

    it('has static manipulatePreview property', function (): void {
        expect((new \ReflectionClass(TemporaryUpload::class))->hasProperty('manipulatePreview'))->toBeTrue();
    });
});
