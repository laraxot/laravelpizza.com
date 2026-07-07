<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\BaseModel;
use Modules\Gdpr\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function makeGdprBaseModel(): BaseModel
{
    return new class extends BaseModel {
        protected $table = 'test_gdpr_table';
    };
}

test('base model extends eloquent model', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has correct table name', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertSame('test_gdpr_table', $baseModel->getTable());
});

test('base model can be instantiated', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
});

test('base model has proper inheritance chain', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertInstanceOf(BaseModel::class, $baseModel);
    Assert::assertInstanceOf(Model::class, $baseModel);
});

test('base model has timestamps enabled', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertTrue($baseModel->usesTimestamps());
});
