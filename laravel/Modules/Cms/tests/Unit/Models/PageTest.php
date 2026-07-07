<?php

declare(strict_types=1);

use Modules\Cms\Models\Page;
use PHPUnit\Framework\Assert;

it('declares page model contract', function (): void {
    $reflection = new ReflectionClass(Page::class);

    Assert::assertSame(Page::class, $reflection->getName());
    Assert::assertTrue($reflection->hasMethod('getMiddlewareBySlug'));
});
