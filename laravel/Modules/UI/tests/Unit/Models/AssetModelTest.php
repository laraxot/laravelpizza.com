<?php

declare(strict_types=1);

use Modules\UI\Models\Asset;
use Modules\UI\Models\Theme;

describe('Asset Model', function (): void {
    it('can be instantiated', function (): void {
        $asset = new Asset();
        expect($asset)->toBeInstanceOf(Asset::class);
    });

    it('has fillable attributes', function (): void {
        $asset = new Asset();
        $expected = ['name', 'type', 'path', 'theme_id', 'is_minified', 'is_compressed', 'order', 'should_bundle'];

        foreach ($expected as $field) {
            expect(in_array($field, $asset->getFillable()))->toBeTrue();
        }
    });

    it('has casts defined', function (): void {
        $asset = new Asset();
        $casts = $asset->getCasts();

        expect($casts['is_minified'])->toBe('boolean')
            ->and($casts['is_compressed'])->toBe('boolean')
            ->and($casts['order'])->toBe('integer')
            ->and($casts['should_bundle'])->toBe('boolean');
    });

    it('has theme relationship', function (): void {
        $reflection = new ReflectionClass(Asset::class);
        expect($reflection->hasMethod('theme'))->toBeTrue();
    });

    it('has correct table name', function (): void {
        $asset = new Asset();
        expect($asset->getTable())->toBe('assets');
    });

    it('uses HasFactory trait', function (): void {
        expect(in_array('Illuminate\Database\Eloquent\Factories\HasFactory', class_uses(Asset::class)))->toBeTrue();
    });

    it('uses strict types', function (): void {
        $reflection = new ReflectionClass(Asset::class);
        $content = file_get_contents($reflection->getFileName());
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function (): void {
        $reflection = new ReflectionClass(Asset::class);
        expect($reflection->getNamespaceName())->toBe('Modules\UI\Models');
    });
});
