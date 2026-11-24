<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModelLang;
use Modules\Cms\Models\Section;
<<<<<<< HEAD
use PHPUnit\Framework\Assert;

=======
use Modules\Cms\Tests\TestCase;
use PHPUnit\Framework\Assert;

// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
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
