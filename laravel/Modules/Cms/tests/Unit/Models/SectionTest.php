<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Section;

test('Section model can be instantiated', function () {
    $section = new Section;

    expect($section)->toBeInstanceOf(Section::class);
});

test('Section model has expected fillable fields', function () {
    $section = new Section;

    $fillable = $section->getFillable();

    // Actual fillable fields from the Section model
    expect($fillable)->toContain('name')
        ->and($fillable)->toContain('slug')
        ->and($fillable)->toContain('blocks');
});

test('Section model extends BaseModelLang', function () {
    $section = new Section;

    // Section extends BaseModelLang for translations support
    expect($section)->toBeInstanceOf(Modules\Cms\Models\BaseModelLang::class);
});

test('Section model has expected casts', function () {
    $section = new Section;

    $casts = $section->getCasts();

    expect($casts)->toBeArray();
});
