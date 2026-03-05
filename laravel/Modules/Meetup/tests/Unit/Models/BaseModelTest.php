<?php

declare(strict_types=1);

namespace Modules\Meetup\Tests\Unit\Models;

use Modules\Meetup\Models\BaseModel;
use Modules\Meetup\Tests\TestCase;

uses(TestCase::class);

test('base model uses meetup connection', function () {
    $model = new class extends BaseModel {
        protected $table = 'tmp_meetup_models';
    };

    expect($model->getConnectionName())->toBe('meetup');
});

test('base model default casts include audit and uuid fields', function () {
    $model = new class extends BaseModel {
        protected $table = 'tmp_meetup_models';
    };

    $casts = $model->getCasts();

    expect($casts)
        ->toHaveKey('id')
        ->and($casts)->toHaveKey('uuid')
        ->and($casts)->toHaveKey('published_at')
        ->and($casts)->toHaveKey('created_at')
        ->and($casts)->toHaveKey('updated_at')
        ->and($casts)->toHaveKey('deleted_at')
        ->and($casts['id'])->toBe('string')
        ->and($casts['uuid'])->toBe('string');
});
