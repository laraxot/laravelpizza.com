<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Location;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * Contratto di dominio Location (coordinate, componenti indirizzo, scope geografici).
 * Assert PHPUnit: evita crash pest-plugin-phpstan HigherOrderExpectationTypeExtension.
 */
describe('Location Business Logic', function () {
    test('location extends base model', function () {
        Assert::assertSame(BaseModel::class, get_parent_class(Location::class));
    });

    test('location has factory trait for testing', function () {
        Assert::assertContains(HasFactory::class, class_uses_recursive(Location::class));
    });

    test('location can be queried within distance scope', function () {
        $query = Location::withinDistance(45.4642, 9.1900, 10.0);

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('location has geographic coordinate properties', function () {
        $location = new Location();
        $location->lat = 45.4642;
        $location->lng = 9.1900;

        Assert::assertSame(45.4642, $location->lat);
        Assert::assertSame(9.1900, $location->lng);
    });

    test('location can store address components', function () {
        $location = new Location();
        $location->street = 'Via Roma 123';
        $location->city = 'Milano';
        $location->state = 'Lombardia';
        $location->zip = '20121';

        Assert::assertSame('Via Roma 123', $location->street);
        Assert::assertSame('Milano', $location->city);
        Assert::assertSame('Lombardia', $location->state);
        Assert::assertSame('20121', $location->zip);
    });

    test('location has processing status tracking', function () {
        $location = new Location();
        $location->processed = true;

        Assert::assertTrue($location->processed);
    });

    test('location can store formatted address', function () {
        $location = new Location();
        $location->formatted_address = 'Via Roma 123, 20121 Milano MI, Italy';

        Assert::assertSame('Via Roma 123, 20121 Milano MI, Italy', $location->formatted_address);
    });

    test('location can be queried by city', function () {
        $query = Location::whereCity('Milano');

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('location can be queried by coordinates', function () {
        $query = Location::whereLat(45.4642)->whereLng(9.1900);

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('location can be queried by processing status', function () {
        $query = Location::whereProcessed(true);

        Assert::assertInstanceOf(Builder::class, $query);
    });
});
