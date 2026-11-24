<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

<<<<<<< HEAD
use Modules\UI\Models\Asset;
=======
use Modules\UI\Models\BaseModel;
>>>>>>> laraxot/dev
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * Asset is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Asset.php, no AssetFactory, no create_assets_table migration).
<<<<<<< HEAD
 * These tests skip at runtime via the class_exists() guard below. The inline
 * phpstan-ignore annotations are required because PHPStan analyses the body
 * statically regardless of the runtime skip. Per docs/wiki/rules/no-phpstan-probe-models.md
 * we do NOT create a fake probe model just to satisfy the analyser: we annotate
 * the real (skipped) test with a justification instead. When the Asset model +
 * AssetFactory are actually added, switch these calls to the typed model usage
 * (see CategoryModelTest) and drop the ignores.
=======
 * The tests reach it through a class name resolved at runtime, so PHPStan never
 * needs the class to exist and no ignore annotation is required; the class_exists()
 * guard below skips them while the model is absent. Per no-phpstan-probe-models we
 * do NOT create a fake probe model just to satisfy the analyser. When the Asset
 * model + AssetFactory are actually added, replace the class name with
 * `Asset::class` (see CategoryModelTest).
>>>>>>> laraxot/dev
 */

uses(TestCase::class);

<<<<<<< HEAD
beforeEach(function (): void {
    /* @var \Modules\UI\Tests\TestCase $this */
    if (! class_exists('Modules\UI\Models\Asset')) {
=======
$assetClass = 'Modules\UI\Models\Asset';

/**
 * Narrows the optional Asset class to a BaseModel subclass, failing loudly if it exists with another parent.
 */
$assetModel = /** @return class-string<BaseModel> */ static function (string $class = 'Modules\UI\Models\Asset'): string {
    if (! is_a($class, BaseModel::class, true)) {
        Assert::fail('Asset model must extend ' . BaseModel::class . '.');
    }

    return $class;
};

beforeEach(function () use ($assetClass): void {
    if (! class_exists($assetClass)) {
>>>>>>> laraxot/dev
        Assert::markTestSkipped('Asset model is not part of the UI module artifact set.');
    }
});

<<<<<<< HEAD
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
=======
describe('Asset Model', function () use ($assetClass, $assetModel): void {
    test('can be instantiated', function () use ($assetModel): void {
        $modelClass = $assetModel();
        $asset = new $modelClass;
        Assert::assertInstanceOf($modelClass, $asset);
    });

    test('has fillable attributes', function () use ($assetModel): void {
        $expected = ['name', 'type', 'path', 'theme_id', 'is_minified', 'is_compressed', 'order', 'should_bundle'];

        $modelClass = $assetModel();
        $asset = new $modelClass;
        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $asset->getFillable(), true));
        }
    });

    test('has casts defined', function () use ($assetModel): void {
        $modelClass = $assetModel();
        $asset = new $modelClass;
>>>>>>> laraxot/dev
        $casts = $asset->getCasts();
        Assert::assertSame('boolean', $casts['is_minified']);
        Assert::assertSame('boolean', $casts['is_compressed']);
        Assert::assertSame('integer', $casts['order']);
        Assert::assertSame('boolean', $casts['should_bundle']);
    });

<<<<<<< HEAD
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
=======
    test('has theme relationship', function () use ($assetModel): void {
        $reflection = new \ReflectionClass($assetModel());
        Assert::assertTrue($reflection->hasMethod('theme'));
    });

    test('has correct table name', function () use ($assetModel): void {
        $modelClass = $assetModel();
        $asset = new $modelClass;
        Assert::assertSame('assets', $asset->getTable());
    });

    test('has model base class', function () use ($assetClass): void {
        Assert::assertTrue(is_a($assetClass, BaseModel::class, true));
    });

    test('uses strict types', function () use ($assetModel): void {
        $reflection = new \ReflectionClass($assetModel());
        $fileName = $reflection->getFileName();
        if (false === $fileName) {
            Assert::fail('Asset model has no source file.');
        }
>>>>>>> laraxot/dev
        $content = file_get_contents($fileName);
        Assert::assertStringContainsString('declare(strict_types=1);', $content);
    });

<<<<<<< HEAD
    test('has correct namespace', function (): void {
        /** @phpstan-ignore-next-line class.notFound (Asset model absent from artifact set) */
        $reflection = new \ReflectionClass(Asset::class);
=======
    test('has correct namespace', function () use ($assetModel): void {
        $reflection = new \ReflectionClass($assetModel());
>>>>>>> laraxot/dev
        Assert::assertSame('Modules\UI\Models', $reflection->getNamespaceName());
    });
});
