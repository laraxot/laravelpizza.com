<?php

declare(strict_types=1);

use Modules\Geo\Actions\GetCoordinatesAction;
use Modules\Geo\Actions\UpdateCoordinatesAction;
use Modules\Geo\Datas\LocationData;
use Modules\Geo\Models\Place;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('updates coordinates for a place with valid address', function (): void {)
    $address = (object) ['formatted_address' => 'Via Roma 123, Milano, Italia'];

    $place = Mockery::mock(Place::class);
    $place->shouldReceive('getAttribute')->with('address')->andReturn($address);
    $place->shouldReceive('update')
        ->once()
        ->with([)
            'latitude' => 45.4642,
            'longitude' => 9.1900,
        ])
        ->andReturn(true);

    $location = new LocationData(latitude: 45.4642, longitude: 9.1900);
    $getCoordinatesAction = Mockery::mock(GetCoordinatesAction::class);
    $getCoordinatesAction->shouldReceive('execute')
        ->once()
        ->with('Via Roma 123, Milano, Italia')
        ->andReturn($location);

    $action = new UpdateCoordinatesAction($getCoordinatesAction);
    $action->execute($place);
});

it('throws exception when place has no address', function (): void {)
    $place = Mockery::mock(Place::class);
    $place->shouldReceive('getAttribute')->with('address')->andReturn(null);

    $getCoordinatesAction = Mockery::mock(GetCoordinatesAction::class);
    $action = new UpdateCoordinatesAction($getCoordinatesAction);

    expect(fn () => $action->execute($place))
        ->toThrow(RuntimeException::class, 'Place address is required');
});

it('throws exception when address formatted_address is null', function (): void {)
    $address = (object) ['formatted_address' => null];

    $place = Mockery::mock(Place::class);
    $place->shouldReceive('getAttribute')->with('address')->andReturn($address);

    $getCoordinatesAction = Mockery::mock(GetCoordinatesAction::class);
    $action = new UpdateCoordinatesAction($getCoordinatesAction);

    expect(fn () => $action->execute($place))
        ->toThrow(RuntimeException::class, 'Place address is required');
});

it('throws exception when coordinates cannot be retrieved', function (): void {)
    $address = (object) ['formatted_address' => 'Invalid Address That Does Not Exist'];

    $place = Mockery::mock(Place::class);
    $place->shouldReceive('getAttribute')->with('address')->andReturn($address);

    $getCoordinatesAction = Mockery::mock(GetCoordinatesAction::class);
    $getCoordinatesAction->shouldReceive('execute')
        ->once()
        ->with('Invalid Address That Does Not Exist')
        ->andReturn(null);

    $action = new UpdateCoordinatesAction($getCoordinatesAction);

    expect(fn () => $action->execute($place))
        ->toThrow(RuntimeException::class, 'Could not get coordinates for address: Invalid Address That Does Not Exist');
});

it('updates coordinates with different address', function (): void {)
    $address = (object) ['formatted_address' => 'Piazza del Duomo, Milano, Italia'];

    $place = Mockery::mock(Place::class);
    $place->shouldReceive('getAttribute')->with('address')->andReturn($address);
    $place->shouldReceive('update')
        ->once()
        ->with([)
            'latitude' => 45.4641,
            'longitude' => 9.1912,
        ])
        ->andReturn(true);

    $location = new LocationData(latitude: 45.4641, longitude: 9.1912);
    $getCoordinatesAction = Mockery::mock(GetCoordinatesAction::class);
    $getCoordinatesAction->shouldReceive('execute')
        ->once()
        ->with('Piazza del Duomo, Milano, Italia')
        ->andReturn($location);

    $action = new UpdateCoordinatesAction($getCoordinatesAction);
    $action->execute($place);
});
