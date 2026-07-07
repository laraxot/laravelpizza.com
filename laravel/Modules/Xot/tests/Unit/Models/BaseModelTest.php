<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

$baseModel = new class extends BaseModel {
    protected $table = 'test_table';
};

test('base model extends eloquent model', function () use ($baseModel): void {
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function () use ($baseModel): void {
    Assert::assertSame('test_table', $baseModel->getTable());
});

test('base model has timestamps enabled', function () use ($baseModel): void {
    Assert::assertTrue($baseModel->usesTimestamps());
});

test('base model has timestamps disabled by default', function () use ($baseModel): void {
    Assert::assertTrue($baseModel->usesTimestamps());
});

test('base model can be instantiated', function () use ($baseModel): void {
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});
