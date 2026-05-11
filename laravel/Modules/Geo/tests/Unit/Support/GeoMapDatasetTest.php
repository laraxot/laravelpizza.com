<?php

declare(strict_types=1);

use Modules\Geo\Support\GeoMapDataset;

function geoMapDatasetPath(): string
{
    return '/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/data/geo-map-widget.geojson';
}

test('geo map dataset normalizes feature collection', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());

    $normalized = $dataset->toArray();

    expect($normalized['type'])->toBe('FeatureCollection')
        ->and($normalized['features'])->toBeArray()
        ->and($normalized['features'])->toHaveCount(6)
        ->and($normalized['features'][0]['type'])->toBe('Feature');
});

test('geo map dataset exposes point categories only', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());

    expect($dataset->getCategories())->toBe([
        'beekeeper',
        'farm',
        'marketplace',
        'vending_machine',
    ]);
});

test('geo map dataset computes stats for points and zones', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());

    expect($dataset->getStats())->toBe([
        'total' => 6,
        'points' => 5,
        'zones' => 1,
        'categories' => 4,
    ]);
});
