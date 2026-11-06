<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\LocationDTO;
use PHPUnit\Framework\Assert;

describe('LocationDTO', function () {
    test('can be instantiated with required fields', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
        );

        Assert::assertSame(41.9028, $dto->latitude);

        Assert::assertSame(12.4964, $dto->longitude);

        Assert::assertNull($dto->address);
    });

    test('can be instantiated with optional address and city', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            address: 'Via Roma',
            city: 'Rome',
        );

        Assert::assertSame('Via Roma', $dto->address);
        Assert::assertSame('Rome', $dto->city);
    });

    test('toArray preserves the location contract', function () {
        $dto = new LocationDTO(
            latitude: 45.4654,
            longitude: 9.1866,
            address: 'Via Roma',
            city: 'Milan',
        );

        Assert::assertSame([
            'latitude' => 45.4654,
            'longitude' => 9.1866,
            'address' => 'Via Roma',
            'city' => 'Milan',
            'country' => null,
        ], $dto->toArray());
    });

    test('properties are readonly via readonly class', function () {
        $dto = new LocationDTO(latitude: 41.9028, longitude: 12.4964);
        $reflection = new \ReflectionClass($dto);

        Assert::assertTrue($reflection->isReadOnly());
    });

    test('supports an optional country', function () {
        $dto = new LocationDTO(
            latitude: 41.9028,
            longitude: 12.4964,
            country: 'Italy',
        );

        Assert::assertSame('Italy', $dto->country);
    });
});
