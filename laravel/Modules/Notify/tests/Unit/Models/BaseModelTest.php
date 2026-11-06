<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Models\BaseModel;
use Modules\Notify\Tests\TestCase;
use Modules\Xot\Models\XotBaseModel;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('base model extends eloquent model', function () {
    $parent = (new \ReflectionClass(BaseModel::class))->getParentClass();
    Assert::assertNotFalse($parent);
    Assert::assertSame(XotBaseModel::class, $parent->getName());
});

test('base model has correct table name', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_notify_table';
    };

    Assert::assertSame('test_notify_table', $baseModel->getTable());
});

test('base model can be instantiated', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_notify_table';
    };

    Assert::assertFalse($baseModel->exists);
});

test('base model has proper inheritance chain', function () {
    $parent = (new \ReflectionClass(BaseModel::class))->getParentClass();
    Assert::assertNotFalse($parent);
    Assert::assertSame(XotBaseModel::class, $parent->getName());
});

test('base model has timestamps enabled', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_notify_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
});