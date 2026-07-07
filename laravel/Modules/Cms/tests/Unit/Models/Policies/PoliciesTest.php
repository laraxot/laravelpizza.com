<?php

declare(strict_types=1);

use Modules\Cms\Models\Policies\MenuPolicy;
use Modules\Cms\Models\Policies\PagePolicy;
use Modules\Cms\Models\Policies\SectionPolicy;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('PagePolicy can be instantiated', function () {
    $policy = new PagePolicy();

    Assert::assertInstanceOf(PagePolicy::class, $policy);
});

test('MenuPolicy can be instantiated', function () {
    $policy = new MenuPolicy();

    Assert::assertInstanceOf(MenuPolicy::class, $policy);
});

test('SectionPolicy can be instantiated', function () {
    $policy = new SectionPolicy();

    Assert::assertInstanceOf(SectionPolicy::class, $policy);
});
