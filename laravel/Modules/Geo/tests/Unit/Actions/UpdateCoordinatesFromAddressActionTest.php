<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Collection as SupportCollection;
use Mockery;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\LightTestCase;

// Uses LightTestCase (no real DB connection): Address instances are Mockery partial
// mocks so `update()` never touches the database, only the in-memory attributes.
uses(LightTestCase::class);

it('updates model coordinates when geocoding succeeds', function (): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->route = 'Via Dante';
    $address->street_number = '10';
    $address->locality = 'Milano';
    $address->latitude = null;
    $address->longitude = null;
    $address->shouldReceive('update')->once()->with(['latitude' => 41.1111, 'longitude' => 12.2222])
        ->andReturnUsing(function (array $attributes) use ($address): bool {
            foreach ($attributes as $key => $value) {
                $address->{$key} = $value;
            }

            return true;
        });

    $addressData = new AddressData(latitude: 41.1111, longitude: 12.2222);

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn($addressData);

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeTrue();
    expect($action->getErrors())->toBeEmpty();
    expect($address->latitude)->toBe(41.1111);
    expect($address->longitude)->toBe(12.2222);
});

it('fails and records errors when geocoding cannot resolve the address', function (): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->route = 'Via Inesistente';
    $address->street_number = '999';
    $address->locality = 'Nowhere';
    $address->shouldNotReceive('update');

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn(null);
    $getAddressDataAction->shouldReceive('getErrors')->once()->andReturn(new SupportCollection(['Nessun risultato trovato']));

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeFalse();
    expect($action->getErrors()->toArray())->toBe(['Nessun risultato trovato']);
});

it('fails fast without calling geocoding when the model has an empty address', function (): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->route = null;
    $address->street_number = null;
    $address->locality = null;
    $address->administrative_area_level_3 = null;
    $address->administrative_area_level_2 = null;
    $address->postal_code = null;
    $address->country = null;
    $address->shouldNotReceive('update');

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldNotReceive('execute');

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeFalse();
    expect($action->getErrors())->not->toBeEmpty();
});
