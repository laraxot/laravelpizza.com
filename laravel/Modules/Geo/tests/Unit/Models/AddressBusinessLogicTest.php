<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Modules\Geo\Enums\AddressTypeEnum;
use Modules\Geo\Models\Address;
use Modules\Geo\Models\BaseModel;

describe('Address Business Logic', function () {
    test('address extends base model', function () {
        expect(Address::class)->toBeSubclassOf(BaseModel::class);
    });

    test('address has expected fillable fields for postal address', function () {
        $address = new Address;
        $expectedFillable = [
            'model_type',
            'model_id',
            'name',
            'description',
            'route',
            'street_number',
            'locality',
            'administrative_area_level_3',
            'administrative_area_level_2',
            'administrative_area_level_1',
            'country',
            'postal_code',
            'formatted_address',
            'place_id',
            'latitude',
            'longitude',
            'type',
            'is_primary',
            'extra_data',
        ];

        expect($address->getFillable())->toEqual($expectedFillable);
    });

    test('address has correct casts for geolocation and structured data', function () {
        $address = new Address;
        $casts = $address->getCasts();

        expect($casts['latitude'])->toBe('float');
        expect($casts['longitude'])->toBe('float');
        expect($casts['is_primary'])->toBe('boolean');
        expect($casts['extra_data'])->toBe('array');
        expect($casts['type'])->toBe(AddressTypeEnum::class);
    });

    test('address has polymorphic model relationship', function () {
        $address = new Address;

        expect(method_exists($address, 'model'))->toBeTrue();
        expect(method_exists($address, 'addressable'))->toBeTrue();
    });

    test('address can get region data from comune', function () {
        $address = new Address;

        expect(method_exists($address, 'getRegione'))->toBeTrue();
    });

    test('address can get province data from comune', function () {
        $address = new Address;

        expect(method_exists($address, 'getProvincia'))->toBeTrue();
    });

    test('address can get locality data from comune', function () {
        $address = new Address;

        expect(method_exists($address, 'getLocality'))->toBeTrue();
    });

    test('address can format full address attribute', function () {
        $address = new Address;
        $address->route = 'Via Roma';
        $address->street_number = '123';
        $address->locality = 'Milano';

        expect($address->full_address)->toContain('Via Roma 123');
        expect($address->full_address)->toContain('Milano');
    });

    test('address can format street address attribute', function () {
        $address = new Address;
        $address->route = 'Via Roma';
        $address->street_number = '123';

        expect($address->street_address)->toBe('Via Roma 123');
    });

    test('address can get geolocation coordinates', function () {
        $address = new Address;
        $address->latitude = 45.4642;
        $address->longitude = 9.1900;

        expect($address->getLatitude())->toBe(45.4642);
        expect($address->getLongitude())->toBe(9.1900);
    });

    test('address can export to schema org format', function () {
        $address = new Address;
        $address->name = 'Test Address';
        $address->route = 'Via Roma';
        $address->street_number = '123';

        $schemaOrg = $address->toSchemaOrg();

        expect($schemaOrg)->toHaveKey('@context');
        expect($schemaOrg)->toHaveKey('@type');
        expect($schemaOrg['@context'])->toBe('https://schema.org');
        expect($schemaOrg['@type'])->toBe('PostalAddress');
    });

    test('address scope can query nearby addresses', function () {
        $query = Address::nearby(45.4642, 9.1900, 10);

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('address scope can query primary addresses', function () {
        $query = Address::primary();

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('address scope can query by type', function () {
        $query = Address::ofType(AddressTypeEnum::BILLING);

        expect($query)->toBeInstanceOf(Builder::class);
    });
});
