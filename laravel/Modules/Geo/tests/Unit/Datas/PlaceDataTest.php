<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\Geocoding\PlaceData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('PlaceData fromNominatim maps display name and coordinates', function (): void {
    $dto = PlaceData::fromNominatim([
        'place_id' => 12345,
        'display_name' => 'Duomo di Milano, Milano, Italia',
        'lat' => '45.4642',
        'lon' => '9.1900',
        'type' => 'attraction',
        'address' => [
            'city' => 'Milano',
            'country' => 'Italia',
        ],
    ]);

    Assert::assertSame(12345, $dto->placeId);
    Assert::assertSame('Duomo di Milano, Milano, Italia', $dto->displayName);
    Assert::assertSame(45.4642, $dto->latitude);
    Assert::assertSame(9.1900, $dto->longitude);
    Assert::assertSame('attraction', $dto->type);
    Assert::assertSame('Milano', $dto->addressComponents['city']);
});

test('PlaceData constructor accepts minimal Nominatim fields', function (): void {
    $dto = new PlaceData(
        placeId: 1,
        displayName: 'Test',
        latitude: 41.0,
        longitude: 12.0,
        type: 'city',
    );

    Assert::assertNull($dto->address);
    Assert::assertSame([], $dto->extraData);
});
