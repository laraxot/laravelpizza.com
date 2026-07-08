<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Lang\Models\BaseModel;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeLangBaseModel(): BaseModel
{
    return new class extends BaseModel {
        protected $table = 'test_lang_table';
    };
}

test('base model extends eloquent model', function (): void {
    $baseModel = makeLangBaseModel();
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function (): void {
    $baseModel = makeLangBaseModel();
    Assert::assertSame('test_lang_table', $baseModel->getTable());
});

test('base model can be instantiated', function (): void {
    $baseModel = makeLangBaseModel();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});

test('base model has proper inheritance chain', function (): void {
    $baseModel = makeLangBaseModel();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function (): void {
    $baseModel = makeLangBaseModel();
    Assert::assertTrue($baseModel->usesTimestamps());
});
