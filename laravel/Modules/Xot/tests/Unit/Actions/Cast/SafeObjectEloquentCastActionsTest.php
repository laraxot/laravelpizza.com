<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Modules\Xot\Actions\Cast\SafeObjectCastAction;
use Modules\Xot\Models\XotBaseModel;
use Tests\TestCase;

uses(TestCase::class);

test('safe object cast action works', function () {
    $action = app(SafeObjectCastAction::class);
    $obj = new class
    {
        public $str = 'test';

        public $int = 123;

        public $float = 12.3;

        public $bool = true;

        public $arr = ['a' => 1];

        public $null_val;

        public $empty_str = '';

        public function testMethod($p)
        {
            return $p;
        }
    };

    expect($action->hasProperty($obj, 'str'))->toBeTrue()
        ->and($action->hasProperty($obj, 'invalid'))->toBeFalse()
        ->and($action->hasNonNullProperty($obj, 'str'))->toBeTrue()
        ->and($action->hasNonNullProperty($obj, 'null_val'))->toBeFalse()
        ->and($action->hasNonEmptyProperty($obj, 'str'))->toBeTrue()
        ->and($action->hasNonEmptyProperty($obj, 'empty_str'))->toBeFalse();

    expect($action->getStringProperty($obj, 'str'))->toBe('test')
        ->and($action->getStringProperty($obj, 'invalid', 'def'))->toBe('def')
        ->and($action->getIntProperty($obj, 'int'))->toBe(123)
        ->and($action->getFloatProperty($obj, 'float'))->toBe(12.3)
        ->and($action->getBooleanProperty($obj, 'bool'))->toBeTrue()
        ->and($action->getArrayProperty($obj, 'arr'))->toBe(['a' => 1]);

    expect($action->getTypedProperty($obj, 'str', 'string'))->toBe('test')
        ->and($action->getTypedProperty($obj, 'int', 'int'))->toBe(123);

    expect($action->hasPropertyValue($obj, 'str', 'test'))->toBeTrue()
        ->and($action->hasPropertyValue($obj, 'str', 'wrong'))->toBeFalse();

    expect($action->getValidatedProperty($obj, 'int', 'int', fn ($v) => $v > 100))->toBe(123)
        ->and($action->getValidatedProperty($obj, 'int', 'int', fn ($v) => $v > 200, 0))->toBe(0);

    expect($action->hasMethod($obj, 'testMethod'))->toBeTrue()
        ->and($action->hasMethod($obj, 'invalid'))->toBeFalse();

    expect($action->callMethodSafely($obj, 'testMethod', ['hello']))->toBe('hello')
        ->and($action->callMethodSafely($obj, 'invalid', [], 'def'))->toBe('def');
});

test('safe eloquent cast action works', function () {
    $action = app(SafeEloquentCastAction::class);
    $model = new class extends XotBaseModel
    {
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

    expect($action->hasAttribute($model, 'str'))->toBeTrue()
        ->and($action->hasAttribute($model, 'invalid'))->toBeFalse()
        ->and($action->hasNonEmptyAttribute($model, 'str'))->toBeTrue()
        ->and($action->hasNonEmptyAttribute($model, 'null_val'))->toBeFalse();

    expect($action->getStringAttribute($model, 'str'))->toBe('test')
        ->and($action->getIntAttribute($model, 'int'))->toBe(123)
        ->and($action->getFloatAttribute($model, 'float'))->toBe(12.3)
        ->and($action->getBooleanAttribute($model, 'bool'))->toBeTrue()
        ->and($action->getArrayAttribute($model, 'arr'))->toBe(['a' => 1]);

    expect($action->getTypedAttribute($model, 'str', 'string'))->toBe('test');

    expect($action->hasAttributeValue($model, 'str', 'test'))->toBeTrue();

    expect($action->getValidatedAttribute($model, 'int', 'int', fn ($v) => $v > 100))->toBe(123);

    expect($action->hasAttributeCondition($model, 'int', fn ($v) => $v === 123))->toBeTrue();

    expect($action->getAttributeWithFallback($model, 'null_val', 'str', 'string'))->toBe('test')
        ->and($action->getAttributeWithFallback($model, 'str', 'null_val', 'string'))->toBe('test');

    expect(SafeEloquentCastAction::get($model, 'int', 'int'))->toBe(123);
    expect(SafeEloquentCastAction::has($model, 'str'))->toBeTrue();
});
