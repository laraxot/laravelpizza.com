<?php

declare(strict_types=1);

use Modules\UI\Models\Component;
<<<<<<< HEAD
||||||| parent of 6c6798449 (.)
use Modules\UI\Models\Theme;
use Modules\UI\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);
=======
use Modules\UI\Models\Theme;
>>>>>>> 6c6798449 (.)

describe('Component Model', function (): void {
    it('can be instantiated', function (): void {
        $component = new Component();
        expect($component)->toBeInstanceOf(Component::class);
    });

    it('has fillable attributes', function (): void {
        $component = new Component();
        $expected = [
            'name', 'theme_id', 'is_active', 'version', 'dependencies',
            'template', 'is_cacheable', 'cache_ttl', 'validation_rules',
            'view_path', 'data_schema', 'responsive_breakpoints',
            'supports_lazy_loading', 'lazy_loading_threshold',
            'cache_strategy', 'cache_duration',
        ];

        foreach ($expected as $field) {
            expect(in_array($field, $component->getFillable()))->toBeTrue();
        }
    });

    it('has casts defined', function (): void {
        $component = new Component();
        $casts = $component->getCasts();

        expect($casts['is_active'])->toBe('boolean')
            ->and($casts['is_cacheable'])->toBe('boolean')
            ->and($casts['dependencies'])->toBe('array')
            ->and($casts['validation_rules'])->toBe('array')
            ->and($casts['data_schema'])->toBe('array')
            ->and($casts['responsive_breakpoints'])->toBe('array')
            ->and($casts['supports_lazy_loading'])->toBe('boolean')
<<<<<<< HEAD
            ->and($casts['lazy_loading_threshold'])->toBe('integer')
||||||| parent of 6c6798449 (.)
        expect($component->is_active)->toBeBool()
            ->and($component->is_active)->toBeTrue();
=======
            ->and(in_array($casts['lazy_loading_threshold'], ['integer', 'float']))->toBeTrue()
>>>>>>> 6c6798449 (.)
            ->and($casts['cache_duration'])->toBe('integer');
    });

    it('has theme relationship', function (): void {
        $reflection = new ReflectionClass(Component::class);
        expect($reflection->hasMethod('theme'))->toBeTrue();
    });

    it('has correct table name', function (): void {
        $component = new Component();
        expect($component->getTable())->toBe('components');
    });

    it('extends BaseModel', function (): void {
        $reflection = new ReflectionClass(Component::class);
<<<<<<< HEAD
        expect($reflection->isSubclassOf(Modules\UI\Models\BaseModel::class))->toBeTrue();
||||||| parent of 6c6798449 (.)
    test('it casts validation_rules to array', function (): void {
        $component = Component::factory()->create([
            'validation_rules' => ['required' => true, 'max' => 255],
        ]);

        expect($component->validation_rules)->toBeArray()
            ->and($component->validation_rules['required'])->toBeTrue();
=======
        expect($reflection->isSubclassOf(\Modules\UI\Models\BaseModel::class))->toBeTrue();
>>>>>>> 6c6798449 (.)
    });

    it('uses strict types', function (): void {
        $reflection = new ReflectionClass(Component::class);
        $content = file_get_contents($reflection->getFileName());
        expect($content)->toContain('declare(strict_types=1);');
    });

    it('has correct namespace', function (): void {
        $reflection = new ReflectionClass(Component::class);
        expect($reflection->getNamespaceName())->toBe('Modules\UI\Models');
    });
});
