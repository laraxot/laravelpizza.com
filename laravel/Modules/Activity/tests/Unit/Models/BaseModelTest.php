<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;

uses(TestCase::class);

/**
 * Helper that returns an anonymous BaseModel configured for assertions.
 */
function makeTestActivityModel(): BaseModel
{
    return new class extends BaseModel
    {
        protected $table = 'test_activity_table';
    };
}

test('base model extends eloquent model', function (): void {
    $model = makeTestActivityModel();

    expect($model)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function (): void {
    $model = makeTestActivityModel();

    expect($model->getTable())->toBe('test_activity_table');
});

test('base model can be instantiated', function (): void {
    $model = makeTestActivityModel();

    expect($model)->toBeInstanceOf(BaseModel::class);
});

test('base model has proper inheritance chain', function (): void {
    $model = makeTestActivityModel();

    expect($model)->toBeInstanceOf(BaseModel::class);
    expect($model)->toBeInstanceOf(Model::class);
});

test('base model has timestamps enabled', function (): void {
    $model = makeTestActivityModel();

    expect($model->usesTimestamps())->toBeTrue();
});
