<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

<<<<<<< HEAD
uses(TestCase::class);

use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Tests\TestCase;
=======
use Modules\Lang\Models\TranslationFile;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);
>>>>>>> 40b96bcd6 (.)

describe('TranslationFile Model', function () {
    test('uses Sushi trait', function () {
        $model = new TranslationFile();

        Assert::assertArrayHasKey('Sushi\Sushi', class_uses($model));
    });

    test('has correct fillable attributes', function () {
        $model = new TranslationFile();
        $fillable = $model->getFillable();

        Assert::assertContains('id', $fillable);
        Assert::assertContains('name', $fillable);
        Assert::assertContains('path', $fillable);
        Assert::assertContains('content', $fillable);
    });

    test('has form property accessible via reflection', function () {
        $model = new TranslationFile();
        $reflection = new \ReflectionClass($model);
        $property = $reflection->getProperty('form');
        $property->setAccessible(true);
        $form = $property->getValue($model);

        Assert::assertIsArray($form);
        Assert::assertSame('string', $form['key']);
        Assert::assertSame('string', $form['path']);
        Assert::assertSame('json', $form['content']);
    });

    test('casts content as array', function () {
        $model = new TranslationFile();
        $casts = $model->getCasts();

        Assert::assertSame('array', $casts['content']);
    });

    test('has getRows method', function () {
        $model = new TranslationFile();

        Assert::assertTrue(is_callable([$model, 'getRows']));
    });
});
