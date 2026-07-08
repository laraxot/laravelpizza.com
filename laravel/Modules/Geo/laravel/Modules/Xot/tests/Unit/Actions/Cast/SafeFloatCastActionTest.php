<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use PHPUnit\Framework\Assert;

it('casts float values', function (): void {
    $result = app(SafeFloatCastAction::class)->execute(123.45);
    Assert::assertSame(123.45, $result);
});

it('casts integer values', function (): void {
    $result = app(SafeFloatCastAction::class)->execute(123);
    Assert::assertSame(123.0, $result);
});

it('casts null values', function (): void {
    $result = app(SafeFloatCastAction::class)->execute(null);
    Assert::assertSame(0.0, $result);
});

it('casts null values with custom default', function (): void {
    $result = app(SafeFloatCastAction::class)->execute(null, 10.0);
    Assert::assertSame(10.0, $result);
});

it('casts numeric strings', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('123.45');
    Assert::assertSame(123.45, $result);
});

it('casts integer strings', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('123');
    Assert::assertSame(123.0, $result);
});

it('casts empty strings', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('');
    Assert::assertSame(0.0, $result);
});

it('casts whitespace strings', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('  123.45  ');
    Assert::assertSame(123.45, $result);
});

it('casts non-numeric strings', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('abc');
    Assert::assertSame(0.0, $result);
});

it('casts non-numeric strings with default', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('abc', 5.0);
    Assert::assertSame(5.0, $result);
});

it('casts boolean values', function (): void {
    $trueResult = app(SafeFloatCastAction::class)->execute(true);
    $falseResult = app(SafeFloatCastAction::class)->execute(false);

    Assert::assertSame(1.0, $trueResult);
    Assert::assertSame(0.0, $falseResult);
});

it('casts arrays', function (): void {
    $result = app(SafeFloatCastAction::class)->execute([1, 2, 3]);
    Assert::assertSame(0.0, $result);
});

it('casts objects', function (): void {
    $result = app(SafeFloatCastAction::class)->execute(new stdClass());
    Assert::assertSame(0.0, $result);
});

it('casts with range validation', function (): void {
    $normal = app(SafeFloatCastAction::class)->executeWithRange(50.0, 0.0, 100.0);
    $aboveMax = app(SafeFloatCastAction::class)->executeWithRange(150.0, 0.0, 100.0);
    $belowMin = app(SafeFloatCastAction::class)->executeWithRange(-10.0, 0.0, 100.0);

    Assert::assertSame(50.0, $normal);
    Assert::assertSame(100.0, $aboveMax);
    Assert::assertSame(0.0, $belowMin);
});

it('casts with range and default', function (): void {
    $result = app(SafeFloatCastAction::class)->executeWithRange('invalid', 0.0, 100.0, 25.0);
    Assert::assertSame(25.0, $result);
});

it('has static cast method', function (): void {
    $result = SafeFloatCastAction::cast('123.45');
    Assert::assertSame(123.45, $result);
});

it('has static cast method with default', function (): void {
    $result = SafeFloatCastAction::cast(null, 10.0);
    Assert::assertSame(10.0, $result);
});

it('has static castWithRange method', function (): void {
    $result = SafeFloatCastAction::castWithRange('150.0', 0.0, 100.0);
    Assert::assertSame(100.0, $result);
});

it('handles infinite values', function (): void {
    $infResult = app(SafeFloatCastAction::class)->execute('INF');
    $nanResult = app(SafeFloatCastAction::class)->execute('NAN');

    Assert::assertSame(0.0, $infResult);
    Assert::assertSame(0.0, $nanResult);
});

it('handles infinite values with default', function (): void {
    $infResult = app(SafeFloatCastAction::class)->execute('INF', 5.0);
    $nanResult = app(SafeFloatCastAction::class)->execute('NAN', 5.0);

    Assert::assertSame(5.0, $infResult);
    Assert::assertSame(5.0, $nanResult);
});

it('casts scientific notation', function (): void {
    $result1 = app(SafeFloatCastAction::class)->execute('1.23e2');
    $result2 = app(SafeFloatCastAction::class)->execute('1.23E-2');

    Assert::assertSame(123.0, $result1);
    Assert::assertSame(0.0123, $result2);
});

it('handles decimal comma', function (): void {
    $result = app(SafeFloatCastAction::class)->execute('123,45');
    Assert::assertSame(123.45, $result);
});
