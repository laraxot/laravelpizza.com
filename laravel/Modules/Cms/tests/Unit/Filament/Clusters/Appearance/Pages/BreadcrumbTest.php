<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Clusters\Appearance\Pages;

use Modules\Cms\Filament\Clusters\Appearance\Pages\Breadcrumb;

test('Breadcrumb page uses correct view', function () {
    $page = new Breadcrumb();
    // Access protected property via reflection
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('view');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBe('cms::filament.clusters.appearance.pages.headernav');
});

test('Breadcrumb page can be instantiated', function () {
    $page = new Breadcrumb();
    expect($page)->toBeObject();
});

test('Breadcrumb page has data property', function () {
    $page = new Breadcrumb();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Breadcrumb page has mount method', function () {
    expect(method_exists(Breadcrumb::class, 'mount'))->toBeTrue();
});

test('Breadcrumb page has schema method', function () {
    expect(method_exists(Breadcrumb::class, 'schema'))->toBeTrue();
});

test('Breadcrumb page has updateData method', function () {
    expect(method_exists(Breadcrumb::class, 'updateData'))->toBeTrue();
});
