<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeObjectCastAction;

it('manages object properties safely', function (): void {
    $obj = new \stdClass();
    $obj->name = 'Test Object';
    $obj->id = 123;
    $obj->active = true;
    $obj->price = 10.5;
    $obj->tags = ['a', 'b'];
    $obj->emptyStr = '';
    $obj->nullVal = null;

    $action = app(SafeObjectCastAction::class);

    // hasProperty
    expect($action->hasProperty($obj, 'name'))->toBeTrue();
    expect($action->hasProperty($obj, 'missing'))->toBeFalse();

    // hasNonNullProperty
    expect($action->hasNonNullProperty($obj, 'name'))->toBeTrue();
    expect($action->hasNonNullProperty($obj, 'nullVal'))->toBeFalse();

    // hasNonEmptyProperty
    expect($action->hasNonEmptyProperty($obj, 'name'))->toBeTrue();
    expect($action->hasNonEmptyProperty($obj, 'emptyStr'))->toBeFalse();

    // getStringProperty
    expect($action->getStringProperty($obj, 'name'))->toBe('Test Object');
    expect($action->getStringProperty($obj, 'missing', 'fallback'))->toBe('fallback');

    // getIntProperty
    expect($action->getIntProperty($obj, 'id'))->toBe(123);

    // getFloatProperty
    expect($action->getFloatProperty($obj, 'price'))->toBe(10.5);

    // getBooleanProperty
    expect($action->getBooleanProperty($obj, 'active'))->toBeTrue();

    // getArrayProperty
    expect($action->getArrayProperty($obj, 'tags'))->toBe(['a', 'b']);

    // getTypedProperty
    expect($action->getTypedProperty($obj, 'name', 'string'))->toBe('Test Object');
    expect($action->getTypedProperty($obj, 'id', 'int'))->toBe(123);

    // hasPropertyValue
    expect($action->hasPropertyValue($obj, 'id', 123))->toBeTrue();
    expect($action->hasPropertyValue($obj, 'id', '123'))->toBeFalse();

    // getValidatedProperty
    expect($action->getValidatedProperty($obj, 'id', 'int', fn ($v) => $v > 100))->toBe(123);
    expect($action->getValidatedProperty($obj, 'id', 'int', fn ($v) => $v > 200, 0))->toBe(0);

    // Methods
    $complexObj = new class {
        public function test($p)
        {
            return $p;
        }

        public function fail()
        {
            throw new \Exception('fail');
        }
    };

    expect($action->hasMethod($complexObj, 'test'))->toBeTrue();
    expect($action->hasMethod($complexObj, 'missing'))->toBeFalse();

    expect($action->callMethodSafely($complexObj, 'test', ['hello']))->toBe('hello');
    expect($action->callMethodSafely($complexObj, 'missing', [], 'default'))->toBe('default');
    expect($action->callMethodSafely($complexObj, 'fail', [], 'error'))->toBe('error');
});
