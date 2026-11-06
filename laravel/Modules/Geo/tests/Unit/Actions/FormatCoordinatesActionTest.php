<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Actions;

use Modules\Geo\Actions\FormatCoordinatesAction;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
it('formats coordinates in decimal format', function (): void {
    $action = new FormatCoordinatesAction();

    $result = $action->execute(45.4642, 9.1900, 'decimal');
    Assert::assertSame('45.464200, 9.190000', $result);

    $result = $action->execute(-45.4642, -9.1900, 'decimal');
    Assert::assertSame('-45.464200, -9.190000', $result);

    $result = $action->execute(0, 0, 'decimal');
    Assert::assertSame('0.000000, 0.000000', $result);
});

it('formats coordinates in DMS format', function (): void {
    $action = new FormatCoordinatesAction();

    $result = $action->execute(45.4642, 9.1900, 'dms');
    Assert::assertSame('45°27\'51"N 9°11\'24"E', $result);

    $result = $action->execute(-45.4642, -9.1900, 'dms');
    Assert::assertSame('45°27\'51"S 9°11\'24"W', $result);

    $result = $action->execute(0, 0, 'dms');
    Assert::assertSame('0°0\'0"N 0°0\'0"E', $result);
});

it('formats coordinates in Google Maps URL format', function (): void {
    $action = new FormatCoordinatesAction();

    $result = $action->execute(45.4642, 9.1900, 'google');
    Assert::assertSame('https://www.google.com/maps?q=45.4642,9.19', $result);

    $result = $action->execute(-45.4642, -9.1900, 'google');
    Assert::assertSame('https://www.google.com/maps?q=-45.4642,-9.19', $result);

    $result = $action->execute(0, 0, 'google');
    Assert::assertSame('https://www.google.com/maps?q=0,0', $result);
});

it('uses decimal format as default', function (): void {
    $action = new FormatCoordinatesAction();

    $result = $action->execute(45.4642, 9.1900);
    Assert::assertSame('45.464200, 9.190000', $result);
});

it('throws exception for unsupported format', function (): void {
    $action = new FormatCoordinatesAction();

    try {
        $action->execute(45.4642, 9.1900, 'unsupported');
        Assert::fail('Expected InvalidArgumentException was not thrown');
    } catch (\InvalidArgumentException $exception) {
        Assert::assertSame('Formato non supportato', $exception->getMessage());
    }
});

it('handles edge case coordinates', function (): void {
    $action = new FormatCoordinatesAction();

    // Test extreme valid coordinates
    $result = $action->execute(90, 180, 'decimal');
    Assert::assertSame('90.000000, 180.000000', $result);

    $result = $action->execute(-90, -180, 'decimal');
    Assert::assertSame('-90.000000, -180.000000', $result);

    // Test DMS for extreme coordinates
    $result = $action->execute(90, 180, 'dms');
    Assert::assertSame('90°0\'0"N 180°0\'0"E', $result);

    $result = $action->execute(-90, -180, 'dms');
    Assert::assertSame('90°0\'0"S 180°0\'0"W', $result);
});

it('handles high precision coordinates', function (): void {
    $action = new FormatCoordinatesAction();

    $result = $action->execute(45.123456, 9.654321, 'decimal');
    Assert::assertSame('45.123456, 9.654321', $result);

    $result = $action->execute(45.123456, 9.654321, 'dms');
    Assert::assertSame('45°7\'24"N 9°39\'16"E', $result);
});
