<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\PageContent;

describe('PageContent Model', function (): void {
    test('page content model can be instantiated', function (): void {
        $model = new PageContent();

        expect($model)->toBeInstanceOf(PageContent::class);
    });

    test('page content model has expected fillable fields', function (): void {
        $model = new PageContent();

        $fillable = $model->getFillable();

        expect($fillable)->toContain('name')
            ->and($fillable)->toContain('slug')
            ->and($fillable)->toContain('blocks');
    });

    test('page content model has expected casts', function (): void {
        $model = new PageContent();

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('id')
            ->and($casts)->toHaveKey('slug')
            ->and($casts)->toHaveKey('blocks');
    });

    test('page content model has translatable fields', function (): void {
        $model = new PageContent();

        expect($model->translatable)->toContain('name')
            ->and($model->translatable)->toContain('blocks');
    });

    test('page content model uses HasTranslations trait', function (): void {
        $model = new PageContent();

        expect(in_array(Spatie\Translatable\HasTranslations::class, class_uses_recursive($model)))->toBeTrue();
    });

    test('page content model uses SushiToJsons trait', function (): void {
        $model = new PageContent();

        expect(in_array(Modules\Tenant\Models\Traits\SushiToJsons::class, class_uses_recursive($model)))->toBeTrue();
    });

    test('page content model has getRows method', function (): void {
        $model = new PageContent();

        expect(method_exists($model, 'getRows'))->toBeTrue();
    });

    test('page content model has sluggable method', function (): void {
        expect(method_exists(PageContent::class, 'sluggable'))->toBeTrue();
    });
});
