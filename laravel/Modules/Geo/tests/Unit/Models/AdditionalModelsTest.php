<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Geo\Models\County;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Models\State;
use Modules\Geo\Tests\TestCase;

test('State model can be instantiated', function () {
    $state = new State();

    expect($state)->toBeInstanceOf(State::class);
});

test('County model can be instantiated', function () {
    $county = new County();

    expect($county)->toBeInstanceOf(County::class);
});

test('Locality model can be instantiated', function () {
    $locality = new Locality();

    expect($locality)->toBeInstanceOf(Locality::class);
});

test('Place model can be instantiated', function () {
    $place = new Place();

    expect($place)->toBeInstanceOf(Place::class);
});

test('PlaceType model can be instantiated', function () {
    $placeType = new PlaceType();

    expect($placeType)->toBeInstanceOf(PlaceType::class);
});

test('GeoNamesCap model can be instantiated', function () {
    $geoNamesCap = new GeoNamesCap();

    expect($geoNamesCap)->toBeInstanceOf(GeoNamesCap::class);
});
