<?php

declare(strict_types=1);

use Modules\Xot\Actions\Cast\SafeObjectCastAction;
use PHPUnit\Framework\Assert;

uses(Modules\Xot\Tests\TestCase::class);

it('manages object properties safely', function (): void {
    $obj = new stdClass();
    $obj->name = 'Test Object';
    $obj->id = 123;
    $obj->active = true;
    $obj->price = 10.5;
    $obj->tags = ['a', 'b'];
    $obj->emptyStr = '';
    $obj->nullVal = null;

    $action = app(SafeObjectCastAction::class);

    // hasProperty
    Assert::assertTrue($action->hasProperty($obj, 'name'));
    Assert::assertFalse($action->hasProperty($obj, 'missing'));
    // hasNonNullProperty
    Assert::assertTrue($action->hasNonNullProperty($obj, 'name'));
    Assert::assertFalse($action->hasNonNullProperty($obj, 'nullVal'));
    // hasNonEmptyProperty
    Assert::assertTrue($action->hasNonEmptyProperty($obj, 'name'));
    Assert::assertFalse($action->hasNonEmptyProperty($obj, 'emptyStr'));
    // getStringProperty
    Assert::assertSame('Test Object', $action->getStringProperty($obj, 'name'));
    Assert::assertSame('fallback', $action->getStringProperty($obj, 'missing', 'fallback'));
    // getIntProperty
    Assert::assertSame(123, $action->getIntProperty($obj, 'id'));
    // getFloatProperty
    Assert::assertSame(10.5, $action->getFloatProperty($obj, 'price'));
    // getBooleanProperty
    Assert::assertTrue($action->getBooleanProperty($obj, 'active'));
    // getArrayProperty
    Assert::assertSame(['a', 'b'], $action->getArrayProperty($obj, 'tags'));
    // getTypedProperty
    Assert::assertSame('Test Object', $action->getTypedProperty($obj, 'name', 'string'));
    Assert::assertSame(123, $action->getTypedProperty($obj, 'id', 'int'));
    // hasPropertyValue
    Assert::assertTrue($action->hasPropertyValue($obj, 'id', 123));
    Assert::assertFalse($action->hasPropertyValue($obj, 'id', '123'));
    // getValidatedProperty
    Assert::assertSame(123, $action->getValidatedProperty($obj, 'id', 'int', function (mixed $v): bool {
        return $v > 100;
    }));
    Assert::assertSame(0, $action->getValidatedProperty($obj, 'id', 'int', function (mixed $v): bool {
        return $v > 200;
    }, 0));
    // Methods
    $complexObj = new class {
        public function test(mixed $p): mixed
        {
            return $p;
        }

        public function fail(): never
        {
            throw new Exception('fail');
        }
    };

    Assert::assertTrue($action->hasMethod($complexObj, 'test'));
    Assert::assertFalse($action->hasMethod($complexObj, 'missing'));
    Assert::assertSame('hello', $action->callMethodSafely($complexObj, 'test', ['hello']));
    Assert::assertSame('default', $action->callMethodSafely($complexObj, 'missing', [], 'default'));
    Assert::assertSame('error', $action->callMethodSafely($complexObj, 'fail', [], 'error'));
});
