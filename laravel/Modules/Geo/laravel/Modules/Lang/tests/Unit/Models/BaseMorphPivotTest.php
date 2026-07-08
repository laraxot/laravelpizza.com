<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Illuminate\Database\Eloquent\Relations\MorphPivot;
use Modules\Lang\Models\BaseMorphPivot;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('BaseMorphPivot Model', function () {
    test('extends MorphPivot', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        Assert::assertInstanceOf(MorphPivot::class, $model);
    });

    test('has correct connection', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        Assert::assertSame('lang', $model->getConnectionName());
    });

    test('has snake attributes enabled', function () {
        Assert::assertTrue(BaseMorphPivot::$snakeAttributes);
    });

    test('has timestamps enabled', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        Assert::assertTrue($model->timestamps);
    });

    test('has incrementing enabled', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        Assert::assertTrue($model->incrementing);
    });

    test('has default perPage', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        Assert::assertSame(30, $model->getPerPage());
    });

    test('has correct fillable attributes', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };
        $fillable = $model->getFillable();

        Assert::assertContains('id', $fillable);
        Assert::assertContains('post_id', $fillable);
        Assert::assertContains('post_type', $fillable);
        Assert::assertContains('related_type', $fillable);
        Assert::assertContains('user_id', $fillable);
        Assert::assertContains('note', $fillable);
    });

    test('casts id as string', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        Assert::assertSame('string', $casts['id']);
    });

    test('casts datetime fields', function () {
        $model = new class extends BaseMorphPivot {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
        Assert::assertSame('datetime', $casts['deleted_at']);
    });
});
