<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class, Illuminate\Foundation\Testing\DatabaseTransactions::class);

use Modules\Cms\Models\Section;

describe('Section Model', function (): void {
    test('section model can be instantiated', function (): void {
        $model = new Section();

        expect($model)->toBeInstanceOf(Section::class);
    });

    test('section model has expected fillable fields', function (): void {
        $model = new Section();

        $fillable = $model->getFillable();

        expect($fillable)->toContain('name')
            ->and($fillable)->toContain('slug')
            ->and($fillable)->toContain('blocks');
    });

    test('section model has expected casts', function (): void {
        $model = new Section();

        $casts = $model->getCasts();

        expect($casts)->toHaveKey('id')
            ->and($casts)->toHaveKey('slug')
            ->and($casts)->toHaveKey('blocks')
            ->and($casts)->toHaveKey('name');
    });

    test('section model has translatable fields', function (): void {
        $model = new Section();

        expect($model->translatable)->toContain('name')
            ->and($model->translatable)->toContain('blocks');
    });

    test('section model uses HasBlocks trait', function (): void {
        $model = new Section();

        expect(in_array(\Modules\Cms\Models\Traits\HasBlocks::class, class_uses_recursive($model)))->toBeTrue();
    });

    test('section model uses SushiToJsons trait', function (): void {
        $model = new Section();

        expect(in_array(\Modules\Tenant\Models\Traits\SushiToJsons::class, class_uses_recursive($model)))->toBeTrue();
    });

    test('section model has getRows method', function (): void {
        $model = new Section();

        expect(method_exists($model, 'getRows'))->toBeTrue();
    });

    test('section model extends BaseModelLang', function (): void {
        $model = new Section();

        expect($model)->toBeInstanceOf(\Modules\Cms\Models\BaseModelLang::class);
    });
});
