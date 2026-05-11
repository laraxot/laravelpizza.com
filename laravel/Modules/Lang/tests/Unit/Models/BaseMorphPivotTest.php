<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Lang\Models\BaseMorphPivot;
use Modules\Lang\Tests\TestCase;

describe('BaseMorphPivot Model', function () {
    test('extends MorphPivot', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        expect($model)->toBeInstanceOf(Illuminate\Database\Eloquent\Relations\MorphPivot::class);
    });

    test('has correct connection', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        expect($model->getConnectionName())->toBe('lang');
    });

    test('has snake attributes enabled', function () {
        expect(BaseMorphPivot::$snakeAttributes)->toBeTrue();
    });

    test('has timestamps enabled', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        expect($model->timestamps)->toBeTrue();
    });

    test('has incrementing enabled', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        expect($model->incrementing)->toBeTrue();
    });

    test('has default perPage', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        expect($model->getPerPage())->toBe(30);
    });

    test('has correct fillable attributes', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };
        $fillable = $model->getFillable();

        expect($fillable)->toContain('id');
        expect($fillable)->toContain('post_id');
        expect($fillable)->toContain('post_type');
        expect($fillable)->toContain('related_type');
        expect($fillable)->toContain('user_id');
        expect($fillable)->toContain('note');
    });

    test('casts id as string', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        expect($casts['id'])->toBe('string');
    });

    test('casts datetime fields', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        expect($casts['created_at'])->toBe('datetime');
        expect($casts['updated_at'])->toBe('datetime');
        expect($casts['deleted_at'])->toBe('datetime');
    });
});
