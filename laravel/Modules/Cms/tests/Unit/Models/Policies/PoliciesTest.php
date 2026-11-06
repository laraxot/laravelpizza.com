<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use PHPUnit\Framework\Assert;

test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy;
    Assert::assertSame(PagePolicy::class, $policy::class);

});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy;
    Assert::assertSame(MenuPolicy::class, $policy::class);

});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy;
    Assert::assertSame(SectionPolicy::class, $policy::class);

});
