<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Modules\Xot\Actions\Cast\SafeArrayByModelCastAction;
use Modules\Xot\Actions\Cast\SafeAttributeCastAction;
use Modules\Xot\Models\XotBaseModel;
use PHPUnit\Framework\Assert;

test('safe array by model cast action works', function () {
    $model = new class extends XotBaseModel {
        protected $attributes = [
            'id' => 1,
            'name' => 'Test',
        ];
    };

    $action = app(SafeArrayByModelCastAction::class);
    $result = $action->execute($model);

    Assert::assertArrayHasKey('id', $result);
    Assert::assertArrayHasKey('name', $result);
    Assert::assertSame('Test', $result['name']);
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

    Assert::assertSame(123, $action->getIntAttribute($model, 'int'));
    Assert::assertSame(12.3, $action->getFloatAttribute($model, 'float'));
    Assert::assertTrue($action->getBooleanAttribute($model, 'bool'));
    Assert::assertSame(['a' => 1], $action->getArrayAttribute($model, 'arr'));
    Assert::assertTrue($action->hasAttribute($model, 'str'));
    Assert::assertTrue(SafeAttributeCastAction::hasNonEmpty($model, 'str'));
    Assert::assertSame('test', SafeAttributeCastAction::getString($model, 'str'));
});
