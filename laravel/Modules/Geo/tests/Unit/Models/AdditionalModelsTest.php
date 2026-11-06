<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Models\County;
use Modules\Geo\Models\GeoNamesCap;
use Modules\Geo\Models\Locality;
use Modules\Geo\Models\Place;
use Modules\Geo\Models\PlaceType;
use Modules\Geo\Models\State;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('State model can be instantiated', function () {
    $state = new State;

    Assert::assertFalse($state->exists);
});

test('County model can be instantiated', function () {
    $county = new County;

    Assert::assertFalse($county->exists);
});

test('Locality model can be instantiated', function () {
    $locality = new Locality;

    Assert::assertFalse($locality->exists);
});

test('Place model can be instantiated', function () {
    $place = new Place;

    Assert::assertFalse($place->exists);
});

test('PlaceType model can be instantiated', function () {
    $placeType = new PlaceType;

    Assert::assertFalse($placeType->exists);
});

test('GeoNamesCap model can be instantiated', function () {
    $geoNamesCap = new GeoNamesCap;

    Assert::assertSame('geonames_cap', $geoNamesCap->getTable());
});
