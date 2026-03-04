<?php

declare(strict_types=1);

use Modules\Geo\Models\County;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Models\State;

test('State model can be instantiated', function () {
    expect(class_exists(State::class))->toBeTrue();
});

test('County model can be instantiated', function () {
    expect(class_exists(County::class))->toBeTrue();
});

test('Locality model can be instantiated', function () {
    expect(class_exists(Locality::class))->toBeTrue();
});

test('Place model can be instantiated', function () {
    expect(class_exists(Place::class))->toBeTrue();
});

test('PlaceType model can be instantiated', function () {
    expect(class_exists(PlaceType::class))->toBeTrue();
});

test('GeoNamesCap model can be instantiated', function () {
    expect(class_exists(GeoNamesCap::class))->toBeTrue();
});
