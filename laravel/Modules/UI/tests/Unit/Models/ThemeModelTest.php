<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\BaseModel;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Theme is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Theme.php, no ThemeFactory, no create_themes_table migration).
 * The tests reach it through a class name resolved at runtime, so PHPStan never
 * needs the class to exist and no ignore annotation is required; the class_exists()
 * guard below skips them while the model is absent. Per no-phpstan-probe-models we
 * do NOT create a fake probe model just to satisfy the analyser. When the Theme
 * model + ThemeFactory are actually added, replace the class name with
 * `Theme::class` and use the typed `ThemeFactory::new()->createOne()` pattern
 * (see CategoryModelTest). Attributes are read with data_get() because the model
 * (and so its column docblocks) does not exist yet.
 */

uses(TestCase::class);

/**
 * Narrows the optional Theme class to a BaseModel subclass, failing loudly if it exists with another parent.
 */
$themeModel = /** @return class-string<BaseModel> */ static function (string $class = 'Modules\UI\Models\Theme'): string {
    if (! is_a($class, BaseModel::class, true)) {
        Assert::fail('Theme model must extend ' . BaseModel::class . '.');
    }

    return $class;
};

beforeEach(function (): void {
    if (! class_exists('Modules\UI\Models\Theme')) {
        Assert::markTestSkipped('Theme model is not part of the UI module artifact set.');
    }
});

describe('Theme Model', function () use ($themeModel): void {
    test('it can create a theme with valid data', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne([
            'name' => 'Test Theme',
            'is_active' => true,
        ]);

        Assert::assertSame('Test Theme', data_get($theme, 'name'));
        Assert::assertTrue(data_get($theme, 'is_active'));
    });

    test('it has fillable attributes', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = new $modelClass;
        $expected = ['name', 'description', 'is_active', 'config', 'parent_id', 'source_path', 'compiled_path', 'needs_compilation'];

        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $theme->getFillable(), true));
        }
    });

    test('it casts is active to boolean', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne(['is_active' => '1']);

        Assert::assertIsBool(data_get($theme, 'is_active'));
        Assert::assertTrue(data_get($theme, 'is_active'));
    });

    test('it casts config to array', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne([
            'config' => ['primary_color' => '#ff0000', 'font_family' => 'Roboto'],
        ]);

        Assert::assertIsArray(data_get($theme, 'config'));
        Assert::assertSame('#ff0000', data_get($theme, 'config.primary_color'));
    });

    test('it casts needs compilation to boolean', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne(['needs_compilation' => true]);

        Assert::assertIsBool(data_get($theme, 'needs_compilation'));
        Assert::assertTrue(data_get($theme, 'needs_compilation'));
    });

    test('theme can have parent theme', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $parent = $modelClass::factory()->createOne(['name' => 'Parent Theme']);
        $child = $modelClass::factory()->createOne(['name' => 'Child Theme', 'parent_id' => data_get($parent, 'id')]);

        Assert::assertSame('Parent Theme', data_get($child, 'parent.name'));
    });

    test('theme can be active', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne(['is_active' => true]);

        Assert::assertTrue(data_get($theme, 'is_active'));
    });

    test('theme can be inactive', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne(['is_active' => false]);

        Assert::assertFalse(data_get($theme, 'is_active'));
    });

    test('theme has timestamps', function () use ($themeModel): void {
        $modelClass = $themeModel();
        $theme = $modelClass::factory()->createOne();

        Assert::assertNotNull(data_get($theme, 'created_at'));
        Assert::assertNotNull(data_get($theme, 'updated_at'));
    });
});
