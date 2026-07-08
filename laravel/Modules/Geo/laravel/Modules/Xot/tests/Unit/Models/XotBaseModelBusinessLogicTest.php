<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('XotBaseModel Business Logic', function (): void {
    test('xot base model extends eloquent model', function (): void {
        $reflection = new ReflectionClass(XotBaseModel::class);

        Assert::assertTrue($reflection->isSubclassOf(Model::class));
    });

    test('xot base model cannot be instantiated directly', function (): void {
        $reflection = new ReflectionClass(XotBaseModel::class);

        Assert::assertFalse($reflection->isInstantiable());
        Assert::assertTrue($reflection->isSubclassOf(Model::class));
    });

    test('xot base model provides foundation for other models', function (): void {
        Assert::assertTrue(class_exists(XotBaseModel::class));
    });
});
