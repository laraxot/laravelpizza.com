<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Unit\Models;

uses(\Modules\Geo\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\BaseModel;

beforeEach(function () {
    $this->baseModel = new class extends BaseModel {
        protected $table = 'test_geo_table';
    };
});

test('base model extends eloquent model', function () {
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_geo_table');
});

test('base model can be instantiated', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
});

test('base model has proper inheritance chain', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->usesTimestamps())->toBeTrue();
});
