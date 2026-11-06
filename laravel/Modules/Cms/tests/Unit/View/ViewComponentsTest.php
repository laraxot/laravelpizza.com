<?php

declare(strict_types=1);

use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use PHPUnit\Framework\Assert;

test('AppLayout component can be instantiated', function () {
    $component = new AppLayout;
    Assert::assertSame(AppLayout::class, $component::class);
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout;
    Assert::assertSame(GuestLayout::class, $component::class);
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags;
    Assert::assertSame(Metatags::class, $component::class);
});
