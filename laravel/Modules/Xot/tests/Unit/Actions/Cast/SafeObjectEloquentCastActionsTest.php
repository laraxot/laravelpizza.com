<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Modules\Xot\Actions\Cast\SafeObjectCastAction;
use Modules\Xot\Models\XotBaseModel;
use PHPUnit\Framework\Assert;

uses(Modules\Xot\Tests\TestCase::class);

test('safe object cast action works', function (): void {
    $action = app(SafeObjectCastAction::class);
    $obj = new class {
        public string $str = 'test';
        public int $int = 123;
        public float $float = 12.3;
        public bool $bool = true;
        /** @var array<string, int> */
        public array $arr = ['a' => 1];
        public mixed $null_val;
        public string $empty_str = '';

        public function testMethod(mixed $p): mixed
        {
            return $p;
        }
    };

    Assert::assertTrue($action->hasProperty($obj, 'str'));
    Assert::assertFalse($action->hasProperty($obj, 'invalid'));
    Assert::assertTrue($action->hasNonNullProperty($obj, 'str'));
    Assert::assertFalse($action->hasNonNullProperty($obj, 'null_val'));
    Assert::assertTrue($action->hasNonEmptyProperty($obj, 'str'));
    Assert::assertFalse($action->hasNonEmptyProperty($obj, 'empty_str'));
    Assert::assertSame('def', $action->getStringProperty($obj, 'invalid', 'def'));
    Assert::assertSame(123, $action->getIntProperty($obj, 'int'));
    Assert::assertSame(12.3, $action->getFloatProperty($obj, 'float'));
    Assert::assertTrue($action->getBooleanProperty($obj, 'bool'));
    Assert::assertSame(['a' => 1], $action->getArrayProperty($obj, 'arr'));
    Assert::assertSame('test', $action->getStringProperty($obj, 'str'));
    Assert::assertSame(123, $action->getTypedProperty($obj, 'int', 'int'));
    Assert::assertSame('test', $action->getTypedProperty($obj, 'str', 'string'));
    Assert::assertTrue($action->hasPropertyValue($obj, 'str', 'test'));
    Assert::assertFalse($action->hasPropertyValue($obj, 'str', 'wrong'));
    Assert::assertSame(0, $action->getValidatedProperty($obj, 'int', 'int', function (mixed $v): bool {
        return $v > 200;
    }, 0));
    Assert::assertSame(123, $action->getValidatedProperty($obj, 'int', 'int', function (mixed $v): bool {
        return $v > 100;
    }));
    Assert::assertTrue($action->hasMethod($obj, 'testMethod'));
    Assert::assertFalse($action->hasMethod($obj, 'invalid'));
    Assert::assertSame('def', $action->callMethodSafely($obj, 'invalid', [], 'def'));
    Assert::assertSame('hello', $action->callMethodSafely($obj, 'testMethod', ['hello']));
});

test('safe eloquent cast action works', function (): void {
    $action = app(SafeEloquentCastAction::class);
    $model = new class extends XotBaseModel {
        protected $attributes = [
            'str' => 'test',
            'int' => 123,
            'float' => 12.3,
            'bool' => 1,
            'arr' => '{"a":1}',
            'null_val' => null,
        ];

        protected $casts = ['arr' => 'array'];
    };

    Assert::assertTrue($action->hasAttribute($model, 'str'));
    Assert::assertFalse($action->hasAttribute($model, 'invalid'));
    Assert::assertTrue($action->hasNonEmptyAttribute($model, 'str'));
    Assert::assertFalse($action->hasNonEmptyAttribute($model, 'null_val'));
    Assert::assertSame(123, $action->getIntAttribute($model, 'int'));
    Assert::assertSame(12.3, $action->getFloatAttribute($model, 'float'));
    Assert::assertTrue($action->getBooleanAttribute($model, 'bool'));
    Assert::assertSame(['a' => 1], $action->getArrayAttribute($model, 'arr'));
    Assert::assertSame('test', $action->getStringAttribute($model, 'str'));
    Assert::assertSame('test', $action->getTypedAttribute($model, 'str', 'string'));
    Assert::assertTrue($action->hasAttributeValue($model, 'str', 'test'));
    Assert::assertSame(123, $action->getValidatedAttribute($model, 'int', 'int', function (mixed $v): bool {
        return $v > 100;
    }));
    Assert::assertTrue($action->hasAttributeCondition($model, 'int', function (mixed $v): bool {
        return 123 === $v;
    }));
    Assert::assertSame('test', $action->getAttributeWithFallback($model, 'str', 'null_val', 'string'));
    Assert::assertSame('test', $action->getAttributeWithFallback($model, 'null_val', 'str', 'string'));
    Assert::assertSame(123, SafeEloquentCastAction::get($model, 'int', 'int'));
    Assert::assertTrue(SafeEloquentCastAction::has($model, 'str'));
});
