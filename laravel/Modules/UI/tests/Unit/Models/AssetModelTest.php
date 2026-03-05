<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\UI\Models\Asset;
use Modules\UI\Models\Theme;
use Modules\UI\Tests\TestCase;

uses(TestCase::class, DatabaseTransactions::class);

describe('Asset Model', function (): void {
    test('it can create an asset with valid data', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create([
            'name' => 'main.css',
            'type' => 'css',
            'theme_id' => $theme->id,
        ]);

        expect($asset->name)->toBe('main.css')
            ->and($asset->type)->toBe('css');
    });

    test('it has fillable attributes', function (): void {
        $asset = new Asset();
        $expected = ['name', 'type', 'path', 'theme_id', 'is_minified', 'is_compressed', 'order', 'should_bundle'];

        foreach ($expected as $field) {
            expect(in_array($field, $asset->getFillable()))->toBeTrue();
        }
    });

    test('it casts is_minified to boolean', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['is_minified' => true, 'theme_id' => $theme->id]);

        expect($asset->is_minified)->toBeBool()
            ->and($asset->is_minified)->toBeTrue();
    });

    test('it casts is_compressed to boolean', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['is_compressed' => true, 'theme_id' => $theme->id]);

        expect($asset->is_compressed)->toBeBool()
            ->and($asset->is_compressed)->toBeTrue();
    });

    test('it casts order to integer', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['order' => '5', 'theme_id' => $theme->id]);

        expect($asset->order)->toBeInt()
            ->and($asset->order)->toBe(5);
    });

    test('it casts should_bundle to boolean', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['should_bundle' => true, 'theme_id' => $theme->id]);

        expect($asset->should_bundle)->toBeBool()
            ->and($asset->should_bundle)->toBeTrue();
    });

    test('asset belongs to theme', function (): void {
        $theme = Theme::factory()->create(['name' => 'Test Theme']);
        $asset = Asset::factory()->create(['theme_id' => $theme->id]);

        expect($asset->theme->name)->toBe('Test Theme');
    });

    test('asset can have css type', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['type' => 'css', 'theme_id' => $theme->id]);

        expect($asset->type)->toBe('css');
    });

    test('asset can have js type', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['type' => 'js', 'theme_id' => $theme->id]);

        expect($asset->type)->toBe('js');
    });

    test('asset has timestamps', function (): void {
        $theme = Theme::factory()->create();
        $asset = Asset::factory()->create(['theme_id' => $theme->id]);

        expect($asset->created_at)->not->toBeNull()
            ->and($asset->updated_at)->not->toBeNull();
    });
});
