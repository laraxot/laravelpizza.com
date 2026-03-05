<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;
use Modules\Xot\Tests\TestCase;

uses(TestCase::class);

if (! class_exists(TestConcreteXotBaseModel::class)) {
    class TestConcreteXotBaseModel extends XotBaseModel
    {
        protected $table = 'test_xot_table';
    }
}

describe('XotBaseModel Business Logic', function () {
    test('xot base model extends eloquent model', function () {
        expect(is_subclass_of(XotBaseModel::class, Model::class))->toBeTrue();
    });

    test('xot base model can be instantiated via subclass', function () {
        $model = new TestConcreteXotBaseModel();

        expect($model)->toBeInstanceOf(XotBaseModel::class);
        expect($model)->toBeInstanceOf(Model::class);
    });

    test('xot base model provides foundation for other models', function () {
        expect(class_exists(XotBaseModel::class))->toBeTrue();
    });
});
