<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions\LocationIQ;

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\LocationIQ\GetAddressFromLocationIQAction;
use Modules\Geo\Datas\AddressData;

beforeEach(function () {
    $action = new GetAddressFromLocationIQAction();
});

it('throws exception when api key is not configured', function (): void {)
    config(['services.locationiq.key' => null]);

    expect(fn () => $action->execute('Milano, Italia'))
        ->toThrow(Exception::class, 'LocationIQ API key not configured');
});

it('returns null when api response is not successful', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response(null, 500),
    ]);

    $result = $action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no results found', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([], 200),
    ]);

    $result = $action->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns null when first result is empty', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([[]], 200),
    ]);

    $result = $action->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([[)
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

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->country_code)->toBe('it')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->locality)->toBe('Centro')
        ->and($result->county)->toBe('Milano')
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->district)->toBe('Centro')
        ->and($result->state)->toBe('Lombardia');
});

it('uses default country when missing', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([[)
            'lat' => '45.4642',
            'lon' => '9.1900',
            'address' => [],
        ]], 200),
    ]);

    $result = $action->execute('Milano');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->country)->toBe('Italia')
        ->and($result->country_code)->toBe('IT');
});

it('falls back to town and village for city', function (): void {)
    config(['services.locationiq.key' => 'test_key']);

    Http::fake([)
        '*' => Http::response([[)
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

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->city)->toBe('Cinisello Balsamo');
});
