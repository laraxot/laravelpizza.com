<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\Routing\TravelTimeData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('TravelTimeData fromGoogleResponse maps duration distance and status', function (): void {
    $response = [
        'status' => 'OK',
        'rows' => [
            [
                'elements' => [
                    [
                        'duration' => ['value' => 19800, 'text' => '5 ore 30 min'],
                        'duration_in_traffic' => ['value' => 22500, 'text' => '6 ore 15 min'],
                        'distance' => ['value' => 570000, 'text' => '570 km'],
                        'status' => 'OK',
                    ],
                ],
            ],
        ],
    ];

    $dto = TravelTimeData::fromGoogleResponse($response);

    Assert::assertSame(19800, $dto->duration_seconds);
    Assert::assertSame(22500, $dto->duration_in_traffic_seconds);
    Assert::assertSame(570000, $dto->distance_meters);
    Assert::assertSame('5 ore 30 min', $dto->formatted_duration);
    Assert::assertSame('OK', $dto->status);
});

test('TravelTimeData error factory returns zeroed metrics', function (): void {
    $dto = TravelTimeData::error('ZERO_RESULTS');

    Assert::assertSame(0, $dto->duration_seconds);
    Assert::assertSame('N/D', $dto->formatted_duration);
    Assert::assertSame('ZERO_RESULTS', $dto->status);
});

test('TravelTimeData fromGoogleResponse uses duration when traffic missing', function (): void {
    $response = [
        'status' => 'OK',
        'rows' => [
            [
                'elements' => [
                    [
                        'duration' => ['value' => 600, 'text' => '10 min'],
                        'distance' => ['value' => 1000, 'text' => '1 km'],
                        'status' => 'OK',
                    ],
                ],
            ],
        ],
    ];

    $dto = TravelTimeData::fromGoogleResponse($response);

    Assert::assertSame(600, $dto->duration_in_traffic_seconds);
});
