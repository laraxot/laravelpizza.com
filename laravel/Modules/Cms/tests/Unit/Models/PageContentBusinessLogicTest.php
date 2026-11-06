<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\PageContent;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Spatie\Translatable\HasTranslations;

/**
 * Verifica il contratto pubblico del model PageContent (contenuti traducibili e blocchi).
 */
final class PageContentBusinessLogicTest extends TestCase
{
    public function testUsesTranslationsAndSushiTraits(): void
    {
        Assert::assertArrayHasKey(HasTranslations::class, class_uses(PageContent::class));
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(PageContent::class));
    }

    public function testDeclaresTranslatableNameAndBlocks(): void
    {
        Assert::assertSame(['name', 'blocks'], (new PageContent())->translatable);
    }

    public function testExposesExpectedFillableAttributes(): void
    {
        Assert::assertSame(['name', 'slug', 'blocks'], (new PageContent())->getFillable());
    }

    public function testCastsBlocksAndIdentifiersForStructuredContent(): void
    {
        $casts = (new PageContent())->getCasts();

        Assert::assertSame('string', $casts['id']);
        Assert::assertSame('string', $casts['slug']);
        Assert::assertSame('array', $casts['blocks']);
    }

    public function testDefinesSlugSourceForSluggableConfiguration(): void
    {
        Assert::assertSame(
            ['slug' => ['source' => 'title']],
            (new PageContent())->sluggable(),
        );
    }
}
