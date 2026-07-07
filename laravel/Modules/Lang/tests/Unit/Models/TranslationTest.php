<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Lang\Models\Translation;
use Modules\Lang\Tests\TestCase;
=======
use Illuminate\Database\Eloquent\Builder;
use Modules\Lang\Models\Translation;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);
>>>>>>> 40b96bcd6 (.)

describe('Translation Model', function () {
    test('has correct fillable attributes', function () {
        $model = new Translation();
        $fillable = $model->getFillable();

        Assert::assertContains('id', $fillable);
        Assert::assertContains('lang', $fillable);
        Assert::assertContains('value', $fillable);
        Assert::assertContains('namespace', $fillable);
        Assert::assertContains('group', $fillable);
        Assert::assertContains('item', $fillable);
    });

    test('has correct status constants', function () {
        Assert::assertSame(0, Translation::STATUS_SAVED);
        Assert::assertSame(1, Translation::STATUS_CHANGED);
    });

    test('scopeOfTranslatedGroup filters by group', function () {
        $result = Translation::ofTranslatedGroup('test');

        Assert::assertInstanceOf(Builder::class, $result);
    });

    test('scopeOrderByGroupKeys orders by group and key', function () {
        $result = Translation::orderByGroupKeys(true);

        Assert::assertInstanceOf(Builder::class, $result);
    });

    test('scopeSelectDistinctGroup selects distinct groups', function () {
        $result = Translation::selectDistinctGroup();

        Assert::assertInstanceOf(Builder::class, $result);
    });

    test('casts datetime fields', function () {
        $model = new Translation();
        $casts = $model->getCasts();

        Assert::assertArrayHasKey('created_at', $casts);
        Assert::assertArrayHasKey('updated_at', $casts);
    });
});
