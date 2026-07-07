<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Home;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Home page can be instantiated', function () {
    $page = new Home();
});

test('Home page has view_type property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    Assert::assertSame('view_type', $property->getName());
});

test('Home page has containers property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Home page has items property', function () {
    $page = new Home();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Home page has mount method', function () {
});

test('Home page has getViewData method', function () {
});

test('Home page has initView method', function () {
});

test('Home page has url method', function () {
});
