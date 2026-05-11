<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Models\XotBaseModel;

test('BaseModel has correct connection', function () {
    $model = new class extends BaseModel
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };
    $reflection = new \ReflectionClass($model);
    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($model))->toBe('activity');
});

test('BaseModel extends XotBaseModel', function () {
    $model = new class extends BaseModel
    {
        protected $table = 'test_models';

        protected $fillable = ['name'];
    };

    expect($model)->toBeInstanceOf(XotBaseModel::class);
});
