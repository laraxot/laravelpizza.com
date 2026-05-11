<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Lang\Models\BaseModelLang;
use Modules\Lang\Tests\TestCase;

describe('BaseModelLang', function () {
    test('has correct connection', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        expect($model->getConnectionName())->toBe('lang');
    });

    test('has LinkedTrait in traits list', function () {
        // Check if BaseModelLang uses the LinkedTrait
        $reflection = new ReflectionClass(BaseModelLang::class);
        $traits = $reflection->getTraitNames();

        // Check if any trait contains 'Linked' in its name
        $hasLinked = count(array_filter($traits, fn ($t) => str_contains($t, 'Linked'))) > 0;
        expect($hasLinked)->toBeTrue();
    });

    test('has snake attributes enabled', function () {
        expect(BaseModelLang::$snakeAttributes)->toBeTrue();
    });

    test('has timestamps enabled', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        expect($model->timestamps)->toBeTrue();
    });

    test('has incrementing set from property', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        expect($model->incrementing)->toBeTrue();
    });

    test('has default perPage', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        expect($model->getPerPage())->toBe(30);
    });

    test('casts id as string', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        expect($casts['id'])->toBe('string');
    });

    test('casts datetime fields', function () {
        $model = new class extends BaseModelLang {
            protected $table = 'test';
        };

        $casts = $model->getCasts();
        expect($casts['published_at'])->toBe('datetime');
        expect($casts['created_at'])->toBe('datetime');
        expect($casts['updated_at'])->toBe('datetime');
    });
});
