<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Filament\Forms\Components;

use Filament\Schemas\Schema;
use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Tests\UnitTestCase;
use PHPUnit\Framework\Assert;

use function Safe\file_get_contents;

uses(UnitTestCase::class);

/** Un campo Filament ha un container solo dentro uno Schema: `isDisabled()` lo consulta. */
function geoPickerInSchema(CoordinatePicker $field, bool $disabledSchema = false): CoordinatePicker
{
    $schema = Schema::make()->components([$field]);
    if ($disabledSchema) {
        $schema->disabled();
    }
    $schema->getComponents();

    return $field;
}

test('CoordinatePicker e modificabile di default', function (): void {
    Assert::assertFalse(geoPickerInSchema(CoordinatePicker::make('location'))->isMapReadonly());
});

test('CoordinatePicker readOnly rende la mappa di sola lettura', function (): void {
    Assert::assertTrue(geoPickerInSchema(CoordinatePicker::make('location')->readOnly())->isMapReadonly());
});

test('CoordinatePicker disabled rende la mappa di sola lettura (il Blade ignorava disabled)', function (): void {
    Assert::assertTrue(geoPickerInSchema(CoordinatePicker::make('location')->disabled())->isMapReadonly());
});

test('CoordinatePicker dentro uno schema disabilitato e di sola lettura', function (): void {
    Assert::assertTrue(geoPickerInSchema(CoordinatePicker::make('location'), disabledSchema: true)->isMapReadonly());
});

test('il Blade del picker passa readonly al web component e toglie la ricerca', function (): void {
    $blade = file_get_contents(__DIR__.'/../../../../../resources/views/filament/forms/components/coordinate-picker.blade.php');

    Assert::assertStringContainsString('isMapReadonly()', $blade);
    Assert::assertMatchesRegularExpression('/@if\(\$isReadonly\)\s*readonly\s*@endif/', $blade);
    Assert::assertMatchesRegularExpression('/@if\(\s*!\s*\$isReadonly\s*\)\s*show-search\s*@endif/', $blade);
});

test('contratto JS: il Lit readonly blocca scrittura stato, click, drag, ricerca e geolocalizzazione', function (): void {
    $root = __DIR__.'/../../../../../resources/js/components';
    $events = file_get_contents($root.'/map/events.js');
    $lit = file_get_contents($root.'/coordinate-picker-lit.js');
    $controls = file_get_contents($root.'/map/controls/render-controls.js');

    // Un solo punto di scrittura dello stato: click, drag, ricerca, geolocalizzazione passano da qui.
    Assert::assertMatchesRegularExpression('/function handleMapInteraction\(ctx[^)]*\)\s*\{\s*(?:\/\/[^\n]*\n\s*)?if \(ctx\.readonly\) return;/', $events);
    Assert::assertStringContainsString('draggable: !ctx.readonly', $events);
    Assert::assertStringContainsString('keyboard: !ctx.readonly', $events);
    Assert::assertStringContainsString('if (!ctx.readonly)', $events);
    Assert::assertStringContainsString('readonly:', $lit);
    Assert::assertStringContainsString('ctx.readonly', $controls);
});
