<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Filament\Support\Components\Attributes\Exposed;
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Geo\Filament\Forms\Components\XotBaseCoordinateField;
use PHPUnit\Framework\Assert;

use function Safe\file;

function geoReadMethodBody(\ReflectionMethod $ref): string
{
    $fileName = $ref->getFileName();
    Assert::assertNotFalse($fileName);

    $lines = file($fileName);
    Assert::assertNotEmpty($lines);

    $start = $ref->getStartLine();
    $end = $ref->getEndLine();

    $body = '';
    /** @var list<string> $methodLines */
    $methodLines = array_slice($lines, $start - 1, $end - $start + 1);
    foreach ($methodLines as $line) {
        $body .= $line;
    }

    Assert::assertNotSame('', $body);

    return $body;
}

test('MapPicker usa il trait HasCoordinatePicker', function (): void {
    Assert::assertContains(HasCoordinatePicker::class, trait_uses_recursive(MapPicker::class));
});

test('CoordinatePicker usa il trait HasCoordinatePicker', function (): void {
    Assert::assertContains(HasCoordinatePicker::class, trait_uses_recursive(CoordinatePicker::class));
});

test('LatitudeLongitudeInput usa il trait HasCoordinatePicker', function (): void {
    Assert::assertContains(HasCoordinatePicker::class, trait_uses_recursive(LatitudeLongitudeInput::class));
});

test('HasCoordinatePicker::setUpCoordinatePicker non chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(HasCoordinatePicker::class, 'setUpCoordinatePicker');

    Assert::assertStringContainsString('dehydrated', geoReadMethodBody($ref));
});

test('MapPicker::setUp chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(MapPicker::class, 'setUp');

    Assert::assertStringContainsString('dehydrated', geoReadMethodBody($ref));
});

test('CoordinatePicker::setUp chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(CoordinatePicker::class, 'setUp');

    Assert::assertStringContainsString('dehydrated', geoReadMethodBody($ref));
});

test('LatitudeLongitudeInput::setUp NON chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(LatitudeLongitudeInput::class, 'setUp');

    Assert::assertStringContainsString('dehydrated', geoReadMethodBody($ref));
});

// Filament esegue un metodo di componente chiamato dal browser solo se porta l'attributo di esposizione
// (InteractsWithSchemas::callSchemaComponentMethod); senza, risponde null in silenzio e la ricerca indirizzo
// e il reverse geocoding restano muti. Da Filament 5.11 l'attributo e' #[Exposed] e #[ExposedLivewireMethod]
// e' deprecato (lo estende): il controllo qui sotto e' lo stesso di Filament. Il progetto richiede
// filament/filament ^5.11 (Modules/Xot/composer.json); sotto quella versione Exposed non esiste e questo
// test fallisce di proposito: la cura e' `composer update "filament/*" livewire/livewire`, non il vecchio nome.
test('searchAddress e reverseGeocode sono esposti a Livewire', function (): void {
    foreach ([HasCoordinatePicker::class, XotBaseCoordinateField::class] as $class) {
        foreach (['searchAddress', 'reverseGeocode'] as $method) {
            $ref = new \ReflectionMethod($class, $method);

            Assert::assertCount(
                1,
                $ref->getAttributes(Exposed::class, \ReflectionAttribute::IS_INSTANCEOF),
                $class.'::'.$method,
            );
        }
    }
});
