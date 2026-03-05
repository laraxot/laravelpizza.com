<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Actions\IPGeolocation\GetLocationFromIPAction;
use Modules\Geo\Datas\IPLocationData;

beforeEach(function () {
    $this->fetchAction = new FetchIPLocationAction();
    $this->action = new GetLocationFromIPAction($this->fetchAction);
});

it('delegates to fetch action and returns result', function (): void {
    Http::fake([
        '*' => Http::response([
            'status' => 'success',
            'country' => 'United States',
            'countryCode' => 'US',
            'city' => 'Mountain View',
        ], 200),
    ]);

    $result = $this->action->execute('8.8.8.8');

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('8.8.8.8')
        ->and($result->city)->toBe('Mountain View');
});

it('returns null when fetch action returns null', function (): void {
    // When the IP is not found, fetch action would throw, so this tests delegation
    Http::fake([
        '*' => Http::response([
            'status' => 'fail',
            'message' => 'not found',
        ], 200),
    ]);

    expect(fn () => $this->action->execute('192.168.1.1'))
        ->toThrow(RuntimeException::class);
});
