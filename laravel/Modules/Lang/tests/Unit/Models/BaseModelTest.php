<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Lang\Models\BaseModel;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    // @var mixed baseModel = new class extends BaseModel {
        protected $table = 'test_lang_table';
    };
});

test('base model extends eloquent model', function () {
    expect(// @var mixed baseModel;
});

test('base model has correct table name', function () {
    expect(// @var mixed baseModel->getTable(;
});

test('base model can be instantiated', function () {
    expect(// @var mixed baseModel;
});

test('base model has proper inheritance chain', function () {
    expect(// @var mixed baseModel;
    expect(// @var mixed baseModel;
});

test('base model has timestamps enabled', function () {
    expect(// @var mixed baseModel->usesTimestamps(;
});
