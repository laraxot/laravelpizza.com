<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\DataTransferObjects;

use Modules\Geo\Datas\LocationData;
use Modules\Geo\DataTransferObjects\LocationDTO;
use PHPUnit\Framework\Assert;

describe('LocationDTO', function () {
    test('can be instantiated with required fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        Assert::assertInstanceOf(LocationDTO::class, $dto);

        Assert::assertSame(41.9028, $dto->latitude);

        Assert::assertSame(12.4964, $dto->longitude);

        Assert::assertNull($dto->name);
    });

    test('can be instantiated with optional name', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            name: 'Rome',
        );

        Assert::assertSame('Rome', $dto->name);
    });

    test('fromLocationData creates instance from LocationData', function () {
        $locationData = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
            address: 'Via Roma',
        );

        $dto = LocationDTO::fromLocationData($locationData);

        Assert::assertInstanceOf(LocationDTO::class, $dto);

        Assert::assertSame(45.4654, $dto->latitude);

        Assert::assertSame(9.1866, $dto->longitude);

        Assert::assertSame('Milan', $dto->name);
    });

    test('toLocationData converts to LocationData instance', function () {
        $dto = new LocationDTO(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
        );

        $locationData = $dto->toLocationData();

        Assert::assertInstanceOf(LocationData::class, $locationData);

        Assert::assertSame(45.4654, $locationData->latitude);

        Assert::assertSame(9.1866, $locationData->longitude);

        Assert::assertSame('Milan', $locationData->name);

        Assert::assertNull($locationData->address);
    });

    test('properties are readonly via readonly class', function () {
        $dto = new LocationDTO(latitude: 41.9028, longitude: 12.4964);
        $reflection = new \ReflectionClass($dto);

        Assert::assertTrue($reflection->isReadOnly());
    });

    test('round trip fromLocationData -> toLocationData preserves data', function () {
        $original = new LocationData(
            latitude: 43.7696,
            longitude: 11.2558,
            name: 'Florence',
            address: 'Piazza del Duomo',
        );

        $dto = LocationDTO::fromLocationData($original);
        $converted = $dto->toLocationData();

        Assert::assertSame($original->latitude, $converted->latitude);

        Assert::assertSame($original->longitude, $converted->longitude);

        Assert::assertSame($original->name, $converted->name);
    });

    test('handles null name in LocationData', function () {
        $locationData = new LocationData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        $dto = LocationDTO::fromLocationData($locationData);

        Assert::assertNull($dto->name);
    });
});
