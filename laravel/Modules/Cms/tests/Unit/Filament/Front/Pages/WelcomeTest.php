<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Front\Pages\Welcome;

test('Welcome page can be instantiated', function () {
    $page = new Welcome();
    expect($page)->toBeObject();
});

test('Welcome page has view_type property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    expect($property->getName())->toBe('view_type');
});

test('Welcome page has containers property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Welcome page has items property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Welcome page has instanceModel property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('instanceModel');
    $property->setAccessible(true);

    expect($property->getName())->toBe('instanceModel');
});

test('Welcome page has mount method', function () {
    expect(method_exists(Welcome::class, 'mount'))->toBeTrue();
});

test('Welcome page has getViewData method', function () {
    expect(method_exists(Welcome::class, 'getViewData'))->toBeTrue();
});

test('Welcome page has initView method', function () {
    expect(method_exists(Welcome::class, 'initView'))->toBeTrue();
});

test('Welcome page has url method', function () {
    expect(method_exists(Welcome::class, 'url'))->toBeTrue();
});

test('Welcome page has setModel method', function () {
    expect(method_exists(Welcome::class, 'setModel'))->toBeTrue();
});
