<?php

declare(strict_types=1);

use Modules\Cms\Models\PageContent;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Spatie\Translatable\HasTranslations;

it('declares page content model contract', function (): void {
    $reflection = new ReflectionClass(PageContent::class);
    $traits = class_uses_recursive(PageContent::class);

    Assert::assertSame(PageContent::class, $reflection->getName());
    Assert::assertContains(SushiToJsons::class, array_values($traits));
    Assert::assertContains(HasTranslations::class, array_values($traits));
});
