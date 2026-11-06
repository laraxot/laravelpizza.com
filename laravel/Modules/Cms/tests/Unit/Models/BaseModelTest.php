<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use PHPUnit\Framework\Assert;

function createCmsBaseModelTestDouble(): BaseModel
{
    return new class extends BaseModel
    {
        protected $table = 'test_cms_table';
    };
}

test('base model extends eloquent model', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertFalse($baseModel->exists);
});

test('base model has correct table name', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertSame('test_cms_table', $baseModel->getTable());
});

test('base model can be instantiated', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertSame('test_cms_table', $baseModel->getTable());
});

test('base model has proper inheritance chain', function (): void {
    $baseModel = createCmsBaseModelTestDouble();

    Assert::assertTrue(is_subclass_of($baseModel, BaseModel::class));
});

test('base model has timestamps enabled', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertTrue($baseModel->usesTimestamps());
});
