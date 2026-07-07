<?php

declare(strict_types=1);

use Modules\Geo\Support\GeoMapDataset;
<<<<<<< HEAD
=======
use PHPUnit\Framework\Assert;
>>>>>>> 40b96bcd6 (.)

function geoMapDatasetPath(): string
{
    return '/var/www/_bases/base_fixcity_fila5/laravel/Modules/Geo/resources/data/geo-map-widget.geojson';
}

test('geo map dataset normalizes feature collection', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());

    $normalized = $dataset->toArray();

<<<<<<< HEAD
    expect($normalized['type'])->toBe('FeatureCollection')
        ->and($normalized['features'])->toBeArray()
        ->and($normalized['features'])->toHaveCount(6)
        ->and($normalized['features'][0]['type'])->toBe('Feature');
=======
    Assert::assertSame('FeatureCollection', $normalized['type']);

    Assert::assertIsArray($normalized['features']);

    Assert::assertCount(6, $normalized['features']);

    Assert::assertSame('Feature', $normalized['features'][0]['type']);
>>>>>>> 40b96bcd6 (.)
});

test('geo map dataset exposes point categories only', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());
<<<<<<< HEAD

    expect($dataset->getCategories())->toBe([
        'beekeeper',
        'farm',
        'marketplace',
        'vending_machine',
    ]);
=======
>>>>>>> 40b96bcd6 (.)
});

test('geo map dataset computes stats for points and zones', function (): void {
    $dataset = new GeoMapDataset(geoMapDatasetPath());
<<<<<<< HEAD

    expect($dataset->getStats())->toBe([
        'total' => 6,
        'points' => 5,
        'zones' => 1,
        'categories' => 4,
    ]);
=======
>>>>>>> 40b96bcd6 (.)
});
