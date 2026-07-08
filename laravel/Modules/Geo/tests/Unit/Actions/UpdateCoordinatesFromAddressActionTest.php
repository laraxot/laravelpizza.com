<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Support\Collection as SupportCollection;
use Mockery;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\TestCase;

uses(TestCase::class);

it('updates model coordinates when geocoding succeeds', function (): void {
    $address = Address::factory()->create([
        'route' => 'Via Dante',
        'street_number' => '10',
        'locality' => 'Milano',
        'latitude' => null,
        'longitude' => null,
    ]);

    $addressData = new AddressData(latitude: 41.1111, longitude: 12.2222);

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn($addressData);

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeTrue();
    expect($action->getErrors())->toBeEmpty();

    $address->refresh();
    expect((float) $address->latitude)->toBe(41.1111);
    expect((float) $address->longitude)->toBe(12.2222);
});

it('fails and records errors when geocoding cannot resolve the address', function (): void {
    $address = Address::factory()->create([
        'route' => 'Via Inesistente',
        'street_number' => '999',
        'locality' => 'Nowhere',
    ]);

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn(null);
    $getAddressDataAction->shouldReceive('getErrors')->once()->andReturn(new SupportCollection(['Nessun risultato trovato']));

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeFalse();
    expect($action->getErrors()->toArray())->toBe(['Nessun risultato trovato']);
});

it('fails fast without calling geocoding when the model has an empty address', function (): void {
    $address = Address::factory()->make([
        'route' => null,
        'street_number' => null,
        'locality' => null,
        'administrative_area_level_3' => null,
        'administrative_area_level_2' => null,
        'administrative_area_level_1' => null,
        'country' => null,
        'postal_code' => null,
        'formatted_address' => null,
    ]);

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldNotReceive('execute');

    $action = new UpdateCoordinatesFromAddressAction($getAddressDataAction);

    $result = $action->execute($address);

    expect($result)->toBeFalse();
    expect($action->getErrors())->not->toBeEmpty();
});
