<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Modules\Lang\Models\BaseModelLang;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('BaseModelLang', function () {
    test('has correct connection', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        Assert::assertSame('lang', $model->getConnectionName());
    });

    test('has LinkedTrait in traits list', function () {
        $reflection = new \ReflectionClass(BaseModelLang::class);
        $traits = $reflection->getTraitNames();

        $hasLinked = count(array_filter($traits, fn ($t) => str_contains($t, 'Linked'))) > 0;
        Assert::assertTrue($hasLinked);
    });

    test('has snake attributes enabled', function () {
        Assert::assertTrue(BaseModelLang::$snakeAttributes);
    });

    test('has timestamps enabled', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        Assert::assertTrue($model->timestamps);
    });

    test('has incrementing set from property', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        Assert::assertTrue($model->incrementing);
    });

    test('has default perPage', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        Assert::assertSame(30, $model->getPerPage());
    });

    test('casts id as string', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        Assert::assertSame('string', $casts['id']);
    });

    test('casts datetime fields', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        Assert::assertSame('datetime', $casts['published_at']);
        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
    });
});
