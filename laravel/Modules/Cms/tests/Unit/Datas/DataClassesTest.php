<?php

declare(strict_types=1);

use Modules\Cms\Datas\BlockData;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Datas\LinkData;
use Modules\Cms\Datas\NavbarMenuData;
use Modules\Cms\Datas\ThemeData;
use PHPUnit\Framework\Assert;

test('BlockData can be instantiated', function () {
    Assert::assertTrue(class_exists(BlockData::class));
});

test('FooterData can be instantiated', function () {
    $footerData = FooterData::from([]);

    Assert::assertSame('cms::components.footer', $footerData->view);
});

test('HeadernavData can be instantiated', function () {
    $headernavData = HeadernavData::from([]);

    Assert::assertSame('cms::components.headernav', $headernavData->view);
});

test('LinkData can be instantiated', function () {
    Assert::assertTrue(class_exists(LinkData::class));
});

test('NavbarMenuData can be instantiated', function () {
    Assert::assertTrue(class_exists(NavbarMenuData::class));
});

test('ThemeData can be instantiated', function () {
    Assert::assertTrue(class_exists(ThemeData::class));
});
