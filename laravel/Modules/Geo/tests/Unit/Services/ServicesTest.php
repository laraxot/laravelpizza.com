<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Services;

use PHPUnit\Framework\Assert;

<<<<<<< .merge_file_zbOlS4
<<<<<<< .merge_file_RW4e5O
<<<<<<< .merge_file_eHLUZu
uses(TestCase::class);
=======
uses(\Modules\Geo\Tests\TestCase::class);
>>>>>>> .merge_file_O4pbEA
=======
uses(\Modules\Geo\Tests\TestCase::class);
>>>>>>> .merge_file_8A33vv
=======
uses(\Modules\Geo\Tests\TestCase::class);
>>>>>>> .merge_file_KaWFnY

use Modules\Geo\Services\GeoService;
use Modules\Geo\Services\GoogleMapsService;
use Modules\Geo\Services\HereService;
<<<<<<< .merge_file_zbOlS4
<<<<<<< .merge_file_RW4e5O
<<<<<<< .merge_file_eHLUZu
use Modules\Geo\Tests\TestCase;
=======
>>>>>>> .merge_file_O4pbEA
=======
>>>>>>> .merge_file_8A33vv
=======
>>>>>>> .merge_file_KaWFnY

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
