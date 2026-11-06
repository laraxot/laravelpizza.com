<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\LocationIQ;

use Illuminate\Support\Facades\Http;
use Modules\Geo\Actions\LocationIQ\GetAddressFromLocationIQAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\LightTestCase;
use PHPUnit\Framework\Assert;

uses(LightTestCase::class);
it('throws exception when api key is not configured', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => null]);

    try {
        $action->execute('Milano, Italia');

        Assert::fail('Expected Exception was not thrown');
    } catch (\Exception $exception) {
        Assert::assertSame('LocationIQ API key not configured', $exception->getMessage());
    }
});

it('returns null when api response is not successful', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response(null, 500),
    ]);

    $result = $action->execute('Milano, Italia');

    Assert::assertNull($result);
});

it('returns null when no results found', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([], 200),
    ]);

    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns null when first result is empty', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[]], 200),
    ]);

    $result = $action->execute('NonExistentPlace');

    Assert::assertNull($result);
});

it('returns address data for valid response', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [
                'country' => 'Italia',
                'city' => 'Milano',
                'town' => null,
                'village' => null,
                'country_code' => 'it',
                'postcode' => '20100',
                'suburb' => 'Centro',
                'county' => 'Milano',
                'road' => 'Via Roma',
                'house_number' => '1',
                'state' => 'Lombardia',
            ],
        ]], 200),
    ]);

    $result = $action->execute('Via Roma 1, Milano, Italia');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame(45.4642, $result->latitude);

    Assert::assertSame(9.1900, $result->longitude);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('Milano', $result->city);

    Assert::assertSame('it', $result->country_code);

    Assert::assertSame(20100, $result->postal_code);

    Assert::assertSame('Centro', $result->locality);

    Assert::assertSame('Milano', $result->county);

    Assert::assertSame('Via Roma', $result->street);

    Assert::assertSame('1', $result->street_number);

    Assert::assertSame('Centro', $result->district);

    Assert::assertSame('Lombardia', $result->state);
});

it('uses default country when missing', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [],
        ]], 200),
    ]);

    $result = $action->execute('Milano');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Italia', $result->country);

    Assert::assertSame('IT', $result->country_code);
});

it('falls back to town and village for city', function (): void {
    $action = new GetAddressFromLocationIQAction();

    config(['services.locationiq.key' => 'test_key']);

    Http::fake([
        '*' => Http::response([[
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [
                'country' => 'Italia',
                'town' => 'Cinisello Balsamo',
                'country_code' => 'it',
            ],
        ]], 200),
    ]);

    $result = $action->execute('Cinisello Balsamo');

    Assert::assertInstanceOf(AddressData::class, $result);

    Assert::assertSame('Cinisello Balsamo', $result->city);
});
