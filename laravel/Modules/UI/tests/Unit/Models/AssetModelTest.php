<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\Asset;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * Asset is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Asset.php, no AssetFactory, no create_assets_table migration).
 * These tests skip at runtime via the class_exists() guard below. The inline
 * phpstan-ignore annotations are required because PHPStan analyses the body
 * statically regardless of the runtime skip. Per docs/wiki/rules/no-phpstan-probe-models.md
 * we do NOT create a fake probe model just to satisfy the analyser: we annotate
 * the real (skipped) test with a justification instead. When the Asset model +
 * AssetFactory are actually added, switch these calls to the typed model usage
 * (see CategoryModelTest) and drop the ignores.
 */

uses(TestCase::class);

beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (! class_exists('Modules\UI\Models\Asset')) {
        Assert::markTestSkipped('Asset model is not part of the UI module artifact set.');
    }
});

describe('Asset Model', function (): void {
    test('can be instantiated', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $asset = new Asset;
        /* @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        Assert::assertInstanceOf(Asset::class, $asset);
    });

    test('has fillable attributes', function (): void {
        $expected = ['name', 'type', 'path', 'theme_id', 'is_minified', 'is_compressed', 'order', 'should_bundle'];

        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $asset = new Asset;
        foreach ($expected as $field) {
            /* @phpstan-ignore-next-line class.notFound, argument.type (Asset model absent from artifact set) */
            Assert::assertTrue(in_array($field, $asset->getFillable()));
        }
    });

    test('has casts defined', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $asset = new Asset;
        /**
         * @var array<string, string> $casts
         *
         * @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set)
         */
        $casts = $asset->getCasts();
        Assert::assertSame('boolean', $casts['is_minified']);
        Assert::assertSame('boolean', $casts['is_compressed']);
        Assert::assertSame('integer', $casts['order']);
        Assert::assertSame('boolean', $casts['should_bundle']);
    });

    test('has theme relationship', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $reflection = new \ReflectionClass(Asset::class);
        Assert::assertTrue($reflection->hasMethod('theme'));
    });

    test('has correct table name', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $asset = new Asset;
        /* @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        Assert::assertSame('assets', $asset->getTable());
    });

    test('has model base class', function (): void {
        /* @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        Assert::assertTrue(is_a(Asset::class, 'Modules\UI\Models\BaseModel', true));
    });

    test('uses strict types', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $reflection = new \ReflectionClass(Asset::class);
        $fileName = $reflection->getFileName();
        Assert::assertNotFalse($fileName);
        $content = file_get_contents($fileName);
        Assert::assertStringContainsString('declare(strict_types=1);', $content);
    });

    test('has correct namespace', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $reflection = new \ReflectionClass(Asset::class);
        Assert::assertSame('Modules\UI\Models', $reflection->getNamespaceName());
    });
});
