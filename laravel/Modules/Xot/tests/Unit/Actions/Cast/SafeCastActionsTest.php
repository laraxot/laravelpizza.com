<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use Modules\Xot\Actions\Cast\SafeBooleanCastAction;
use Modules\Xot\Actions\Cast\SafeIntCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

test('safe array cast action works', function (): void {
    $action = app(SafeArrayCastAction::class);

    Assert::assertSame(['a' => 1], $action->execute(['a' => 1]));
    Assert::assertSame(['def'], $action->execute(null, ['def']));
    Assert::assertSame(['b' => 2], $action->execute(collect(['b' => 2])));
    Assert::assertSame(['c' => 3], $action->execute((object) ['c' => 3]));
    Assert::assertSame(['scalar'], $action->execute('scalar'));
    Assert::assertSame(['d' => 4], $action->execute(new class {
        public int $d = 4;
    }));
    Assert::assertSame(['e' => 5], $action->execute(new class {
        /** @return array<string, int> */
        public function toArray(): array
        {
            return ['e' => 5];
        }
    }));
    Assert::assertSame(['f' => 6], $action->execute(new class {
        /** @return array<string, int> */
        public function __toArray(): array
        {
            return ['f' => 6];
        }
    }));

    Assert::assertSame(['def'], $action->executeWithKeys(['a' => 1], ['a', 'b'], ['def']));
    Assert::assertSame(['a' => 1, 'b' => 2], $action->executeWithKeys(['a' => 1, 'b' => 2], ['a', 'b']));
    Assert::assertSame(['a' => 1, 'c' => 3], $action->executeWithFilter(['a' => 1, 'b' => 2, 'c' => 3], ['a', 'c']));
    Assert::assertSame([true, false], $action->executeWithValueType([1, 0], 'bool'));
    Assert::assertSame(['1.1', '2.2'], $action->executeWithValueType([1.1, 2.2], 'string'));
    Assert::assertSame([1, 2], $action->executeWithValueType(['1', '2'], 'int'));
    Assert::assertTrue($action->canCast([]));
    Assert::assertSame([], SafeArrayCastAction::cast(null));
});

test('safe string cast action works', function (): void {
    $action = app(SafeStringCastAction::class);

    Assert::assertSame('test', $action->execute('test'));
    Assert::assertSame('', $action->execute(null));
    Assert::assertSame('1', $action->execute(true));
    Assert::assertSame('0', $action->execute(false));
    Assert::assertSame('123', $action->execute(123));
    Assert::assertSame('', $action->execute([]));
    Assert::assertSame('456', SafeStringCastAction::cast(456));
});

test('safe int cast action works', function (): void {
    $action = app(SafeIntCastAction::class);

    Assert::assertSame(123, $action->execute(123));
    Assert::assertSame(123, $action->execute(123.9));
    Assert::assertSame(5, $action->execute(null, 5));
    Assert::assertSame(123456, $action->execute('1.234,56'));
    Assert::assertSame(123, $action->execute(' +123 '));
    Assert::assertSame(1, $action->execute(true));
    Assert::assertSame(789, $action->execute(['789']));
    Assert::assertSame(1011, $action->execute(new class {
        public function __toString(): string
        {
            return '1011';
        }
    }));
    Assert::assertSame(0, $action->execute('invalid'));

    Assert::assertSame(100, $action->executeWithRange(150, 0, 100));
    Assert::assertSame(0, $action->executeWithRange(-50, 0, 100));
    Assert::assertSame(50, $action->executeWithRange(50, 0, 100));
    Assert::assertSame(10, $action->executeAsId(10));
    Assert::assertSame(0, $action->executeAsId(0));
    Assert::assertSame(99, SafeIntCastAction::cast('99'));
});

test('safe boolean cast action works', function (): void {
    $action = app(SafeBooleanCastAction::class);

    Assert::assertTrue($action->execute(true));
    Assert::assertTrue($action->execute(null, true));
    Assert::assertTrue($action->execute(1));
    Assert::assertFalse($action->execute(0));
    Assert::assertTrue($action->execute(1.1));
    Assert::assertFalse($action->execute(0.0));
    Assert::assertTrue($action->execute('yes'));
    Assert::assertFalse($action->execute('no'));
    Assert::assertTrue($action->execute(['a']));
    Assert::assertFalse($action->execute([]));
    Assert::assertTrue($action->execute((object) ['a' => 1]));
    Assert::assertFalse($action->execute((object) []));
    Assert::assertTrue($action->executeWithCustomValues('Y', ['y'], ['n']));
    Assert::assertFalse($action->executeWithCustomValues('N', ['y'], ['n']));
    Assert::assertTrue($action->executeWithThreshold(10, 5));
    Assert::assertFalse($action->executeWithThreshold(3, 5));
    Assert::assertTrue($action->canCast(true));
    Assert::assertTrue(SafeBooleanCastAction::cast('on'));
});
