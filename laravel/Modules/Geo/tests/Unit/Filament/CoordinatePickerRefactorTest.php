<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
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
    foreach (array_slice($lines, $start - 1, $end - $start + 1) as $line) {
        $body .= (string) $line;
    }

    Assert::assertNotSame('', $body);

    return $body;
}

test('MapPicker estende XotBaseCoordinateField', function (): void {
    Assert::assertTrue(is_subclass_of(MapPicker::class, XotBaseCoordinateField::class));
});

test('CoordinatePicker estende XotBaseCoordinateField', function (): void {
    Assert::assertTrue(is_subclass_of(CoordinatePicker::class, XotBaseCoordinateField::class));
});

test('LatitudeLongitudeInput estende XotBaseCoordinateField', function (): void {
    Assert::assertTrue(is_subclass_of(LatitudeLongitudeInput::class, XotBaseCoordinateField::class));
});

test('XotBaseCoordinateField::setUpCoordinatePicker non chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(XotBaseCoordinateField::class, 'setUpCoordinatePicker');

    Assert::assertStringNotContainsString('dehydrated', geoReadMethodBody($ref));
});

test('MapPicker::setUp non chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(MapPicker::class, 'setUp');

    Assert::assertStringNotContainsString('dehydrated', geoReadMethodBody($ref));
});

test('CoordinatePicker::setUp non chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(CoordinatePicker::class, 'setUp');

    Assert::assertStringNotContainsString('dehydrated', geoReadMethodBody($ref));
});

test('LatitudeLongitudeInput::setUp non chiama dehydrated', function (): void {
    $ref = new \ReflectionMethod(LatitudeLongitudeInput::class, 'setUp');

    Assert::assertStringNotContainsString('dehydrated', geoReadMethodBody($ref));
});
