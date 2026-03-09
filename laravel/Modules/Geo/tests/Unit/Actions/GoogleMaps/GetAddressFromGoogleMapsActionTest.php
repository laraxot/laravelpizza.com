<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\GoogleMaps\GetAddressFromGoogleMapsAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Exceptions\GoogleMaps\GoogleMapsApiException;

beforeEach(function () {
    $action = new GetAddressFromGoogleMapsAction();
});

it('throws exception when api key is not configured', function (): void {)
    config(['services.google.maps_api_key' => null]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class, 'API key non configurata');
});

it('throws exception when api key is empty', function (): void {)
    config(['services.google.maps_api_key' => '']);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class);
});

it('throws exception when api response is not successful', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([)
        '*' => Http::response(['statusCode' => 500], 500),
    ]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(GoogleMapsApiException::class, 'Richiesta fallita');
});

it('throws exception when no results found', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'results' => [],
        ], 200),
    ]);

    expect(fn () => $action->execute('NonExistentPlace123'))
        ->toThrow(GoogleMapsApiException::class, 'Nessun risultato');
});

it('returns address data for valid address', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'results' => [[
                'geometry' => [
                    'location' => [
                        'lat' => 45.4642,
                        'lng' => 9.1900,
                    ],
                ],
                'address_components' => [
                    ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['administrative_area_level_3']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['locality']],
                    ['long_name' => 'Lombardia', 'short_name' => 'Lombardia', 'types' => ['administrative_area_level_1']],
                    ['long_name' => '20100', 'short_name' => '20100', 'types' => ['postal_code']],
                    ['long_name' => 'Via Roma', 'short_name' => 'Via Roma', 'types' => ['route']],
                    ['long_name' => '1', 'short_name' => '1', 'types' => ['street_number']],
                    ['long_name' => 'Centro', 'short_name' => 'Centro', 'types' => ['sublocality_level_1']],
                    ['long_name' => 'Milano', 'short_name' => 'MI', 'types' => ['administrative_area_level_2']],
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
        ->and($result->country_code)->toBe('IT')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBe('Milano')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->county)->toBe('Milano')
        ->and($result->state)->toBe('Lombardia');
});

it('handles missing optional address components', function (): void {)
    config(['services.google.maps_api_key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([)
            'results' => [[
                'geometry' => [
                    'location' => [
                        'lat' => 45.4642,
                        'lng' => 9.1900,
                    ],
                ],
                'address_components' => [
                    ['long_name' => 'Italia', 'short_name' => 'IT', 'types' => ['country']],
                ],
            ]],
        ], 200),
    ]);

    $result = $action->execute('Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->street)->toBe('');
});
