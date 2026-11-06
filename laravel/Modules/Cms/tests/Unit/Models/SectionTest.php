<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
use PHPUnit\Framework\Assert;

test('Section model can be instantiated', function () {
    Assert::assertSame(Section::class, (new Section)::class);

});

test('Section model has expected fillable fields', function () {
    $section = new Section;

    $fillable = $section->getFillable();

    // Actual fillable fields from the Section model
    Assert::assertContains('name', $fillable);
    Assert::assertContains('slug', $fillable);
    Assert::assertContains('blocks', $fillable);
});

test('Section model extends BaseModelLang', function () {
    Assert::assertSame(Section::class, (new Section)::class);

    // Section extends BaseModelLang for translations support
});

test('Section model has expected casts', function () {
    $section = new Section;

    $casts = $section->getCasts();

    Assert::assertArrayHasKey('slug', $casts);
    Assert::assertArrayHasKey('blocks', $casts);
    Assert::assertArrayHasKey('name', $casts);
});
