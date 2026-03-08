<?php

declare(strict_types=1);

use Modules\Geo\Actions\FormatCoordinatesAction;

beforeEach(function () {
    $action = new FormatCoordinatesAction();
});

it('formats coordinates in decimal format', function (): void {
    $result = $action->execute(45.4642, 9.1900, 'decimal');
    expect($result)->toBe('45.464200, 9.190000');

    $result = $action->execute(-45.4642, -9.1900, 'decimal');
    expect($result)->toBe('-45.464200, -9.190000');

    $result = $action->execute(0, 0, 'decimal');
    expect($result)->toBe('0.000000, 0.000000');
});

it('formats coordinates in DMS format', function (): void {
    $result = $action->execute(45.4642, 9.1900, 'dms');
    expect($result)->toBe('45°27\'51"N 9°11\'24"E');

    $result = $action->execute(-45.4642, -9.1900, 'dms');
    expect($result)->toBe('45°27\'51"S 9°11\'24"W');

    $result = $action->execute(0, 0, 'dms');
    expect($result)->toBe('0°0\'0"N 0°0\'0"E');
});

it('formats coordinates in Google Maps URL format', function (): void {
    $result = $action->execute(45.4642, 9.1900, 'google');
    expect($result)->toBe('https://www.google.com/maps?q=45.4642,9.19');

    $result = $action->execute(-45.4642, -9.1900, 'google');
    expect($result)->toBe('https://www.google.com/maps?q=-45.4642,-9.19');

    $result = $action->execute(0, 0, 'google');
    expect($result)->toBe('https://www.google.com/maps?q=0,0');
});

it('uses decimal format as default', function (): void {
    $result = $action->execute(45.4642, 9.1900);
    expect($result)->toBe('45.464200, 9.190000');
});

it('throws exception for unsupported format', function (): void {
    expect(fn () => $action->execute(45.4642, 9.1900, 'invalid'));
});

it('handles edge case coordinates', function (): void {
    // Test extreme valid coordinates
    $result = $action->execute(90, 180, 'decimal');
    expect($result)->toBe('90.000000, 180.000000');

    $result = $action->execute(-90, -180, 'decimal');
    expect($result)->toBe('-90.000000, -180.000000');

    // Test DMS for extreme coordinates
    $result = $action->execute(90, 180, 'dms');
    expect($result)->toBe('90°0\'0"N 180°0\'0"E');

    $result = $action->execute(-90, -180, 'dms');
    expect($result)->toBe('90°0\'0"S 180°0\'0"W');
});

it('handles high precision coordinates', function (): void {
    $result = $action->execute(45.123456, 9.654321, 'decimal');
    expect($result)->toBe('45.123456, 9.654321');

    $result = $action->execute(45.123456, 9.654321, 'dms');
    expect($result)->toBe('45°7\'24"N 9°39\'16"E');
});
