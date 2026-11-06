<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseTransactions;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class, DatabaseTransactions::class);

test('address factory persists coordinates for map picker workflows', function (): void {
    $address = AddressFactory::new()->createOne([
        'route' => 'Via Roma',
        'locality' => 'Milano',
        'latitude' => 45.4642,
        'longitude' => 9.1900,
    ]);

    Assert::assertInstanceOf(Address::class, $address);
    Assert::assertSame(45.4642, $address->latitude);
    Assert::assertSame(9.1900, $address->longitude);
});

test('address update accepts valid coordinate pair from map selection', function (): void {
    $address = AddressFactory::new()->createOne([
        'latitude' => null,
        'longitude' => null,
    ]);

    $address->update([
        'latitude' => 41.9028,
        'longitude' => 12.4964,
    ]);

    $fresh = $address->fresh();
    Assert::assertNotNull($fresh);
    Assert::assertSame(41.9028, $fresh->latitude);
    Assert::assertSame(12.4964, $fresh->longitude);
});

test('reverse geocoding fields map to schema.org postal columns', function (): void {
    $address = AddressFactory::new()->createOne([
        'latitude' => 45.4642,
        'longitude' => 9.1900,
        'route' => null,
        'locality' => null,
    ]);

    $address->update([
        'route' => 'Piazza del Duomo',
        'locality' => 'Milano',
        'administrative_area_level_2' => 'MI',
        'postal_code' => '20121',
    ]);

    $fresh = $address->fresh();
    Assert::assertNotNull($fresh);
    Assert::assertSame('Piazza del Duomo', $fresh->route);
    Assert::assertSame('Milano', $fresh->locality);
});
