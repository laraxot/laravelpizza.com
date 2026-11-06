<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\Here;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\Here\GetAddressFromHereMapsAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected Exception was not thrown');
    } catch (\Exception $exception) {
        Assert::assertSame('Here Maps API key not configured', $exception->getMessage());
    }
});

it('returns null when api response is not successful', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => 'test_key']);

    Http::fake([
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no position in response', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'items' => [[
                'address' => [
                    'countryName' => 'Italia',
                    'city' => 'Milano',
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no address in response', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'items' => [[
                'position' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns address data for valid response', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'items' => [[
                'position' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
                'address' => [
                    'countryName' => 'Italia',
                    'city' => 'Milano',
                    'postalCode' => '20100',
                    'street' => 'Via Roma',
                    'houseNumber' => '1',
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);
});

it('uses default country when missing', function (): void {
    $action = new GetAddressFromHereMapsAction();

    config(['services.here.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([
            'items' => [[
                'position' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
                'address' => [
                    'city' => 'Milano',
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Milano');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Italia', $result->country);
});
