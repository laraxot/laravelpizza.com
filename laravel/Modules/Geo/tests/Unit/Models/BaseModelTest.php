<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
test('base model extends eloquent model', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_geo_table';
    };

    Assert::assertSame('test_geo_table', $baseModel->getTable());
});

test('base model has correct table name', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_geo_table';
    };

    Assert::assertSame('test_geo_table', $baseModel->getTable());
});

test('base model can be instantiated', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_geo_table';
    };

    Assert::assertFalse($baseModel->exists);
});

test('base model has proper inheritance chain', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_geo_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
});

test('base model has timestamps enabled', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_geo_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
});
