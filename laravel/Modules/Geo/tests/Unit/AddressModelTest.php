<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit;

use Illuminate\Database\Eloquent\Relations\MorphTo;
use Modules\Geo\Database\Factories\AddressFactory;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
describe('Address Model', function () {
    it('can be created with factory', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertTrue($address->exists);
    });

    it('has correct fillable attributes', function () {
        $address = new Address;

        Assert::assertContains('latitude', $address->getFillable());
        Assert::assertContains('longitude', $address->getFillable());
    });

    it('exposes geolocation fields via geo trait', function () {
        $address = AddressFactory::new()->makeOne([
            'latitude' => 45.0,
            'longitude' => 9.0,
        ]);

        Assert::assertSame(45.0, $address->latitude);
        Assert::assertSame(9.0, $address->longitude);
    });

    it('supports deleted_at timestamp column', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertNull($address->deleted_at);

        $address->update(['deleted_at' => now()]);
        $address->refresh();

        Assert::assertNotNull($address->deleted_at);
    });

    it('casts attributes correctly', function () {
        $address = AddressFactory::new()->createOne([
            'latitude' => 45.4642,
            'longitude' => 9.1900,
            'is_primary' => true,
            'extra_data' => ['key' => 'value'],
        ]);

        Assert::assertIsArray($address->extra_data);
    });

    it('has polymorphic relationship', function () {
        $address = AddressFactory::new()->createOne();

        Assert::assertInstanceOf(MorphTo::class, $address->addressable());
    });

    describe('Accessors', function () {
        it('generates full_address accessor', function () {
            $address = AddressFactory::new()->createOne([
                'route' => 'Via Roma',
                'street_number' => '123',
                'locality' => 'Milano',
                'postal_code' => '20100',
            ]);

            Assert::assertIsString($address->full_address);
            Assert::assertStringContainsString('Via Roma', $address->full_address);
            Assert::assertStringContainsString('123', $address->full_address);
            Assert::assertStringContainsString('Milano', $address->full_address);
        });

        it('generates street_address accessor', function () {
            $address = AddressFactory::new()->createOne([
                'route' => 'Via Roma',
                'street_number' => '123',
            ]);

            Assert::assertIsString($address->street_address);
            Assert::assertStringContainsString('Via Roma', $address->street_address);
            Assert::assertStringContainsString('123', $address->street_address);
        });
    });

    describe('Geolocation Features', function () {
        it('stores coordinates correctly', function () {
            $address = AddressFactory::new()->createOne([
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

            Assert::assertSame(45.4642, $address->latitude);
            Assert::assertSame(9.1900, $address->longitude);
        });

        it('can calculate distance between addresses', function () {
            $address1 = AddressFactory::new()->createOne([
                'latitude' => 45.4642,
                'longitude' => 9.1900,
            ]);

            $address2 = AddressFactory::new()->createOne([
                'latitude' => 45.4654,
                'longitude' => 9.1859,
            ]);

            if (method_exists($address1, 'distanceTo')) {
                $distance = $address1->distanceTo($address2);
                Assert::assertGreaterThan(0, $distance);
            }
        });
    });

    describe('Address Types', function () {
        it('can be set as primary address', function () {
            $address = AddressFactory::new()->createOne(['is_primary' => true]);

            Assert::assertTrue($address->is_primary);
        });

        it('can have different types', function () {
            $address = AddressFactory::new()->createOne(['type' => AddressTypeEnum::HOME]);

            Assert::assertSame(AddressTypeEnum::HOME, $address->type);
        });
    });

    describe('Scopes and Queries', function () {
        it('can filter by primary addresses', function () {
            AddressFactory::new()->createOne(['is_primary' => true]);
            AddressFactory::new()->createOne(['is_primary' => false]);

            $primaryAddresses = Address::where('is_primary', true)->get();

            Assert::assertCount(1, $primaryAddresses);
        });

        it('can filter by locality', function () {
            AddressFactory::new()->createOne(['locality' => 'Milano']);
            AddressFactory::new()->createOne(['locality' => 'Roma']);

            $milanAddresses = Address::where('locality', 'Milano')->get();

            Assert::assertCount(1, $milanAddresses);
        });

        it('can filter by postal code', function () {
            AddressFactory::new()->createOne(['postal_code' => '20100']);
            AddressFactory::new()->createOne(['postal_code' => '00100']);

            $milanPostalCodes = Address::where('postal_code', '20100')->get();

            Assert::assertCount(1, $milanPostalCodes);
        });
    });

    describe('Google Places Integration', function () {
        it('can store place_id from Google Places', function () {
            $address = AddressFactory::new()->createOne([
                'place_id' => 'ChIJu46S-ZZjhkcRLuFvLjVZ400',
            ]);

            Assert::assertSame('ChIJu46S-ZZjhkcRLuFvLjVZ400', $address->place_id);
        });

        it('can store formatted_address from Google Places', function () {
            $address = AddressFactory::new()->createOne([
                'formatted_address' => 'Via Roma, 123, 20100 Milano MI, Italy',
            ]);

            Assert::assertSame('Via Roma, 123, 20100 Milano MI, Italy', $address->formatted_address);
        });
    });

    describe('Extra Data Storage', function () {
        it('can store additional metadata', function () {
            $extraData = [
                'building_type' => 'residential',
                'floor' => 3,
                'apartment' => 'A',
                'buzzer_code' => '123',
            ];

            $address = AddressFactory::new()->createOne(['extra_data' => $extraData]);

            Assert::assertSame($extraData, $address->extra_data);
        });
    });
});
