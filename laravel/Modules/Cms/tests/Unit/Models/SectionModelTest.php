<?php

declare(strict_types=1);

use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
describe('Section Model', function (): void {
    test('section model can be instantiated', function (): void {
        $model = new Section();

        Assert::assertInstanceOf(Section::class, $model);
    });

    test('section model has expected fillable fields', function (): void {
        $model = new Section();

        $fillable = $model->getFillable();

        Assert::assertContains('name', $fillable);

        Assert::assertContains('slug', $fillable);

        Assert::assertContains('blocks', $fillable);
    });

    test('section model has expected casts', function (): void {
        $model = new Section();

        $casts = $model->getCasts();

        Assert::assertArrayHasKey('id', $casts);

        Assert::assertArrayHasKey('slug', $casts);

        Assert::assertArrayHasKey('blocks', $casts);

        Assert::assertArrayHasKey('name', $casts);
    });

    test('section model has translatable fields', function (): void {
        $model = new Section();

        Assert::assertContains('name', $model->translatable);

        Assert::assertContains('blocks', $model->translatable);
    });

    test('section model uses HasBlocks trait', function (): void {
        $model = new Section();

        Assert::assertTrue(in_array(Modules\Cms\Models\Traits\HasBlocks::class, class_uses_recursive($model)));
    });

    test('section model uses SushiToJsons trait', function (): void {
        $model = new Section();

        Assert::assertTrue(in_array(Modules\Tenant\Models\Traits\SushiToJsons::class, class_uses_recursive($model)));
    });

    test('section model has getRows method', function (): void {
        $model = new Section();
    });

    test('section model extends BaseModelLang', function (): void {
        $model = new Section();

        Assert::assertInstanceOf(Modules\Cms\Models\BaseModelLang::class, $model);
    });
});
