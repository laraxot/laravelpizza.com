<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $this->baseModel = new class extends BaseModel {
        protected $table = 'test_table';
    };
});

test('base model extends eloquent model', function () {
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_table');
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->usesTimestamps())->toBeTrue();
});

test('base model has soft deletes disabled by default', function () {
    expect($this->baseModel->usesSoftDeletes())->toBeFalse();
});

test('base model can be instantiated', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
});
