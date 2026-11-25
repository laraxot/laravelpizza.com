<?php

declare(strict_types=1);
use Modules\Xot\Actions\Cast\SafeEloquentCastAction;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Tests\Fixtures\SafeEloquentCastFixture;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('checks attribute presence and emptiness', function (): void {
    [$action, $model] = SafeEloquentCastFixture::make();

    Assert::assertTrue($action->hasAttribute($model, 'name'));
    Assert::assertFalse($action->hasAttribute($model, 'missing'));
    Assert::assertTrue($action->hasNonEmptyAttribute($model, 'name'));
    Assert::assertFalse($action->hasNonEmptyAttribute($model, 'empty'));
});

it('casts typed attribute getters', function (): void {
    [$action, $model] = SafeEloquentCastFixture::make();

    Assert::assertSame('Mario', $action->getStringAttribute($model, 'name'));
    Assert::assertSame(42, $action->getIntAttribute($model, 'age'));
    Assert::assertSame(12.5, $action->getFloatAttribute($model, 'score'));
    Assert::assertTrue($action->getBooleanAttribute($model, 'active'));
    Assert::assertSame(['k' => 'v'], $action->getArrayAttribute($model, 'meta'));
});

it('returns defaults for missing attributes by type', function (): void {
    [$action, $model] = SafeEloquentCastFixture::make();

    Assert::assertSame('', $action->getStringAttribute($model, 'missing'));
    Assert::assertSame(0, $action->getIntAttribute($model, 'missing'));
    Assert::assertSame(0.0, $action->getFloatAttribute($model, 'missing'));
    Assert::assertFalse($action->getBooleanAttribute($model, 'missing'));
    Assert::assertSame([], $action->getArrayAttribute($model, 'missing'));
});

it('casts generic typed getter and validation helpers', function (): void {
    [$action, $model] = SafeEloquentCastFixture::make();

    Assert::assertSame('Mario', $action->getTypedAttribute($model, 'name', 'string'));
    Assert::assertSame(42, $action->getTypedAttribute($model, 'age', 'int'));

    $ok = $action->getValidatedAttribute($model, 'age', 'int', fn (int $v): bool => $v === 42, 0);
    $ko = $action->getValidatedAttribute($model, 'age', 'int', fn (int $v): bool => $v === 0, 0);

    Assert::assertSame(42, $ok);
    Assert::assertSame(0, $ko);
});

it('checks condition and fallback helpers', function (): void {
    [$action, $model] = SafeEloquentCastFixture::make();
    $model->setAttribute('nickname', 'SuperMario');

    Assert::assertTrue($action->hasAttributeCondition($model, 'age', fn (int $v): bool => SafeStringCastAction::cast($v) === '42'));
    Assert::assertSame('Mario', $action->getAttributeWithFallback($model, 'name', 'missing', 'string'));
    Assert::assertSame('SuperMario', $action->getAttributeWithFallback($model, 'missing', 'nickname', 'string'));
});

it('exposes static helper methods', function (): void {
    [, $model] = SafeEloquentCastFixture::make();

    Assert::assertTrue(SafeEloquentCastAction::has($model, 'name'));
    Assert::assertSame(42, SafeEloquentCastAction::get($model, 'age', 'int'));
});
