<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\IPLocationData;

beforeEach(function () {
    $this->action = new FetchIPLocationAction;
});

it('throws exception when ip-api returns failure status', function (): void {
    Http::fake([
        '*' => Http::response([
            'status' => 'fail',
            'message' => 'invalid query',
        ], 200),
    ]);

    expect(fn () => $this->action->execute('8.8.8.8'))
        ->toThrow(\RuntimeException::class, 'Failed to get IP location: invalid query');
});

it('returns ip location data for valid response', function (): void {
    Http::fake([
        '*' => Http::response([
            'status' => 'success',
            'country' => 'United States',
            'countryCode' => 'US',
            'region' => 'CA',
            'regionName' => 'California',
            'city' => 'Mountain View',
            'lat' => 37.4223,
            'lon' => -122.0848,
            'timezone' => 'America/Los_Angeles',
            'isp' => 'Google LLC',
        ], 200),
    ]);

    $result = $this->action->execute('8.8.8.8');

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('8.8.8.8')
        ->and($result->city)->toBe('Mountain View')
        ->and($result->region)->toBe('California')
        ->and($result->country)->toBe('US')
        ->and($result->countryName)->toBe('United States')
        ->and($result->latitude)->toBe(37.4223)
        ->and($result->longitude)->toBe(-122.0848)
        ->and($result->timezone)->toBe('America/Los_Angeles')
        ->and($result->isp)->toBe('Google LLC');
});

it('handles response with null values', function (): void {
    Http::fake([
        '*' => Http::response([
            'status' => 'success',
        ], 200),
    ]);

    $result = $this->action->execute('127.0.0.1');

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('127.0.0.1')
        ->and($result->city)->toBeNull()
        ->and($result->region)->toBeNull()
        ->and($result->country)->toBeNull();
});
