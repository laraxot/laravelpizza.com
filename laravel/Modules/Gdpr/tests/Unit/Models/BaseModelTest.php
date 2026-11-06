<?php

declare(strict_types=1);

namespace Modules\Gdpr\Tests\Unit\Models;

use Modules\Gdpr\Models\BaseModel;
use PHPUnit\Framework\Assert;

function makeGdprBaseModel(): BaseModel
{
    return new class extends BaseModel
    {
        protected $table = 'test_gdpr_table';
    };
}

test('base model has correct table name', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertSame('test_gdpr_table', $baseModel->getTable());
});

test('base model has timestamps enabled', function (): void {
    $baseModel = makeGdprBaseModel();
    Assert::assertTrue($baseModel->usesTimestamps());
});
