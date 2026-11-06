<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('address can be created', function (): void {
    $address = AddressFactory::new()->createOne();

    Assert::assertInstanceOf(Address::class, $address);
});

test('address has fillable attributes', function (): void {
    $address = new Address;
    $fillable = $address->getFillable();

    Assert::assertContains('route', $fillable);
    Assert::assertContains('street_number', $fillable);
    Assert::assertContains('postal_code', $fillable);
    Assert::assertContains('locality', $fillable);
});

test('address has casts defined', function (): void {
    $address = new Address;
    $casts = $address->getCasts();

    Assert::assertArrayHasKey('latitude', $casts);
    Assert::assertArrayHasKey('longitude', $casts);
    Assert::assertArrayHasKey('is_primary', $casts);
    Assert::assertSame(AddressTypeEnum::class, $casts['type']);
});

test('address has proper table name', function (): void {
    $address = new Address;

    Assert::assertSame('addresses', $address->getTable());
});

test('address morphs to parent model', function (): void {
    $address = new Address;

    Assert::assertSame('addressable', $address->addressable()->getRelationName());
});

test('address can build full address string', function (): void {
    $address = AddressFactory::new()->createOne([
        'route' => 'Via Roma',
        'street_number' => '123',
        'postal_code' => '00100',
        'locality' => 'Roma',
    ]);

    $fullAddress = $address->getFullAddressAttribute();

    Assert::assertStringContainsString('Via Roma', $fullAddress);
    Assert::assertStringContainsString('00100', $fullAddress);
    Assert::assertStringContainsString('Roma', $fullAddress);
});

test('address can be queried by locality', function (): void {
    $address = AddressFactory::new()->createOne(['locality' => 'Milano-Test-Unique']);

    $results = Address::query()->where('locality', 'Milano-Test-Unique')->get();

    Assert::assertCount(1, $results);
    Assert::assertSame($address->id, $results->first()?->id);
});

test('address distance scope accepts southern and western hemisphere coordinates', function (): void {
    $query = Address::query()->withDistance(-33.8688, -70.6693);

    Assert::assertStringContainsString('distance', $query->toSql());
});

test('address can be filtered by postal code', function (): void {
    $address = AddressFactory::new()->createOne(['postal_code' => '99999-Test']);

    $results = Address::query()->where('postal_code', '99999-Test')->get();

    Assert::assertCount(1, $results);
    Assert::assertSame($address->id, $results->first()?->id);
});

test('address exposes latitude and longitude getters', function (): void {
    $address = AddressFactory::new()->createOne([
        'latitude' => 41.9028,
        'longitude' => 12.4964,
    ]);

    Assert::assertSame(41.9028, $address->getLatitude());
    Assert::assertSame(12.4964, $address->getLongitude());
});

test('address primary scope filters primary records', function (): void {
    AddressFactory::new()->createOne(['is_primary' => false]);
    $primary = AddressFactory::new()->createOne(['is_primary' => true]);

    $results = Address::query()->primary()->get();

    Assert::assertTrue($results->contains('id', $primary->id));
});
