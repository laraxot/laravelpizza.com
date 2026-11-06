<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Datas;

use Modules\Geo\Datas\Photon\PhotonAddressData;
use Modules\Geo\Datas\Photon\PhotonFeatureData;
use Modules\Geo\Datas\Photon\PhotonPropertiesData;
use Modules\Geo\Datas\Photon\PhotonResponseData;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('PhotonAddressData can be instantiated', function (): void {
    $address = PhotonAddressData::from([
        'city' => 'Rome',
        'country' => 'Italy',
    ]);

    Assert::assertSame('Rome', $address->city);
});

test('PhotonFeatureData can be instantiated', function (): void {
    $feature = PhotonFeatureData::from([
        'geometry' => [
            'lat' => 41.9028,
            'lng' => 12.4964,
        ],
        'properties' => [
            'city' => 'Rome',
            'country' => 'Italy',
        ],
    ]);

    Assert::assertSame('Rome', $feature->properties->city);
});

test('PhotonPropertiesData can be instantiated', function (): void {
    $properties = PhotonPropertiesData::from([
        'city' => 'Rome',
        'country' => 'Italy',
    ]);

    Assert::assertSame('Rome', $properties->city);
});

test('PhotonResponseData can be instantiated', function (): void {
    $response = PhotonResponseData::from([
        'features' => [
            [
                'geometry' => [
                    'lat' => 41.9028,
                    'lng' => 12.4964,
                ],
                'properties' => [
                    'city' => 'Rome',
                    'country' => 'Italy',
                ],
            ],
        ],
    ]);

    Assert::assertNotNull($response->features);
    Assert::assertCount(1, $response->features);
});
