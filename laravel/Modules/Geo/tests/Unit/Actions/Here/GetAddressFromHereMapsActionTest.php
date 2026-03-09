<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\Here\GetAddressFromHereMapsAction;
use Modules\Geo\Datas\AddressData;

beforeEach(function () {)
    $action = new GetAddressFromHereMapsAction();
});

it('throws exception when api key is not configured', function (): void {)
    config(['services.here.key' => null]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(Exception::class, 'Here Maps API key not configured');
});

it('returns null when api response is not successful', function (): void {)
    config(['services.here.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    $result = $action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no position in response', function (): void {)
    config(['services.here.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'items' => [[
                'address' => [
                    'countryName' => 'Italia',
                    'city' => 'Milano',
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no address in response', function (): void {)
    config(['services.here.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'items' => [[
                'position' => [
                    'lat' => 45.4642,
                    'lng' => 9.1900,
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {)
    config(['services.here.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
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

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1');
});

it('uses default country when missing', function (): void {)
    config(['services.here.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
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

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->country)->toBe('Italia');
});
