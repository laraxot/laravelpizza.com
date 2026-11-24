<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\BaseModel;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * Asset is an OPTIONAL model that is NOT part of the UI module artifact set
 * (no Models/Asset.php, no AssetFactory, no create_assets_table migration).
 * The tests reach it through a class name resolved at runtime, so PHPStan never
 * needs the class to exist and no ignore annotation is required; the class_exists()
 * guard below skips them while the model is absent. Per no-phpstan-probe-models we
 * do NOT create a fake probe model just to satisfy the analyser. When the Asset
 * model + AssetFactory are actually added, replace the class name with
 * `Asset::class` (see CategoryModelTest).
 */

uses(TestCase::class);

$assetClass = 'Modules\UI\Models\Asset';

/**
 * Narrows the optional Asset class to a BaseModel subclass, failing loudly if it exists with another parent.
 */
$assetModel = /** @return class-string<BaseModel> */ static function (string $class = 'Modules\UI\Models\Asset'): string {
    if (! is_a($class, BaseModel::class, true)) {
        Assert::fail('Asset model must extend '.BaseModel::class.'.');
    }

    return $class;
};

beforeEach(function () use ($assetClass): void {
    if (! class_exists($assetClass)) {
        Assert::markTestSkipped('Asset model is not part of the UI module artifact set.');
    }
});

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
        $casts = $asset->getCasts();
        Assert::assertSame('boolean', $casts['is_minified']);
        Assert::assertSame('boolean', $casts['is_compressed']);
        Assert::assertSame('integer', $casts['order']);
        Assert::assertSame('boolean', $casts['should_bundle']);
    });

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
        if ($fileName === false) {
            Assert::fail('Asset model has no source file.');
        }
        $content = file_get_contents($fileName);
        Assert::assertStringContainsString('declare(strict_types=1);', $content);
    });

    test('has correct namespace', function () use ($assetModel): void {
        $reflection = new \ReflectionClass($assetModel());
        Assert::assertSame('Modules\UI\Models', $reflection->getNamespaceName());
    });
});
