<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\UI\Models\Component;
use Modules\UI\Models\Theme;
use Modules\UI\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('Component Model', function (): void {
    test('it can create a component with valid data', function (): void {
        $theme = Theme::factory()->create();
        $component = Component::factory()->create([
            'name' => 'hero-component',
            'theme_id' => $theme->id,
            'is_active' => true,
        ]);

        expect($component->name)->toBe('hero-component')
            ->and($component->is_active)->toBeTrue();
    });

    test('it has fillable attributes', function (): void {
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

    test('it casts is_active to boolean', function (): void {
        $component = Component::factory()->create(['is_active' => '1']);

        expect($component->is_active)->toBeBool()
            ->and($component->is_active)->toBeTrue();
    });

    test('it casts is_cacheable to boolean', function (): void {
        $component = Component::factory()->create(['is_cacheable' => true]);

        expect($component->is_cacheable)->toBeBool()
            ->and($component->is_cacheable)->toBeTrue();
    });

    test('it casts dependencies to array', function (): void {
        $component = Component::factory()->create([
            'dependencies' => ['vue', 'tailwind'],
        ]);

        expect($component->dependencies)->toBeArray()
            ->and($component->dependencies)->toContain('vue');
    });

    test('it casts validation_rules to array', function (): void {
        $component = Component::factory()->create([
            'validation_rules' => ['required' => true, 'max' => 255],
        ]);

        expect($component->validation_rules)->toBeArray()
            ->and($component->validation_rules['required'])->toBeTrue();
    });

    test('it casts data_schema to array', function (): void {
        $component = Component::factory()->create([
            'data_schema' => ['type' => 'object', 'properties' => []],
        ]);

        expect($component->data_schema)->toBeArray()
            ->and($component->data_schema['type'])->toBe('object');
    });

    test('it casts responsive_breakpoints to array', function (): void {
        $component = Component::factory()->create([
            'responsive_breakpoints' => [
                'mobile' => 'max-width: 768px',
                'desktop' => 'min-width: 1024px',
            ],
        ]);

        expect($component->responsive_breakpoints)->toBeArray()
            ->and($component->responsive_breakpoints['mobile'])->toContain('768px');
    });

    test('component belongs to theme', function (): void {
        $theme = Theme::factory()->create(['name' => 'Test Theme']);
        $component = Component::factory()->create(['theme_id' => $theme->id]);

        expect($component->theme->name)->toBe('Test Theme');
    });

    test('component can be inactive', function (): void {
        $component = Component::factory()->create(['is_active' => false]);

        expect($component->is_active)->toBeFalse();
    });

    test('component has timestamps', function (): void {
        $component = Component::factory()->create();

        expect($component->created_at)->not->toBeNull()
            ->and($component->updated_at)->not->toBeNull();
    });
});
