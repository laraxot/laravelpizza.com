<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit;

use Modules\Geo\Database\Factories\PlaceFactory;
use Modules\Geo\Models\Place;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('has a valid factory', function (): void {
    $place = PlaceFactory::new()->create();

    expect($place)->toBeInstanceOf(Place::class);
    expect($place->latitude)->not->toBeNull();
    expect($place->longitude)->not->toBeNull();
});

it('has linked relationship', function (): void {
    $place = PlaceFactory::new()->create();

    expect(method_exists($place, 'linked'))->toBeTrue();
    expect($place->linked())->not->toBeNull();
});

it('has placeType relationship', function (): void {
    $place = PlaceFactory::new()->create();

    expect(method_exists($place, 'placeType'))->toBeTrue();
    expect($place->placeType())->not->toBeNull();
});

it('validates coordinates', function (): void {
    $place = PlaceFactory::new()->create([
        'latitude' => 45.4642,
        'longitude' => 9.1900,
    ]);

    expect($place->hasValidCoordinates())->toBeTrue();
});

it('gets formatted address', function (): void {
    $place = PlaceFactory::new()->create([
        'formatted_address' => 'Piazza del Duomo, Milano',
    ]);

    expect($place->getFormattedAddress())->toBe('Piazza del Duomo, Milano');
});

it('gets map icon', function (): void {
    $place = PlaceFactory::new()->create();

    expect($place->getMapIcon())->not->toBeNull();
});
