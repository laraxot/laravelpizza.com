<?php

declare(strict_types=1);
use Modules\Job\Models\BaseModel;
use Modules\Job\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('base model extends eloquent model', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_job_table';
    };

    Assert::assertFalse($baseModel->exists);
});

test('base model has correct table name', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_job_table';
    };

    Assert::assertSame('test_job_table', $baseModel->getTable());
});

test('base model can be instantiated', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_job_table';
    };

    Assert::assertFalse($baseModel->exists);
});

test('base model has proper inheritance chain', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_job_table';
    };

    Assert::assertSame(BaseModel::class, get_parent_class($baseModel));
});

test('base model has timestamps enabled', function () {
    $baseModel = new class extends BaseModel
    {
        protected $table = 'test_job_table';
    };

    Assert::assertTrue($baseModel->usesTimestamps());
});
