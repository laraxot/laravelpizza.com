<?php

declare(strict_types=1);

use Modules\Cms\Filament\Front\Pages\Welcome;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Welcome page can be instantiated', function () {
    $page = new Welcome();
});

test('Welcome page has view_type property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view_type');
    $property->setAccessible(true);

    Assert::assertSame('view_type', $property->getName());
});

test('Welcome page has containers property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('containers');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Welcome page has items property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('items');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Welcome page has instanceModel property', function () {
    $page = new Welcome();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('instanceModel');
    $property->setAccessible(true);

    Assert::assertSame('instanceModel', $property->getName());
});

test('Welcome page has mount method', function () {
});

test('Welcome page has getViewData method', function () {
});

test('Welcome page has initView method', function () {
});

test('Welcome page has url method', function () {
});

test('Welcome page has setModel method', function () {
});
