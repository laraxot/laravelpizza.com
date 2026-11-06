<?php

declare(strict_types=1);

use Modules\Geo\Actions\Maps\GetGeoMapDatasetCategoriesAction;
use Modules\Geo\Actions\Maps\GetGeoMapDatasetStatsAction;
use Modules\Geo\Actions\Maps\LoadGeoMapDatasetAction;
use Modules\Geo\Tests\Support\GeoMapDatasetFixture;
use PHPUnit\Framework\Assert;

test('geo map dataset normalizes feature collection', function (): void {
    $path = GeoMapDatasetFixture::path();
    $normalized = app(LoadGeoMapDatasetAction::class)->execute($path);

    Assert::assertSame('FeatureCollection', $normalized['type']);
    Assert::assertIsArray($normalized['features']);
    Assert::assertCount(6, $normalized['features']);
    Assert::assertSame('Feature', $normalized['features'][0]['type']);
});

test('geo map dataset exposes point categories only', function (): void {
    $path = GeoMapDatasetFixture::path();
    $categories = app(GetGeoMapDatasetCategoriesAction::class)->execute($path);

    Assert::assertNotEmpty($categories);

    $nonStringCategories = array_filter(
        $categories,
        static fn (mixed $category): bool => ! is_string($category),
    );
    Assert::assertSame([], $nonStringCategories);
});

test('geo map dataset computes stats for points and zones', function (): void {
    $path = GeoMapDatasetFixture::path();
    $stats = app(GetGeoMapDatasetStatsAction::class)->execute($path);

    Assert::assertSame(6, $stats['total']);
    Assert::assertGreaterThan(0, $stats['points']);
    Assert::assertGreaterThan(0, $stats['zones']);
});
