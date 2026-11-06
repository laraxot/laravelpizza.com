<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\GeopointPicker;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

/*
 * DCP-146 (W2-GEO): vista di default del territorio, `geo.config.map.default_view` = lat, lng, zoom.
 * E' l'ultimo livello della centratura (dopo punto salvato, centro del campo, fuso orario): mai il mondo intero.
 * Non e' una posizione dell'utente (D19): e' il territorio che l'ente ha configurato.
 */
uses(UnitTestCase::class);

afterEach(function (): void {
    config(['geo.config.map.default_view' => ['lat' => 42.5, 'lng' => 12.5, 'zoom' => 6]]);
});

test('il default di config e la panoramica d Italia, zoom regionale', function (): void {
    $view = config('geo.config.map.default_view');

    Assert::assertIsArray($view);
    Assert::assertEqualsWithDelta(42.5, $view['lat'], 0.01);
    Assert::assertEqualsWithDelta(12.5, $view['lng'], 0.01);
    Assert::assertSame(6, $view['zoom']);
});

test('ogni picker espone la vista di default con tipi certi, anche se l env arriva come stringa', function (): void {
    config(['geo.config.map.default_view' => ['lat' => '43.77', 'lng' => '11.25', 'zoom' => '12']]);

    foreach ([CoordinatePicker::make('l'), MapPicker::make('l'), GeopointPicker::make('l')] as $field) {
        Assert::assertSame(['lat' => 43.77, 'lng' => 11.25, 'zoom' => 12], $field->getMapDefaultView());
    }
});

test('una vista non valida ricade sulla panoramica d Italia: la pagina non si rompe e non si apre il mondo', function (array|string|null $broken): void {
    config(['geo.config.map.default_view' => $broken]);

    $view = CoordinatePicker::make('l')->getMapDefaultView();

    Assert::assertSame(['lat' => 42.5, 'lng' => 12.5, 'zoom' => 6], $view);
})->with([
    'null' => [null],
    'stringa' => ['Firenze'],
    'senza zoom' => [['lat' => 43.0, 'lng' => 11.0]],
    'lat fuori scala' => [['lat' => 143.0, 'lng' => 11.0, 'zoom' => 6]],
    'lng non numerica' => [['lat' => 43.0, 'lng' => 'x', 'zoom' => 6]],
    'zoom mondo' => [['lat' => 43.0, 'lng' => 11.0, 'zoom' => 0]],
    'zoom oltre i tile' => [['lat' => 43.0, 'lng' => 11.0, 'zoom' => 25]],
]);

test('i tre blade del picker passano la vista di default al componente Lit', function (): void {
    foreach (['coordinate-picker', 'map-picker', 'geopoint-picker'] as $view) {
        $blade = file_get_contents(__DIR__."/../../../../../resources/views/filament/forms/components/{$view}.blade.php");

        Assert::assertStringContainsString("default-view='@json(\$field->getMapDefaultView())'", $blade, $view);
    }
});
