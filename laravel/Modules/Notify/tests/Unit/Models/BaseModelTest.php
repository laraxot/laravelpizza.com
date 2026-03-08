<?php

declare(strict_types=1);

namespace Modules\Notify\Tests\Unit\Models;

use Modules\Notify\Models\BaseModel;
use Modules\Notify\Tests\TestCase;

uses(TestCase::class);

test('base model is abstract and uses notify connection', function () {
    $reflection = new \ReflectionClass(BaseModel::class);

    expect($reflection->isAbstract())->toBeTrue();

    $connection = $reflection->getProperty('connection');
    $connection->setAccessible(true);

    expect($connection->getDefaultValue())->toBe('notify');
});

test('base model default casts include audit and datetime fields', function () {
    $model = new class extends BaseModel
    {
        protected $table = 'notify_base_model_test';

        public function exposeCasts(): array
        {
            return // @var mixed casts(;
        }
    };

    $casts = $model->exposeCasts();

    expect($casts)->toHaveKey('id')
        ->and($casts)->toHaveKey('uuid')
        ->and($casts)->toHaveKey('created_at')
        ->and($casts)->toHaveKey('updated_at')
        ->and($casts)->toHaveKey('deleted_at')
        ->and($casts)->toHaveKey('created_by')
        ->and($casts)->toHaveKey('updated_by')
        ->and($casts)->toHaveKey('deleted_by');
});
