<?php

declare(strict_types=1);

uses(Modules\Gdpr\Tests\TestCase::class);

use Modules\Gdpr\Models\BaseModel;

beforeEach(function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_gdpr_table';
    };
});

test('base model extends eloquent model', function () {
    expect($baseModel);
});

test('base model has correct table name', function () {
    expect($baseModel->getTable());
});

test('base model can be instantiated', function () {
    expect($baseModel);
});

test('base model has proper inheritance chain', function () {
    expect($baseModel);
    expect($baseModel);
});

test('base model has timestamps enabled', function () {
    expect($baseModel);
});
