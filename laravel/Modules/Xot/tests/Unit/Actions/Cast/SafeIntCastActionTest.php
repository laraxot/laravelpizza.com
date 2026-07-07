<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use PHPUnit\Framework\Assert;

it('casts various values to integer correctly', function (): void {
    $action = app(SafeIntCastAction::class);

    // Integers
    Assert::assertSame(123, $action->execute(123));
    // Floats
    Assert::assertSame(123, $action->execute(123.9));
    Assert::assertSame(5, $action->execute(INF, 5));
    // Null
    Assert::assertSame(10, $action->execute(null, 10));
    // Strings
    Assert::assertSame(123, $action->execute('123'));
    Assert::assertSame(1234, $action->execute('1.234')); // Thousands separator
    Assert::assertSame(123, $action->execute(' +123 '));
    Assert::assertSame(7, $action->execute('invalid', 7));
    Assert::assertSame(0, $action->execute(''));
    // Booleans
    Assert::assertSame(1, $action->execute(true));
    Assert::assertSame(0, $action->execute(false));
    // Arrays (single element)
    Assert::assertSame(15, $action->execute(['15']));
    Assert::assertSame(2, $action->execute(['a', 'b'], 2));
    // Objects with toString
    $obj = new class {
        public function __toString()
        {
            return '20';
        }
    };
    Assert::assertSame(20, $action->execute($obj));
});

it('clams integer within range correctly', function (): void {
    $action = app(SafeIntCastAction::class);

    Assert::assertSame(50, $action->executeWithRange(50, 0, 100));
    Assert::assertSame(0, $action->executeWithRange(-10, 0, 100));
    Assert::assertSame(100, $action->executeWithRange(150, 0, 100));
});

it('casts as id correctly', function (): void {
    $action = app(SafeIntCastAction::class);

    Assert::assertSame(10, $action->executeAsId(10));
    Assert::assertSame(1, $action->executeAsId(0));
    Assert::assertSame(1, $action->executeAsId(-5));
});

it('uses static int cast methods correctly', function (): void {
    Assert::assertSame(99, SafeIntCastAction::cast('99'));
    Assert::assertSame(50, SafeIntCastAction::castWithRange(200, 0, 50));
    Assert::assertSame(1, SafeIntCastAction::castAsId(0));
});
