<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Modules\Xot\Actions\Cast\SafeAttributeCastAction;
use Modules\Xot\Models\XotBaseModel;


test('safe array by model cast action works', function () {
    $model = new class extends XotBaseModel {
        protected $attributes = [
            'id' => 1,
            'name' => 'Test',
        ];
    };

    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($model);

    // attributesToArray might return id as string depending on DB driver, but here we manually set it.
    expect($result)->toHaveKey('id')
        ->and($result['name'])->toBe('Test');
});

test('safe attribute cast action works', function () {
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

    $action = app(SafeAttributeCastAction::class);

    expect($action->hasAttribute($model, 'str'))->toBeTrue()
        ->and($action->hasNonEmptyAttribute($model, 'str'))->toBeTrue()
        ->and($action->getStringAttribute($model, 'str'))->toBe('test')
        ->and($action->getIntAttribute($model, 'int'))->toBe(123)
        ->and($action->getFloatAttribute($model, 'float'))->toBe(12.3)
        ->and($action->getBooleanAttribute($model, 'bool'))->toBeTrue()
        ->and($action->getArrayAttribute($model, 'arr'))->toBe(['a' => 1]);

    expect(SafeAttributeCastAction::hasNonEmpty($model, 'str'))->toBeTrue();
    expect(SafeAttributeCastAction::getString($model, 'str'))->toBe('test');
});
