<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Actions\Cast;

use Modules\Activity\Models\Activity;
use Modules\Xot\Actions\Cast\SafeAttributeCastAction;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Safe Attribute Cast Action', function (): void {
    test('manages eloquent attributes safely', function (): void {
        $model = $this->createUnitMock(Activity::class);
        $model->method('getAttribute')->willReturnMap([
            ['name', 'Test User'],
            ['email', ''],
            ['id', 123],
            ['active', 1],
            ['missing', null],
        ]);

        $action = app(SafeAttributeCastAction::class);

        Assert::assertTrue($action->hasAttribute($model, 'name'));
        Assert::assertFalse($action->hasAttribute($model, 'missing'));
        Assert::assertTrue($action->hasNonEmptyAttribute($model, 'name'));
        Assert::assertFalse($action->hasNonEmptyAttribute($model, 'email'));
        Assert::assertSame('Test User', $action->getStringAttribute($model, 'name'));
        Assert::assertSame(123, $action->getIntAttribute($model, 'id'));
        Assert::assertTrue($action->getBooleanAttribute($model, 'active'));
        Assert::assertTrue($action->hasAttributeValue($model, 'id', 123));
    });
});
