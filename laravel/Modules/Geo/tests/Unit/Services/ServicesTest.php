<?php

declare(strict_types=1);

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;

test('GeoService can be instantiated', function () {
    $service = app(GeoService::class);

    expect($service)->toBeInstanceOf(GeoService::class);
});

test('GoogleMapsService can be instantiated', function () {
    $service = app(GoogleMapsService::class);

    expect($service)->toBeInstanceOf(GoogleMapsService::class);
});

test('HereService can be instantiated', function () {
    $service = app(HereService::class);

    expect($service)->toBeInstanceOf(HereService::class);
});
