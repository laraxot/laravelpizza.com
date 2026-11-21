<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\BaseModel;

/**
 * @property BaseModel $baseModel
 */
beforeEach(function () {
    $this->baseModel = new class extends BaseModel
    {
        protected $table = 'test_tenant_table';
    };
});

test('base model extends eloquent model', function () {
    expect(is_a($this->baseModel, Model::class))->toBeTrue();
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_tenant_table');
});

test('base model can be instantiated', function () {
    expect(is_a($this->baseModel, BaseModel::class))->toBeTrue();
});

test('base model has proper inheritance chain', function () {
    expect(is_a($this->baseModel, BaseModel::class))->toBeTrue();
    expect(is_a($this->baseModel, Model::class))->toBeTrue();
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->usesTimestamps())->toBeTrue();
});
