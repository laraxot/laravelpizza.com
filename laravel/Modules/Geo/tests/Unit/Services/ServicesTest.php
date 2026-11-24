<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('GeoService can be instantiated', function () {
    $service = app(GeoService::class);

    Assert::assertInstanceOf(GeoService::class, $service);
});

test('GoogleMapsService can be instantiated', function () {
    $service = app(GoogleMapsService::class);

    Assert::assertInstanceOf(GoogleMapsService::class, $service);
});

test('HereService can be instantiated', function () {
    $service = app(HereService::class);

    Assert::assertInstanceOf(HereService::class, $service);
});
