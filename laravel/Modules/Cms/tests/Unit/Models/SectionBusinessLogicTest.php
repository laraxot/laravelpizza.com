<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Section;
use Modules\Cms\Models\Traits\HasBlocks;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

<<<<<<< HEAD
=======
// Senza questo binding le closure di `test()`/`it()` restano legate a
// PHPUnit\Framework\TestCase, cioe' a un caso di test SENZA applicazione
// Laravel: `app()`, `config()` e le facade non si risolvono. Era la causa di
// 94 fallimenti «Target class [config] does not exist» nel modulo
// (base_quaeris_fila5#228).
uses(TestCase::class);

>>>>>>> laraxot/dev
/**
 * Verifica il contratto pubblico del model Section (blocchi multilingua).
 */
final class SectionBusinessLogicTest extends TestCase
{
    public function test_extends_base_model_lang_for_translations(): void {}

    public function test_declares_translatable_name_and_blocks(): void
    {
        Assert::assertSame(['name', 'blocks'], (new Section)->translatable);
    }

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['name', 'slug', 'blocks'], (new Section)->getFillable());
    }

    public function test_uses_sushi_to_json_trait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Section::class));
    }

    public function test_uses_has_blocks_trait(): void
    {
        Assert::assertArrayHasKey(HasBlocks::class, class_uses(Section::class));
    }

    public function test_casts_multilingual_fields_as_arrays(): void
    {
        $casts = (new Section)->getCasts();

        Assert::assertSame('array', $casts['name']);
        Assert::assertSame('array', $casts['blocks']);
        Assert::assertSame('string', $casts['id']);
    }
}
