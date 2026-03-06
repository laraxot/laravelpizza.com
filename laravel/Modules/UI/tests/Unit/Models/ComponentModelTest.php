<?php

declare(strict_types=1);

use Modules\UI\Models\Component;

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
            ->and($casts['lazy_loading_threshold'])->toBe('integer')
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
        expect($reflection->isSubclassOf(Modules\UI\Models\BaseModel::class))->toBeTrue();
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
