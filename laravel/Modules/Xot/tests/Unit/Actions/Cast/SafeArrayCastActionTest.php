<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Support\Collection;
use Modules\Xot\Actions\Cast\SafeArrayCastAction;
use PHPUnit\Framework\Assert;

use function Safe\fopen;

it('casts various values to array correctly', function (): void {
    $action = app(SafeArrayCastAction::class);

    // Already array
    Assert::assertSame(['a' => 1], $action->execute(['a' => 1]));
    // Null
    Assert::assertSame(['default'], $action->execute(null, ['default']));
    // Collection
    Assert::assertSame(['b' => 2], $action->execute(collect(['b' => 2])));
    // stdClass
    $obj = new stdClass();
    $obj->c = 3;
    Assert::assertSame(['c' => 3], $action->execute($obj));
    // Object with toArray
    $objToArray = new class {
        /** @return array<string, int> */
        public function toArray(): array
        {
            return ['d' => 4];
        }
    };
    Assert::assertSame(['d' => 4], $action->execute($objToArray));
    // Object with __toArray
    $objUnderscoreToArray = new class {
        /** @return array<string, int> */
        public function __toArray(): array
        {
            return ['e' => 5];
        }
    };
    Assert::assertSame(['e' => 5], $action->execute($objUnderscoreToArray));
    // Regular object (public properties)
    $regObj = new class {
        public int $f = 6;
    };
    Assert::assertSame(['f' => 6], $action->execute($regObj));
    // Scalar
    Assert::assertSame(['test'], $action->execute('test'));
    Assert::assertSame([123], $action->execute(123));
    // Fallback
    Assert::assertSame(['fallback'], $action->execute(fopen('php://memory', 'r'), ['fallback']));
});

it('validates required keys correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['a' => 1, 'b' => 2];

    Assert::assertSame($data, $action->executeWithKeys($data, ['a', 'b']));
    Assert::assertSame(['error' => true], $action->executeWithKeys($data, ['a', 'c'], ['error' => true]));
});

it('filters keys correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['a' => 1, 'b' => 2, 'c' => 3];

    Assert::assertSame(['a' => 1, 'c' => 3], $action->executeWithFilter($data, ['a', 'c']));
});

it('casts values to specific type correctly', function (): void {
    $action = app(SafeArrayCastAction::class);
    $data = ['1', '2', '3'];

    Assert::assertSame([1, 2, 3], $action->executeWithValueType($data, 'int'));
    Assert::assertSame([true, false, true], $action->executeWithValueType([1, 0, true], 'bool'));
    Assert::assertSame(['1.1', '2.2'], $action->executeWithValueType([1.1, 2.2], 'string'));
    Assert::assertSame([1.1, 2.2], $action->executeWithValueType(['1.1', '2.2'], 'float'));
    Assert::assertSame(['a', 'b'], $action->executeWithValueType(['a', 'b'], 'invalid'));
});

it('checks if value can be cast', function (): void {
    $action = app(SafeArrayCastAction::class);
    Assert::assertTrue($action->canCast([]));
    Assert::assertTrue($action->canCast(null));
    Assert::assertTrue($action->canCast('str'));
    Assert::assertTrue($action->canCast(new stdClass()));
});

it('uses static cast method correctly', function (): void {
    Assert::assertSame(['foo' => 'bar'], SafeArrayCastAction::cast(['foo' => 'bar']));
    Assert::assertSame(['a' => 1], SafeArrayCastAction::castWithKeys(['a' => 1], ['a']));
    Assert::assertSame(['a' => 1], SafeArrayCastAction::castWithFilter(['a' => 1, 'b' => 2], ['a']));
    Assert::assertSame([1], SafeArrayCastAction::castWithValueType(['1'], 'int'));
});
