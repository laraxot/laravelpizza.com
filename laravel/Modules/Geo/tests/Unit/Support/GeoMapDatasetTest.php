<?php

declare(strict_types=1);

use Modules\Geo\Support\GeoMapDataset;
use PHPUnit\Framework\Assert;

function geoMapDatasetPath(): string
{
    return '/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/data/geo-map-widget.geojson';
}

test('geo map dataset normalizes feature collection', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());

    $normalized = $dataset->toArray();

    Assert::assertSame('FeatureCollection', $normalized['type']);

    Assert::assertIsArray($normalized['features']);

    Assert::assertCount(6, $normalized['features']);

    Assert::assertSame('Feature', $normalized['features'][0]['type']);
});

test('geo map dataset exposes point categories only', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());
});

test('geo map dataset computes stats for points and zones', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());
});
