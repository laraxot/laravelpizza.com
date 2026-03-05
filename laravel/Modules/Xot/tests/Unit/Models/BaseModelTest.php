<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\BaseModel;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

if (! class_exists(TestConcreteBaseModel::class)) {
    class TestConcreteBaseModel extends BaseModel
    {
        protected $table = 'test_table';
    }
}

beforeEach(function () {
    $this->baseModel = new TestConcreteBaseModel();
});

test('base model extends eloquent model', function () {
    expect($this->baseModel)->toBeInstanceOf(Model::class);
});

test('base model has correct table name', function () {
    expect($this->baseModel->getTable())->toBe('test_table');
});

test('base model has timestamps enabled', function () {
    expect($this->baseModel->timestamps)->toBeTrue();
});

test('base model can be instantiated via subclass', function () {
    expect($this->baseModel)->toBeInstanceOf(BaseModel::class);
});
