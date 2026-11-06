<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\Geocoding\GeocodingData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('GeocodingData fromGoogleResponse extracts coordinates and components', function (): void {
    $response = [
        'status' => 'OK',
        'results' => [
            [
                'geometry' => [
                    'location' => ['lat' => 45.4642, 'lng' => 9.1900],
                ],
                'formatted_address' => 'Via Roma 1, Milano MI, Italia',
                'address_components' => [
                    [
                        'long_name' => '1',
                        'short_name' => '1',
                        'types' => ['street_number'],
                    ],
                    [
                        'long_name' => 'Via Roma',
                        'short_name' => 'Via Roma',
                        'types' => ['route'],
                    ],
                    [
                        'long_name' => 'Milano',
                        'short_name' => 'Milano',
                        'types' => ['locality'],
                    ],
                    [
                        'long_name' => 'Italia',
                        'short_name' => 'IT',
                        'types' => ['country'],
                    ],
                ],
            ],
        ],
    ];

    $dto = GeocodingData::fromGoogleResponse($response);

    Assert::assertSame(45.4642, $dto->latitude);
    Assert::assertSame(9.1900, $dto->longitude);
    Assert::assertSame('Via Roma 1, Milano MI, Italia', $dto->formatted_address);
    Assert::assertSame('Via Roma', $dto->route);
    Assert::assertSame('Milano', $dto->locality);
    Assert::assertNull($dto->error);
});

test('GeocodingData error factory sets message and null coordinates', function (): void {
    $dto = GeocodingData::error('ZERO_RESULTS');

    Assert::assertNull($dto->latitude);
    Assert::assertSame('ZERO_RESULTS', $dto->error);
});
