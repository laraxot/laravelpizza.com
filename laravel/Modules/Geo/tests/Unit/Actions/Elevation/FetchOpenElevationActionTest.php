<?php

declare(strict_types=1);

use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Response;
use Modules\Geo\Actions\Elevation\FetchOpenElevationAction;
use Modules\Geo\Datas\ElevationData;

beforeEach(function () {
    // @var mixed mockClient = Mockery::mock(Client::class;
    // @var mixed action = new FetchOpenElevationAction($this->mockClient;
});

afterEach(function () {
    Mockery::close();
});

it('fetches elevation successfully', function (): void {
    // Arrange
    $mockResponse = new Response(
        200,
        [],
        json_encode([
            'results' => [
                [
                    'latitude' => 45.4642,
                    'longitude' => 9.1900,
                    'elevation' => 120.5,
                ],
            ],
        ])
    );

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->with(
            'https://api.open-elevation.com/api/v1/lookup',
            Mockery::on(fn ($options) => isset($options['json']['locations']))
        )
        ->andReturn($mockResponse);

    // Act
    $result = // @var mixed action->execute(45.4642, 9.1900;

    // Assert
    expect($result)->toBeInstanceOf(ElevationData::class)
        ->and($result->latitude)->toBe(45.4642)
        ->and($result->longitude)->toBe(9.1900)
        ->and($result->elevation)->toBe(120.5);
});

it('throws exception for failed API request', function (): void {
    // Arrange
    $request = new GuzzleHttp\Psr7\Request('POST', 'https://api.open-elevation.com/api/v1/lookup');
    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->andThrow(GuzzleHttp\Exception\RequestException::create($request, null, new Exception('Connection failed')));

    // Act & Assert
    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'Failed to get elevation data');
});

it('throws exception for invalid response', function (): void {
    // Arrange
    $mockResponse = new Response(
        200,
        [],
        json_encode(['results' => []]) // Empty results
    );

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->andReturn($mockResponse);

    // Act & Assert
    expect(fn () => // @var mixed action->execute(45.4642, 9.1900
        ->toThrow(RuntimeException::class, 'Invalid elevation data response');
});

it('handles negative elevation', function (): void {
    // Arrange - Dead Sea area (below sea level)
    $mockResponse = new Response(
        200,
        [],
        json_encode([
            'results' => [
                [
                    'latitude' => 31.5,
                    'longitude' => 35.5,
                    'elevation' => -430.0,
                ],
            ],
        ])
    );

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->andReturn($mockResponse);

    // Act
    $result = // @var mixed action->execute(31.5, 35.5;

    // Assert
    expect($result->elevation)->toBe(-430.0);
});

it('handles high elevation', function (): void {
    // Arrange - Mount Everest
    $mockResponse = new Response(
        200,
        [],
        json_encode([
            'results' => [
                [
                    'latitude' => 27.9881,
                    'longitude' => 86.9250,
                    'elevation' => 8848.0,
                ],
            ],
        ])
    );

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->andReturn($mockResponse);

    // Act
    $result = // @var mixed action->execute(27.9881, 86.9250;

    // Assert
    expect($result->elevation)->toBe(8848.0);
});

it('handles zero elevation', function (): void {
    // Arrange - Sea level
    $mockResponse = new Response(
        200,
        [],
        json_encode([
            'results' => [
                [
                    'latitude' => 0.0,
                    'longitude' => 0.0,
                    'elevation' => 0.0,
                ],
            ],
        ])
    );

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->andReturn($mockResponse);

    // Act
    $result = // @var mixed action->execute(0.0, 0.0;

    // Assert
    expect($result->elevation)->toBe(0.0);
});

it('sends correct API payload', function (): void {
    // Arrange
    $mockResponse = new Response(
        200,
        [],
        json_encode([
            'results' => [
                ['latitude' => 45.4642, 'longitude' => 9.1900, 'elevation' => 100.0],
            ],
        ])
    );

    $capturedOptions = [];

    // @var mixed mockClient
        ->shouldReceive('post')
        ->once()
        ->with(
            'https://api.open-elevation.com/api/v1/lookup',
            Mockery::on(function ($options) use (&$capturedOptions) {
                $capturedOptions = $options;

                return isset($options['json']['locations']);
            })
        )
        ->andReturn($mockResponse);

    // Act
    // @var mixed action->execute(45.4642, 9.1900;

    // Assert
    expect($capturedOptions['json']['locations'][0]['latitude'])->toBe(45.4642)
        ->and($capturedOptions['json']['locations'][0]['longitude'])->toBe(9.1900);
});
