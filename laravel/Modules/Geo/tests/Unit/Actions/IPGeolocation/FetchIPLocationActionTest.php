<?php

declare(strict_types=1);

use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\IPGeolocation\FetchIPLocationAction;
use Modules\Geo\Datas\IPLocationData;

beforeEach(function () {
    // @var mixed mockHandler = new MockHandler(;
    $handlerStack = HandlerStack::create(// @var mixed mockHandler;
    $client = new Client(['handler' => $handlerStack]);

    // @var mixed action = new FetchIPLocationAction($client;
});

it('throws exception when ip-api returns failure status', function (): void {
    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'fail',
        'message' => 'invalid query',
    ])));

    expect(fn () => // @var mixed action->execute('8.8.8.8'
        ->toThrow(RuntimeException::class, 'Failed to get IP location: invalid query');
});

it('returns ip location data for valid response', function (): void {
    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'success',
        'country' => 'United States',
        'countryCode' => 'US',
        'region' => 'VA',
        'regionName' => 'Virginia',
        'city' => 'Ashburn',
        'lat' => 39.03,
        'lon' => -77.5,
        'timezone' => 'America/New_York',
        'isp' => 'Google LLC',
    ])));

    $result = // @var mixed action->execute('8.8.8.8';

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('8.8.8.8')
        ->and($result->city)->toBe('Ashburn')
        ->and($result->region)->toBe('Virginia')
        ->and($result->country)->toBe('US')
        ->and($result->countryName)->toBe('United States')
        ->and($result->latitude)->toBe(39.03)
        ->and($result->longitude)->toBe(-77.5)
        ->and($result->timezone)->toBe('America/New_York')
        ->and($result->isp)->toBe('Google LLC');
});

it('handles response with null values', function (): void {
    // @var mixed mockHandler->append(new Response(200, [], json_encode([
        'status' => 'success',
    ])));

    $result = // @var mixed action->execute('127.0.0.1';

    expect($result)
        ->toBeInstanceOf(IPLocationData::class)
        ->and($result->ip)->toBe('127.0.0.1')
        ->and($result->city)->toBeNull()
        ->and($result->region)->toBeNull()
        ->and($result->country)->toBeNull();
});
