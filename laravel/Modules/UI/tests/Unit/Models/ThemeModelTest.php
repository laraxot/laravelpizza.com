<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\UI\Models\Theme;
use Modules\UI\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('Theme Model', function (): void {
    test('it can create a theme with valid data', function (): void {
        $theme = Theme::factory()->create([
            'name' => 'Test Theme',
            'is_active' => true,
        ]);

        expect($theme->name)->toBe('Test Theme')
            ->and($theme->is_active)->toBeTrue();
    });

    test('it has fillable attributes', function (): void {
        $theme = new Theme();
        $expected = ['name', 'description', 'is_active', 'config', 'parent_id', 'source_path', 'compiled_path', 'needs_compilation'];

        foreach ($expected as $field) {
            expect(in_array($field, $theme->getFillable()))->toBeTrue();
        }
    });

    test('it casts is_active to boolean', function (): void {
        $theme = Theme::factory()->create(['is_active' => '1']);

        expect($theme->is_active)->toBeBool()
            ->and($theme->is_active)->toBeTrue();
    });

    test('it casts config to array', function (): void {
        $theme = Theme::factory()->create([
            'config' => ['primary_color' => '#ff0000', 'font_family' => 'Roboto'],
        ]);

        expect($theme->config)->toBeArray()
            ->and($theme->config['primary_color'])->toBe('#ff0000');
    });

    test('it casts needs_compilation to boolean', function (): void {
        $theme = Theme::factory()->create(['needs_compilation' => true]);

        expect($theme->needs_compilation)->toBeBool()
            ->and($theme->needs_compilation)->toBeTrue();
    });

    test('theme can have parent theme', function (): void {
        $parent = Theme::factory()->create(['name' => 'Parent Theme']);
        $child = Theme::factory()->create(['name' => 'Child Theme', 'parent_id' => $parent->id]);

        expect($child->parent->name)->toBe('Parent Theme');
    });

    test('theme can be active', function (): void {
        $theme = Theme::factory()->create(['is_active' => true]);

        expect($theme->is_active)->toBeTrue();
    });

    test('theme can be inactive', function (): void {
        $theme = Theme::factory()->create(['is_active' => false]);

        expect($theme->is_active)->toBeFalse();
    });

    test('theme has timestamps', function (): void {
        $theme = Theme::factory()->create();

        expect($theme->created_at)->not->toBeNull()
            ->and($theme->updated_at)->not->toBeNull();
    });
});
