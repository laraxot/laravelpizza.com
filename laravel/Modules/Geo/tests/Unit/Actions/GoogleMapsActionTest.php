<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\GoogleMapsAction;
use PHPUnit\Framework\Assert;

it('can be instantiated', function (): void {
    $service = new GoogleMapsAction;

    Assert::assertSame(GoogleMapsAction::class, $service::class);
});

it('has correct constants defined', function (): void {
    $reflection = new \ReflectionClass(GoogleMapsAction::class);
    Assert::assertTrue($reflection->hasConstant('GEOCODING_URL'));
    Assert::assertTrue($reflection->hasConstant('DISTANCE_MATRIX_URL'));
    Assert::assertTrue($reflection->hasConstant('ELEVATION_URL'));

    // Test that the constants have the correct values
    Assert::assertSame('https://maps.googleapis.com/maps/api/geocode/json', $reflection->getConstant('GEOCODING_URL'));
    Assert::assertSame('https://maps.googleapis.com/maps/api/distancematrix/json', $reflection->getConstant('DISTANCE_MATRIX_URL'));
    Assert::assertSame('https://maps.googleapis.com/maps/api/elevation/json', $reflection->getConstant('ELEVATION_URL'));
});

it('has required methods', function (): void {
    $reflection = new \ReflectionClass(GoogleMapsAction::class);

    foreach (['reverseGeocode', 'getDistanceMatrix', 'getElevation'] as $method) {
        Assert::assertTrue($reflection->hasMethod($method), "Missing method {$method}");
        Assert::assertTrue($reflection->getMethod($method)->isPublic(), "Method {$method} must be public");
    }
});
