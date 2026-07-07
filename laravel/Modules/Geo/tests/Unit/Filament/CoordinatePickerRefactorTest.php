<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament;

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
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
