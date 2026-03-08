<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Gdpr\Models\BaseModel;

beforeEach(function () {
    // @var mixed baseModel = new class extends BaseModel {
        protected $table = 'test_gdpr_table';
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
    expect(// @var mixed baseModel;
});
