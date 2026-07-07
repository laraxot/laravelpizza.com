<?php

declare(strict_types=1);

use Modules\Cms\Models\PageContent;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('PageContent Model', function (): void {
    test('page content model can be instantiated', function (): void {
        $model = new PageContent();

        Assert::assertInstanceOf(PageContent::class, $model);
    });

    test('page content model has expected fillable fields', function (): void {
        $model = new PageContent();

        $fillable = $model->getFillable();

        Assert::assertContains('name', $fillable);

        Assert::assertContains('slug', $fillable);

        Assert::assertContains('blocks', $fillable);
    });

    test('page content model has expected casts', function (): void {
        $model = new PageContent();

        $casts = $model->getCasts();

        Assert::assertArrayHasKey('id', $casts);

        Assert::assertArrayHasKey('slug', $casts);

        Assert::assertArrayHasKey('blocks', $casts);
    });

    test('page content model has translatable fields', function (): void {
        $model = new PageContent();

        Assert::assertContains('name', $model->translatable);

        Assert::assertContains('blocks', $model->translatable);
    });

    test('page content model uses HasTranslations trait', function (): void {
        $model = new PageContent();

        Assert::assertTrue(in_array(Spatie\Translatable\HasTranslations::class, class_uses_recursive($model)));
    });

    test('page content model uses SushiToJsons trait', function (): void {
        $model = new PageContent();

        Assert::assertTrue(in_array(Modules\Tenant\Models\Traits\SushiToJsons::class, class_uses_recursive($model)));
    });

    test('page content model has getRows method', function (): void {
        $model = new PageContent();
    });

    test('page content model has sluggable method', function (): void {
    });
});
