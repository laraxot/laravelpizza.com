<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\PageContent;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Spatie\Translatable\HasTranslations;

use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model PageContent (contenuti traducibili e blocchi).
 */
final class PageContentBusinessLogicTest extends TestCase
{
    public function test_uses_translations_and_sushi_traits(): void
    {
        Assert::assertArrayHasKey(HasTranslations::class, class_uses(PageContent::class));
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(PageContent::class));
    }

    public function test_declares_translatable_name_and_blocks(): void
    {
        Assert::assertSame(['name', 'blocks'], (new PageContent)->translatable);
    }

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['name', 'slug', 'blocks'], (new PageContent)->getFillable());
    }

    public function test_casts_blocks_and_identifiers_for_structured_content(): void
    {
        $casts = (new PageContent)->getCasts();

        Assert::assertSame('string', $casts['id']);
        Assert::assertSame('string', $casts['slug']);
        Assert::assertSame('array', $casts['blocks']);
    }

    public function test_defines_slug_source_for_sluggable_configuration(): void
    {
        Assert::assertSame(
            ['slug' => ['source' => 'title']],
            (new PageContent)->sluggable(),
        );
    }
}
