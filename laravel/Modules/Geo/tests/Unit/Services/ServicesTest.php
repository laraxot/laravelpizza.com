<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_eHLUZu
uses(TestCase::class);
=======
uses(\Modules\Geo\Tests\TestCase::class);
>>>>>>> .merge_file_O4pbEA

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;
<<<<<<< .merge_file_eHLUZu
use Modules\Geo\Tests\TestCase;
=======
>>>>>>> .merge_file_O4pbEA

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
