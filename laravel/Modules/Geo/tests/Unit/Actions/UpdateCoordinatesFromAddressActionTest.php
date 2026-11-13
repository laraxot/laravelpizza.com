<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Illuminate\Database\Eloquent\Model;
use Mockery;
use Mockery\MockInterface;
use Modules\Geo\Actions\GetAddressDataFromFullAddressAction;
use Modules\Geo\Actions\UpdateCoordinatesFromAddressAction;
use Modules\Geo\Datas\Geocoding\AddressData;
use Modules\Geo\Tests\UnitTestCase;

uses(UnitTestCase::class);

/**
 * @return Model&MockInterface
 */
function makeGeocodeTargetModel(?string $fullAddress): Model
{
    /** @var Model&MockInterface $model */
    $model = Mockery::mock(Model::class);
    geo_mockery_expect($model->shouldReceive('getAttribute'))
        ->with('full_address')
        ->andReturn($fullAddress);

    return $model;
}

it('fails with a readable error when the model has no address', function () {
    $this->app->instance(
        GetAddressDataFromFullAddressAction::class,
        Mockery::mock(GetAddressDataFromFullAddressAction::class),
    );

    $action = app(UpdateCoordinatesFromAddressAction::class);

    expect($action->execute(makeGeocodeTargetModel(null)))->toBeFalse()
        ->and($action->getErrors())->not->toBeEmpty();
});

it('propagates geocoding provider errors instead of swallowing them', function () {
    $geocoding = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    geo_mockery_expect($geocoding->shouldReceive('execute'))->once()->andReturn(null);
    geo_mockery_expect($geocoding->shouldReceive('getErrors'))
        ->andReturn(collect(['Google Maps API key non configurata', 'Nominatim timeout']));

    $this->app->instance(GetAddressDataFromFullAddressAction::class, $geocoding);

    $action = app(UpdateCoordinatesFromAddressAction::class);
    $model = makeGeocodeTargetModel('Via Roma 1, 20100 Milano');

    expect($action->execute($model))->toBeFalse()
        ->and($action->getErrors()->all())->toBe([
            'Google Maps API key non configurata',
            'Nominatim timeout',
        ]);
});

it('updates latitude and longitude when geocoding succeeds', function () {
    $geocoding = Mockery::mock(GetAddressDataFromFullAddressAction::class);
    geo_mockery_expect($geocoding->shouldReceive('execute'))->once()->andReturn(
        new AddressData(latitude: 45.4642, longitude: 9.19, city: 'Milano'),
    );

    $this->app->instance(GetAddressDataFromFullAddressAction::class, $geocoding);

    $model = makeGeocodeTargetModel('Via Roma 1, 20100 Milano');
    geo_mockery_expect($model->shouldReceive('update'))
        ->once()
        ->with(['latitude' => 45.4642, 'longitude' => 9.19])
        ->andReturnTrue();

    $action = app(UpdateCoordinatesFromAddressAction::class);

    expect($action->execute($model))->toBeTrue()
        ->and($action->getErrors())->toBeEmpty();
});
