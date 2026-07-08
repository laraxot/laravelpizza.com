<?php

declare(strict_types=1);

uses(Modules\Xot\Tests\TestCase::class);
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Traits\Updater;
use PHPUnit\Framework\Assert;

test('xot base model extends eloquent model', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);

    Assert::assertTrue($reflection->isSubclassOf(Model::class));
});

test('xot base model is abstract', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('xot base model uses updater trait', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);
    $traits = $reflection->getTraitNames();

    Assert::assertContains(Updater::class, $traits);
});

test('xot base model has correct snake attributes setting', function (): void {
    Assert::assertTrue(XotBaseModel::$snakeAttributes);
});

test('xot base model has correct per page setting', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);
    $perPageProperty = $reflection->getProperty('perPage');
    $default = $perPageProperty->getDefaultValue();
    Assert::assertSame(30, $default);
});

test('xot base model has correct namespace', function (): void {
    Assert::assertStringContainsString('Modules\Xot\Models', XotBaseModel::class);
});

test('xot base model has correct property types', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);

    $snakeAttributesProperty = $reflection->getProperty('snakeAttributes');
    $perPageProperty = $reflection->getProperty('perPage');

    $snakeType = $snakeAttributesProperty->getType();
    $perPageType = $perPageProperty->getType();

    if (null !== $snakeType) {
        Assert::assertInstanceOf(ReflectionNamedType::class, $snakeType);
        Assert::assertSame('bool', $snakeType->getName());
    } else {
        Assert::assertTrue(XotBaseModel::$snakeAttributes);
    }

    if (null !== $perPageType) {
        Assert::assertInstanceOf(ReflectionNamedType::class, $perPageType);
        Assert::assertSame('int', $perPageType->getName());
    } else {
        Assert::assertSame(30, $perPageProperty->getDefaultValue());
    }
});

test('xot base model has correct property visibility', function (): void {
    $reflection = new ReflectionClass(XotBaseModel::class);

    $snakeAttributesProperty = $reflection->getProperty('snakeAttributes');
    $perPageProperty = $reflection->getProperty('perPage');

    Assert::assertTrue($snakeAttributesProperty->isPublic());
    Assert::assertTrue($perPageProperty->isProtected());
});
