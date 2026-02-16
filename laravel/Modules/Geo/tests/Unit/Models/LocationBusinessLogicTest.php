<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Location;

describe('Location Business Logic', function () {
    test('location extends base model', function () {
        expect(Location::class)->toBeSubclassOf(BaseModel::class);
    });

    test('location has factory trait for testing', function () {
        $traits = class_uses(Location::class);

        expect($traits)->toHaveKey(HasFactory::class);
    });

    test('location can be queried within distance scope', function () {
        $query = Location::withinDistance(45.4642, 9.1900, 10.0);

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('location has geographic coordinate properties', function () {
        $location = new Location;
        $location->lat = 45.4642;
        $location->lng = 9.1900;

        expect($location->lat)->toBe(45.4642);
        expect($location->lng)->toBe(9.1900);
    });

    test('location can store address components', function () {
        $location = new Location;
        $location->street = 'Via Roma 123';
        $location->city = 'Milano';
        $location->state = 'Lombardia';
        $location->zip = '20121';

        expect($location->street)->toBe('Via Roma 123');
        expect($location->city)->toBe('Milano');
        expect($location->state)->toBe('Lombardia');
        expect($location->zip)->toBe('20121');
    });

    test('location has processing status tracking', function () {
        $location = new Location;
        $location->processed = true;

        expect($location->processed)->toBe(true);
    });

    test('location can store formatted address', function () {
        $location = new Location;
        $location->formatted_address = 'Via Roma 123, 20121 Milano MI, Italy';

        expect($location->formatted_address)->toBe('Via Roma 123, 20121 Milano MI, Italy');
    });

    test('location can be queried by city', function () {
        $query = Location::whereCity('Milano');

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('location can be queried by coordinates', function () {
        $query = Location::whereLat(45.4642)->whereLng(9.1900);

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('location can be queried by processing status', function () {
        $query = Location::whereProcessed(true);

        expect($query)->toBeInstanceOf(Builder::class);
    });
});
