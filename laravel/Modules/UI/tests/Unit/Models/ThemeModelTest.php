<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\Theme;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

/*
 * Theme is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Theme.php, no ThemeFactory, no create_themes_table migration).
 * These tests skip at runtime via the class_exists() guard below. The inline
 * phpstan-ignore annotations are required because PHPStan analyses the body
 * statically regardless of the runtime skip. Per docs/wiki/rules/no-phpstan-probe-models.md
 * we do NOT create a fake probe model just to satisfy the analyser: we annotate
 * the real (skipped) test with a justification instead. When the Theme model +
 * ThemeFactory are actually added, switch these calls to the typed
 * `ThemeFactory::new()->createOne()` pattern (see CategoryModelTest) and drop
 * the ignores.
 */

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (! class_exists('Modules\UI\Models\Theme')) {
        Assert::markTestSkipped('Theme model is not part of the UI module artifact set.');
    }
});

describe('Theme Model', function (): void {
    test('it can create a theme with valid data', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set (test skipped at runtime)) */
        $theme = Theme::factory()->createOne([
            'name' => 'Test Theme',
            'is_active' => true,
        ]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertSame('Test Theme', $theme->name);
        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertTrue($theme->is_active);
    });

    test('it has fillable attributes', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Theme model absent from artifact set) */
        $theme = new Theme;
        $expected = ['name', 'description', 'is_active', 'config', 'parent_id', 'source_path', 'compiled_path', 'needs_compilation'];

        foreach ($expected as $field) {
            /* @phpstan-ignore-next-line class.notFound (Theme model absent from artifact set) */
            Assert::assertTrue(in_array($field, $theme->getFillable(), true));
        }
    });

    test('it casts is active to boolean', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne(['is_active' => '1']);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertIsBool($theme->is_active);
        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertTrue($theme->is_active);
    });

    test('it casts config to array', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne([
            'config' => ['primary_color' => '#ff0000', 'font_family' => 'Roboto'],
        ]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertIsArray($theme->config);
        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertSame('#ff0000', $theme->config['primary_color']);
    });

    test('it casts needs compilation to boolean', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne(['needs_compilation' => true]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertIsBool($theme->needs_compilation);
        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertTrue($theme->needs_compilation);
    });

    test('theme can have parent theme', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $parent = Theme::factory()->createOne(['name' => 'Parent Theme']);
        /** @phpstan-ignore-next-line class.notFound, method.nonObject, property.nonObject (Theme model absent from artifact set) */
        $child = Theme::factory()->createOne(['name' => 'Child Theme', 'parent_id' => $parent->id]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertSame('Parent Theme', $child->parent->name);
    });

    test('theme can be active', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne(['is_active' => true]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertTrue($theme->is_active);
    });

    test('theme can be inactive', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne(['is_active' => false]);

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertFalse($theme->is_active);
    });

    test('theme has timestamps', function (): void {
        /** @phpstan-ignore-next-line class.notFound, method.nonObject (Theme model absent from artifact set) */
        $theme = Theme::factory()->createOne();

        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertNotNull($theme->created_at);
        /* @phpstan-ignore-next-line property.nonObject (Theme model absent from artifact set) */
        Assert::assertNotNull($theme->updated_at);
    });
});
