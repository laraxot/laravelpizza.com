<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Adapters;

use Modules\Geo\Adapters\GoogleMapsClient;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);

it('can be instantiated as the Google Maps adapter', function (): void {})->todo();

it('exposes the Google Maps operations', function (): void {
    $methods = get_class_methods(GoogleMapsClient::class);

    Assert::assertContains('reverseGeocode', $methods);
    Assert::assertContains('getDistanceMatrix', $methods);
    Assert::assertContains('getElevation', $methods);
});
