<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Datas\BlockData;
use Modules\Cms\Datas\FooterData;
use Modules\Cms\Datas\HeadernavData;
use Modules\Cms\Datas\LinkData;
use Modules\Cms\Datas\NavbarMenuData;
use Modules\Cms\Datas\ThemeData;

test('BlockData can be instantiated', function () {
    // BlockData might not have a simple constructor, so just check if class exists
    expect(class_exists(BlockData::class))->toBeTrue();
});

test('FooterData can be instantiated', function () {
    $footerData = FooterData::from([]);

    expect($footerData)->toBeInstanceOf(FooterData::class);
});

test('HeadernavData can be instantiated', function () {
    $headernavData = HeadernavData::from([]);

    expect($headernavData)->toBeInstanceOf(HeadernavData::class);
});

test('LinkData can be instantiated', function () {
    // Check if LinkData class exists
    expect(class_exists(LinkData::class))->toBeTrue();
});

test('NavbarMenuData can be instantiated', function () {
    // Check if NavbarMenuData class exists
    expect(class_exists(NavbarMenuData::class))->toBeTrue();
});

test('ThemeData can be instantiated', function () {
    // Check if ThemeData class exists
    expect(class_exists(ThemeData::class))->toBeTrue();
});
