<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Illuminate\Database\Eloquent\Model;
use Modules\Cms\Models\BaseModel;

beforeEach(function (): void {
    // @var mixed baseModel = new class extends BaseModel {
        protected $table = 'test_cms_table';
    };
});

test('base model extends eloquent model', function (): void {
    expect(// @var mixed baseModel;
});

test('base model has correct table name', function (): void {
    expect(// @var mixed baseModel->getTable(;
});

test('base model can be instantiated', function (): void {
    expect(// @var mixed baseModel;
});

test('base model has proper inheritance chain', function (): void {
    expect(// @var mixed baseModel;
    expect(// @var mixed baseModel;
});

test('base model has timestamps enabled', function (): void {
    expect(// @var mixed baseModel->usesTimestamps(;
});
