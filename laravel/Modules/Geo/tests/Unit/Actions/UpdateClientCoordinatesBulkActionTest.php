<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Collection as SupportCollection;
use Illuminate\Support\Facades\DB;
use Mockery;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Actions\UpdateClientCoordinatesBulkAction;
use Modules\Geo\Datas\AddressData;
use Modules\Geo\Models\Address;
use Modules\Geo\Tests\LightTestCase;

// Uses LightTestCase (no real DB connection): Address instances are Mockery partial
// mocks so `update()` never touches the database, only the in-memory attributes.
uses(LightTestCase::class);

beforeEach(function () {
    DB::shouldReceive('transaction')->andReturnUsing(fn (\Closure $callback) => $callback());
});

it('updates coordinates and counts successes when geocoding succeeds', function (): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->full_address = 'Via Roma 1, Milano';
    $address->shouldReceive('update')->once()->with(['latitude' => 45.1234, 'longitude' => 9.5678])
        ->andReturnUsing(function (array $attributes) use ($address): bool {
            foreach ($attributes as $key => $value) {
                $address->{$key} = $value;
            }

            return true;
        });

    $addressData = new AddressData(latitude: 45.1234, longitude: 9.5678);

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn($addressData);
    $getAddressDataAction->shouldReceive('getErrors')->andReturn(new SupportCollection());

    $action = new UpdateClientCoordinatesBulkAction($getAddressDataAction);

    $addresses = new Collection([$address]);

    $result = $action->execute($addresses);

    expect($result['success_count'])->toBe(1);
    expect($result['error_messages'])->toBe([]);
    expect($address->latitude)->toBe(45.1234);
    expect($address->longitude)->toBe(9.5678);
});

it('collects an error message when geocoding fails for an address', function (): void {
    $address = Mockery::mock(Address::class)->makePartial();
    $address->name = 'Sede Centrale';
    $address->full_address = 'Indirizzo Inesistente XYZ';
    $address->shouldNotReceive('update');

    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldReceive('execute')->once()->andReturn(null);
    $getAddressDataAction->shouldReceive('getErrors')->once()->andReturn(new SupportCollection(['Servizio non disponibile']));

    $action = new UpdateClientCoordinatesBulkAction($getAddressDataAction);

    $addresses = new Collection([$address]);

    $result = $action->execute($addresses);

    expect($result['success_count'])->toBe(0);
    expect($result['error_messages'])->toHaveCount(1);
    expect($result['error_messages'][0])->toContain('Sede Centrale');
    expect($result['error_messages'][0])->toContain('Servizio non disponibile');
});

it('returns zero success and no errors for an empty collection', function (): void {
    $getAddressDataAction = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    $getAddressDataAction->shouldNotReceive('execute');

    $action = new UpdateClientCoordinatesBulkAction($getAddressDataAction);

    $result = $action->execute(new Collection());

    expect($result)->toBe(['success_count' => 0, 'error_messages' => []]);
});
