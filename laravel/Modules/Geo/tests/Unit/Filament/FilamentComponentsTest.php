<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

uses(Modules\Geo\Tests\TestCase::class);

use Modules\Geo\Filament\Actions\UpdateCoordinatesBulkAction;
use Modules\Geo\Filament\Forms\Components\AddressField;
use Modules\Geo\Filament\Widgets\LatLngWidget;
use Modules\Geo\Filament\Widgets\LocationWidget;

test('AddressField can be instantiated', function () {
    $field = AddressField::make('address');

    expect($field)->toBeObject();
});

test('LocationWidget can be instantiated', function () {
    expect(class_exists(LocationWidget::class))->toBeTrue();
});

test('LatLngWidget can be instantiated', function () {
    expect(class_exists(LatLngWidget::class))->toBeTrue();
});

test('UpdateCoordinatesBulkAction can be instantiated', function () {
    $action = UpdateCoordinatesBulkAction::make('update_coordinates');

    expect($action)->toBeObject();
});
