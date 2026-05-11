<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Tests\TestCase;

describe('TranslationFile Model', function () {
    test('uses Sushi trait', function () {
        $model = new TranslationFile();

        expect(class_uses($model))->toHaveKey('Sushi\Sushi');
    });

    test('has correct fillable attributes', function () {
        $model = new TranslationFile();
        $fillable = $model->getFillable();

        expect($fillable)->toContain('id');
        expect($fillable)->toContain('name');
        expect($fillable)->toContain('path');
        expect($fillable)->toContain('content');
    });

    test('has form property accessible via reflection', function () {
        $model = new TranslationFile();
        $reflection = new ReflectionClass($model);
        $property = $reflection->getProperty('form');
        $property->setAccessible(true);
        $form = $property->getValue($model);

        expect($form)->toBeArray();
        expect($form['key'])->toBe('string');
        expect($form['path'])->toBe('string');
        expect($form['content'])->toBe('json');
    });

    test('casts content as array', function () {
        $model = new TranslationFile();
        $casts = $model->getCasts();

        expect($casts['content'])->toBe('array');
    });

    test('has getRows method', function () {
        $model = new TranslationFile();

        expect(method_exists($model, 'getRows'))->toBeTrue();
    });
});
