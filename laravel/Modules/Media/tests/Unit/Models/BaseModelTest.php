<?php

declare(strict_types=1);

namespace Modules\Media\Tests\Unit\Models;

use Modules\Media\Models\BaseModel;
use Modules\Media\Tests\TestCase;
use Modules\Xot\Models\XotBaseModel;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

if (! function_exists(__NAMESPACE__.'\\makeMediaTestBaseModel')) {
    function makeMediaTestBaseModel(): BaseModel
    {
        return new class extends BaseModel
        {
            protected $table = 'test_media_table';
        };
    }
}

test('base model has correct table name', function (): void {
    expect(makeMediaTestBaseModel()->getTable())->toBe('test_media_table');
});

test('base model can be instantiated with configured table', function (): void {
    $model = makeMediaTestBaseModel();

    Assert::assertSame('test_media_table', $model->getTable());
    Assert::assertNotSame(BaseModel::class, $model::class);
});

test('base model has timestamps enabled', function (): void {
    expect(makeMediaTestBaseModel()->usesTimestamps())->toBeTrue();
});
