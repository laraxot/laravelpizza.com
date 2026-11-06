<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\AddressData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('AddressData getFormattedAddress joins street city and country', function (): void {
    $dto = new AddressData(
        latitude: 45.4642,
        longitude: 9.1900,
        country: 'Italia',
        city: 'Milano',
        street: 'Via Roma',
        street_number: '1',
        state: 'MI',
        postal_code: 20100,
    );

    $formatted = $dto->getFormattedAddress();

    Assert::assertStringContainsString('Via Roma, 1', $formatted);
    Assert::assertStringContainsString('Milano', $formatted);
    Assert::assertStringContainsString('Italia', $formatted);
});

test('AddressData stores coordinates as readonly floats', function (): void {
    $dto = new AddressData(
        latitude: 41.9028,
        longitude: 12.4964,
        locality: 'Roma',
    );

    Assert::assertSame(41.9028, $dto->latitude);
    Assert::assertSame(12.4964, $dto->longitude);
    Assert::assertSame('Roma', $dto->locality);
});
