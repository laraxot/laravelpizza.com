<?php

declare(strict_types=1);

use Modules\Geo\Filament\Forms\Components\CoordinatePicker;
use Modules\Geo\Filament\Forms\Components\LatitudeLongitudeInput;
use Modules\Geo\Filament\Forms\Components\MapPicker;
use Modules\Geo\Filament\Forms\Components\Traits\HasCoordinatePicker;
use Modules\Xot\Filament\Forms\Components\XotBaseField;

// ── Gerarchia classi ────────────────────────────────────────────────────────

test('LatitudeLongitudeInput estende XotBaseField', function (): void {
    expect(is_subclass_of(LatitudeLongitudeInput::class, XotBaseField::class))->toBeTrue();
});

test('LatitudeLongitudeInput NON estende CoordinatePicker', function (): void {
    expect(is_subclass_of(LatitudeLongitudeInput::class, CoordinatePicker::class))->toBeFalse();
});

test('MapPicker estende XotBaseField', function (): void {
    expect(is_subclass_of(MapPicker::class, XotBaseField::class))->toBeTrue();
});

test('CoordinatePicker estende XotBaseField', function (): void {
    expect(is_subclass_of(CoordinatePicker::class, XotBaseField::class))->toBeTrue();
});

// ── Uso del trait ───────────────────────────────────────────────────────────

test('MapPicker usa il trait HasCoordinatePicker', function (): void {
    $traits = class_uses_recursive(MapPicker::class);
    expect(in_array(HasCoordinatePicker::class, $traits, true))->toBeTrue();
});

test('CoordinatePicker usa il trait HasCoordinatePicker', function (): void {
    $traits = class_uses_recursive(CoordinatePicker::class);
    expect(in_array(HasCoordinatePicker::class, $traits, true))->toBeTrue();
});

test('LatitudeLongitudeInput usa il trait HasCoordinatePicker', function (): void {
    $traits = class_uses_recursive(LatitudeLongitudeInput::class);
    expect(in_array(HasCoordinatePicker::class, $traits, true))->toBeTrue();
});

// ── setUpCoordinatePicker non chiama dehydrated ─────────────────────────────

test('HasCoordinatePicker::setUpCoordinatePicker non chiama dehydrated', function (): void {
    $ref = new ReflectionMethod(HasCoordinatePicker::class, 'setUpCoordinatePicker');
    $file = $ref->getFileName();
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();

    $lines = array_slice(file($file), $start - 1, $end - $start + 1);
    $body = implode('', $lines);

    expect($body)->not->toContain('dehydrated');
});

// ── Alias getLatitude / getLongitude ────────────────────────────────────────

test('HasCoordinatePicker espone getLatitude come alias di getCenterLatitude', function (): void {
    $ref = new ReflectionClass(HasCoordinatePicker::class);

    expect($ref->hasMethod('getLatitude'))->toBeTrue()
        ->and($ref->hasMethod('getLongitude'))->toBeTrue()
        ->and($ref->hasMethod('getCenterLatitude'))->toBeTrue()
        ->and($ref->hasMethod('getCenterLongitude'))->toBeTrue();
});

// ── dehydrated esplicito nelle classi composite ─────────────────────────────

test('MapPicker::setUp chiama dehydrated', function (): void {
    $ref = new ReflectionMethod(MapPicker::class, 'setUp');
    $file = $ref->getFileName();
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();

    $lines = array_slice(file($file), $start - 1, $end - $start + 1);
    $body = implode('', $lines);

    expect($body)->toContain('dehydrated');
});

test('CoordinatePicker::setUp chiama dehydrated', function (): void {
    $ref = new ReflectionMethod(CoordinatePicker::class, 'setUp');
    $file = $ref->getFileName();
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();

    $lines = array_slice(file($file), $start - 1, $end - $start + 1);
    $body = implode('', $lines);

    expect($body)->toContain('dehydrated');
});

test('LatitudeLongitudeInput::setUp NON chiama dehydrated', function (): void {
    $ref = new ReflectionMethod(LatitudeLongitudeInput::class, 'setUp');
    $file = $ref->getFileName();
    $start = $ref->getStartLine();
    $end = $ref->getEndLine();

    $lines = array_slice(file($file), $start - 1, $end - $start + 1);
    $body = implode('', $lines);

    expect($body)->not->toContain('dehydrated');
});
