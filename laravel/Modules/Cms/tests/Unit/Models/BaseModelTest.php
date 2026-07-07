<?php

declare(strict_types=1);

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\BaseModel;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
/**
 * @return BaseModel&Model
 */
function createCmsBaseModelTestDouble(): BaseModel
{
    return new class extends BaseModel {
        protected $table = 'test_cms_table';
    };
}

test('base model extends eloquent model', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertSame('test_cms_table', $baseModel->getTable());
});

test('base model can be instantiated', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});

test('base model has proper inheritance chain', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function (): void {
    $baseModel = createCmsBaseModelTestDouble();
    Assert::assertTrue($baseModel->usesTimestamps());
});
