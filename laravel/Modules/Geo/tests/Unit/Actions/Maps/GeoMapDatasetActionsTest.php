<?php

declare(strict_types=1);

use Modules\Geo\Actions\Maps\GetGeoMapDatasetCategoriesAction;
use Modules\Geo\Actions\Maps\GetGeoMapDatasetStatsAction;
use Modules\Geo\Actions\Maps\LoadGeoMapDatasetAction;
use Modules\Geo\Tests\Support\GeoMapDatasetFixture;
use PHPUnit\Framework\Assert;

test('load geo map dataset normalizes feature collection', function (): void {
    $normalized = app(LoadGeoMapDatasetAction::class)->execute(GeoMapDatasetFixture::path());

    Assert::assertSame('FeatureCollection', $normalized['type']);
    Assert::assertIsArray($normalized['features']);
    Assert::assertCount(6, $normalized['features']);
    Assert::assertSame('Feature', $normalized['features'][0]['type']);
});

test('geo map dataset exposes point categories only', function (): void {
    $categories = app(GetGeoMapDatasetCategoriesAction::class)->execute(GeoMapDatasetFixture::path());

    Assert::assertIsArray($categories);
    Assert::assertNotEmpty($categories);
});

test('geo map dataset computes stats for points and zones', function (): void {
    $stats = app(GetGeoMapDatasetStatsAction::class)->execute(GeoMapDatasetFixture::path());

    Assert::assertSame(6, $stats['total']);
    Assert::assertGreaterThan(0, $stats['points']);
    Assert::assertGreaterThan(0, $stats['zones']);
    Assert::assertGreaterThan(0, $stats['categories']);
});
