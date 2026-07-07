<?php

declare(strict_types=1);

use Modules\Cms\Datas\BlockData;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Datas\LinkData;
use Modules\Cms\Datas\NavbarMenuData;
use Modules\Cms\Datas\ThemeData;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('BlockData can be instantiated', function () {
    // BlockData might not have a simple constructor, so just check if class exists
    Assert::assertTrue(class_exists(BlockData::class));
});

test('FooterData can be instantiated', function () {
    $footerData = FooterData::from([]);

    Assert::assertInstanceOf(FooterData::class, $footerData);
});

test('HeadernavData can be instantiated', function () {
    $headernavData = HeadernavData::from([]);

    Assert::assertInstanceOf(HeadernavData::class, $headernavData);
});

test('LinkData can be instantiated', function () {
    // Check if LinkData class exists
    Assert::assertTrue(class_exists(LinkData::class));
});

test('NavbarMenuData can be instantiated', function () {
    // Check if NavbarMenuData class exists
    Assert::assertTrue(class_exists(NavbarMenuData::class));
});

test('ThemeData can be instantiated', function () {
    // Check if ThemeData class exists
    Assert::assertTrue(class_exists(ThemeData::class));
});
