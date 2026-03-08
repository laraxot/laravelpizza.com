<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Modules\Lang\Models\BaseModel;
use Tests\TestCase;

uses(TestCase::class);

beforeEach(function () {
    $baseModel = new class extends BaseModel {
        protected $table = 'test_lang_table';
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
    expect($baseModel->usesTimestamps());
});
