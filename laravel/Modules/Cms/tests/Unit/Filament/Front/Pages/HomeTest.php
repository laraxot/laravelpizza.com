<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Front\Pages;

use Modules\Cms\Filament\Front\Pages\Home;

test('Home page can be instantiated', function () {
    $page = new Home();
    expect($page)->toBeObject();
});

test('Home page has view_type property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    expect($property->getName())->toBe('view_type');
});

test('Home page has containers property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Home page has items property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Home page has mount method', function () {
    expect(method_exists(Home::class, 'mount'))->toBeTrue();
});

test('Home page has getViewData method', function () {
    expect(method_exists(Home::class, 'getViewData'))->toBeTrue();
});

test('Home page has initView method', function () {
    expect(method_exists(Home::class, 'initView'))->toBeTrue();
});

test('Home page has url method', function () {
    expect(method_exists(Home::class, 'url'))->toBeTrue();
});
