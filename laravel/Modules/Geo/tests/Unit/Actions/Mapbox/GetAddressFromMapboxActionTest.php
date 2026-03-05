<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use Modules\Geo\Tests\LightTestCase;

uses(LightTestCase::class);
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Mapbox\GetAddressFromMapboxAction;
use Modules\Geo\Datas\AddressData;

beforeEach(function () {
    $this->mockHandler = new MockHandler();
    $handlerStack = HandlerStack::create($this->mockHandler);
    $this->client = new Client(['handler' => $handlerStack]);
    $this->action = new GetAddressFromMapboxAction($this->client);
});

it('throws exception when api key is not configured', function (): void {
    config(['services.mapbox.access_token' => null]);

    expect(fn () => $this->action->execute('Milano, Italia'))
        ->toThrow(RuntimeException::class, 'Mapbox access token not configured');
});

it('throws exception for empty address', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    expect(fn () => $this->action->execute(''))
        ->toThrow(RuntimeException::class, 'Address cannot be empty');
});

it('throws exception for too long address', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $longAddress = str_repeat('a', 1001);

    expect(fn () => $this->action->execute($longAddress))
        ->toThrow(RuntimeException::class, 'Address is too long');
});

it('throws exception for guzzle exception', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new GuzzleHttp\Exception\RequestException('Error', new GuzzleHttp\Psr7\Request('GET', 'http://test')));

    $result = $this->action->execute('Milano, Italia');

    expect($result)->toBeNull();
});

it('returns null when no features in response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [],
    ])));

    $result = $this->action->execute('NonExistentPlace');

    expect($result)->toBeNull();
});

it('returns address data for valid response', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
                ['id' => 'region.1', 'short_code' => 'IT-MI'],
                ['id' => 'postcode.1', 'text' => '20100'],
            ],
            'place_name' => 'Via Roma 1, Milano, Lombardia 20100, Italia',
            'address' => '1',
            'text' => 'Via Roma',
        ]],
    ])));

    $result = $this->action->execute('Via Roma 1, Milano, Italia');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->country)->toBe('Italia')
        ->and($result->city)->toBe('Milano')
        ->and($result->postal_code)->toBe(20100)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('1')
        ->and($result->state)->toBe('MI');
});

it('handles address without house number', function (): void {
    config(['services.mapbox.access_token' => 'test_key']);

    $this->mockHandler->append(new Response(200, [], json_encode([
        'features' => [[
            'center' => [9.1900, 45.4642],
            'context' => [
                ['id' => 'place.1', 'text' => 'Milano'],
            ],
            'place_name' => 'Via Roma, Milano, Italia',
            'text' => 'Via Roma',
        ]],
    ])));

    $result = $this->action->execute('Via Roma, Milano');

    expect($result)
        ->toBeInstanceOf(AddressData::class)
        ->and($result->street)->toBe('Via Roma')
        ->and($result->street_number)->toBe('');
});
