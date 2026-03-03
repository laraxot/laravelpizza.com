<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Exception\ConnectException;
use GuzzleHttp\Exception\GuzzleException;
use GuzzleHttp\Psr7\Request;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Nominatim\LookupPlaceAction;
use Modules\Geo\Datas\LocationData;
use Tests\TestCase;


beforeEach(function (): void {
    $this->mockClient = Mockery::mock(Client::class);
    $this->action = new LookupPlaceAction();

    // Replace the client instance with our mock
    /** @phpstan-ignore-next-line property.notFound */
    $reflection = new ReflectionClass($this->action);
    /** @phpstan-ignore-next-line method.nonObject */
    $property = $reflection->getProperty('client');
    /* @phpstan-ignore-next-line method.nonObject */
    $property->setAccessible(true);
    /* @phpstan-ignore-next-line property.notFound, method.nonObject */
    $property->setValue($this->action, $this->mockClient);
});

test('lookup place action returns location data for valid osm id', function (): void {
    $mockResponse = new Response(200, [], json_encode([
        [
            'lat' => '41.9028',
            'lon' => '12.4964',
            'display_name' => 'Rome, Metropolitan City of Rome Capital, Lazio, Italy',
        ],
    ]));

    /* @phpstan-ignore-next-line property.notFound */
    $this->mockClient
        ->shouldReceive('get')
        ->once()
        ->with('https://nominatim.openstreetmap.org/lookup', [
            'query' => [
                'osm_ids' => 'R123456',
                'format' => 'json',
            ],
            'headers' => [
                'User-Agent' => 'Xot/1.0',
            ],
        ])
        ->andReturn($mockResponse);

    /** @phpstan-ignore-next-line property.notFound */
    $result = $this->action->execute('R123456');

    expect($result)->toBeInstanceOf(LocationData::class)
        ->and($result->latitude)->toBe(41.9028)
        ->and($result->longitude)->toBe(12.4964)
        ->and($result->address)->toBe('Rome, Metropolitan City of Rome Capital, Lazio, Italy');
});

test('lookup place action throws exception for empty results', function (): void {
    $mockResponse = new Response(200, [], json_encode([]));

    /* @phpstan-ignore-next-line property.notFound */
    $this->mockClient
        ->shouldReceive('get')
        ->once()
        ->andReturn($mockResponse);

    /* @phpstan-ignore-next-line property.notFound */
    expect(fn () => $this->action->execute('R999999'))
        ->toThrow(RuntimeException::class, 'No results found for OSM ID: R999999');
});

test('lookup place action handles guzzle exceptions', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->mockClient
        ->shouldReceive('get')
        ->once()
        ->andThrow(new ConnectException('API unavailable', new Request('GET', 'https://nominatim.openstreetmap.org/lookup')));

    /* @phpstan-ignore-next-line property.notFound */
    expect(fn () => $this->action->execute('R123456'))
        ->toThrow(ConnectException::class);
});

test('lookup place action uses correct user agent header', function (): void {
    $mockResponse = new Response(200, [], json_encode([
        ['lat' => '0', 'lon' => '0', 'display_name' => 'Test'],
    ]));

    /* @phpstan-ignore-next-line property.notFound */
    $this->mockClient
        ->shouldReceive('get')
        ->once()
        ->withArgs(function ($url, $options) {
            /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
            return isset($options['headers']['User-Agent'])
                   /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
                   && 'Xot/1.0' === $options['headers']['User-Agent'];
        })
        ->andReturn($mockResponse);

    /** @phpstan-ignore-next-line property.notFound */
    $result = $this->action->execute('R123456');

    expect($result)->toBeInstanceOf(LocationData::class);
});
