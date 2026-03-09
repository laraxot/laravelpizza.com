<?php

declare(strict_types=1);

namespace Modules\Xot\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Models\XotBaseModel;

describe('XotBaseModel Business Logic', function () {
    test('xot base model extends eloquent model', function () {
        expect(XotBaseModel::class)->toBeSubclassOf(Model::class);
    });

    test('xot base model can be instantiated', function () {
        $model = new XotBaseModel();

        expect($model)->toBeInstanceOf(XotBaseModel::class);
        expect($model)->toBeInstanceOf(Model::class);
    });

    test('xot base model provides foundation for other models', function () {
        expect(class_exists(XotBaseModel::class))->toBeTrue();
    });
});
