<?php

declare(strict_types=1);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Breadcrumb;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Breadcrumb page uses correct view', function () {
    $page = new Breadcrumb();
    // Access protected property via reflection
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    Assert::assertSame('cms::filament.clusters.appearance.pages.headernav', $property->getValue($page));
});

test('Breadcrumb page can be instantiated', function () {
    $page = new Breadcrumb();
});

test('Breadcrumb page has data property', function () {
    $page = new Breadcrumb();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Breadcrumb page has mount method', function () {
});

test('Breadcrumb page has schema method', function () {
});

test('Breadcrumb page has updateData method', function () {
});
