<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeFloatCastAction;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

it('casts various values to float correctly', function (): void {
    $action = app(SafeFloatCastAction::class);

    // Floats
    expect($action->execute(1.23))->toBe(1.23);
    expect($action->execute(INF, 0.0))->toBe(0.0);

    // Integers
    expect($action->execute(123))->toBe(123.0);

    // Null
    expect($action->execute(null, 1.1))->toBe(1.1);

    // Strings
    expect($action->execute('1.23'))->toBe(1.23);
    expect($action->execute('1,23'))->toBe(1.23);
    expect($action->execute('1.23e2'))->toBe(123.0);
    expect($action->execute('invalid', 5.5))->toBe(5.5);
    expect($action->execute(''))->toBe(0.0);

    // Booleans
    expect($action->execute(true))->toBe(1.0);
    expect($action->execute(false))->toBe(0.0);

    // Arrays (single element)
    expect($action->execute(['1.5']))->toBe(1.5);
    expect($action->execute(['a', 'b'], 2.2))->toBe(2.2);

    // Objects with toString
    $obj = new class { public function __toString() { return '10.5'; } };
    expect($action->execute($obj))->toBe(10.5);
});

it('clams float within range correctly', function (): void {
    $action = app(SafeFloatCastAction::class);
    
    expect($action->executeWithRange(50.0, 0.0, 100.0))->toBe(50.0);
    expect($action->executeWithRange(-10.0, 0.0, 100.0))->toBe(0.0);
    expect($action->executeWithRange(150.0, 0.0, 100.0))->toBe(100.0);
});

it('rounds float with precision correctly', function (): void {
    $action = app(SafeFloatCastAction::class);
    
    expect($action->executeWithPrecision(1.23456, 2))->toBe(1.23);
    expect($action->executeWithPrecision(1.235, 2))->toBe(1.24);
    expect($action->executeWithPrecision(1.2, 0))->toBe(1.0);
});

it('casts as percentage correctly', function (): void {
    $action = app(SafeFloatCastAction::class);
    
    expect($action->executeAsPercentage(50.0))->toBe(50.0);
    expect($action->executeAsPercentage(120.0))->toBe(100.0);
    expect($action->executeAsPercentage(-5.0))->toBe(0.0);
});

it('casts as currency correctly', function (): void {
    $action = app(SafeFloatCastAction::class);
    
    expect($action->executeAsCurrency(12.345))->toBe(12.35);
    expect($action->executeAsCurrency(-12.345))->toBe(12.35);
});

it('uses static float cast methods correctly', function (): void {
    expect(SafeFloatCastAction::cast('1.99'))->toBe(1.99);
    expect(SafeFloatCastAction::castWithRange(200, 0, 100))->toBe(100.0);
    expect(SafeFloatCastAction::castWithPrecision(1.234, 2))->toBe(1.23);
    expect(SafeFloatCastAction::castAsPercentage(150))->toBe(100.0);
    expect(SafeFloatCastAction::castAsCurrency(-50.555))->toBe(50.56);
});
