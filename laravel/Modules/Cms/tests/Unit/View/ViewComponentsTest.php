<?php

declare(strict_types=1);

use Modules\Cms\View\Components\AppLayout;
use Modules\Cms\View\Components\GuestLayout;
use Modules\Cms\View\Components\Metatags;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('AppLayout component can be instantiated', function () {
    $component = new AppLayout();
    Assert::assertInstanceOf(AppLayout::class, $component);
});

test('GuestLayout component can be instantiated', function () {
    $component = new GuestLayout();
    Assert::assertInstanceOf(GuestLayout::class, $component);
});

test('Metatags component can be instantiated', function () {
    $component = new Metatags();
    Assert::assertInstanceOf(Metatags::class, $component);
});
