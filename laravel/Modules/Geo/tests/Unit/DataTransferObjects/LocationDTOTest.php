<?php

declare(strict_types=1);

use Modules\Geo\Datas\LocationData;
use Modules\Geo\DataTransferObjects\LocationDTO;

describe('LocationDTO', function () {
    test('can be instantiated with required fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        expect($dto)->toBeInstanceOf(LocationDTO::class)
            ->and($dto->latitude)->toBe(41.9028)
            ->and($dto->longitude)->toBe(12.4964)
            ->and($dto->name)->toBeNull();
    });

    test('can be instantiated with optional name', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            name: 'Rome',
        );

        expect($dto->name)->toBe('Rome');
    });

    test('fromLocationData creates instance from LocationData', function () {
        $locationData = new LocationData(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
            address: 'Via Roma',
        );

        $dto = LocationDTO::fromLocationData($locationData);

        expect($dto)->toBeInstanceOf(LocationDTO::class)
            ->and($dto->latitude)->toBe(45.4654)
            ->and($dto->longitude)->toBe(9.1866)
            ->and($dto->name)->toBe('Milan');
    });

    test('toLocationData converts to LocationData instance', function () {
        $dto = new LocationDTO(
            latitude: 45.4654,
            longitude: 9.1866,
            name: 'Milan',
        );

        $locationData = $dto->toLocationData();

        expect($locationData)->toBeInstanceOf(LocationData::class)
            ->and($locationData->latitude)->toBe(45.4654)
            ->and($locationData->longitude)->toBe(9.1866)
            ->and($locationData->name)->toBe('Milan')
            ->and($locationData->address)->toBeNull();
    });

    test('properties are readonly via readonly class', function () {
        $dto = new LocationDTO(latitude: 41.9028, longitude: 12.4964);

        expect(fn () => $dto->latitude = 0.0)
            ->toThrow(Error::class);
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

        expect($converted->latitude)->toBe($original->latitude)
            ->and($converted->longitude)->toBe($original->longitude)
            ->and($converted->name)->toBe($original->name);
    });

    test('handles null name in LocationData', function () {
        $locationData = new LocationData(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        $dto = LocationDTO::fromLocationData($locationData);

        expect($dto->name)->toBeNull();
    });
});
