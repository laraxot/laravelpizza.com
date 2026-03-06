<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Actions\IPGeolocation\GetLocationFromIPAction;
use Modules\Geo\Datas\IPLocationData;

beforeEach(function () {
    $this->fetchAction = Mockery::mock(FetchIPLocationAction::class);
    $this->action = new GetLocationFromIPAction($this->fetchAction);
});

it('delegates to fetch action and returns result', function (): void {
    $this->fetchAction
        ->shouldReceive('execute')
        ->once()
        ->with('8.8.8.8')
        ->andReturn(new IPLocationData(
            ip: '8.8.8.8',
            city: 'Ashburn',
            region: null,
            country: 'US',
            countryName: 'United States',
            latitude: null,
            longitude: null,
            timezone: null,
            isp: null,
        ));

    $result = $this->action->execute('8.8.8.8');

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('8.8.8.8')
        ->and($result->city)->toBe('Ashburn');
});

it('returns null when fetch action returns null', function (): void {
    $this->fetchAction
        ->shouldReceive('execute')
        ->once()
        ->with('192.168.1.1')
        ->andThrow(new RuntimeException('not found'));

    expect(fn () => $this->action->execute('192.168.1.1'))
        ->toThrow(RuntimeException::class);
});
