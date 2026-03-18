<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Filament\Clusters\Appearance\Pages;

use Modules\Cms\Filament\Clusters\Appearance\Pages\Headernav;

test('Headernav page can be instantiated', function () {
    $page = new Headernav();
    expect($page)->toBeObject();
});

test('Headernav page has data property', function () {
    $page = new Headernav();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Headernav page has headernavData property', function () {
    $page = new Headernav();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('headernavData');
    $property->setAccessible(true);

    expect($property->getName())->toBe('headernavData');
});

test('Headernav page has mount method', function () {
    expect(method_exists(Headernav::class, 'mount'))->toBeTrue();
});

test('Headernav page has schema method', function () {
    expect(method_exists(Headernav::class, 'schema'))->toBeTrue();
});

test('Headernav page has updateData method', function () {
    expect(method_exists(Headernav::class, 'updateData'))->toBeTrue();
});

test('Headernav page has fillForms method', function () {
    expect(method_exists(Headernav::class, 'fillForms'))->toBeTrue();
});

test('Headernav page has getUpdateFormActions method', function () {
    expect(method_exists(Headernav::class, 'getUpdateFormActions'))->toBeTrue();
});

test('Headernav page implements HasForms', function () {
    $interfaces = class_implements(Headernav::class);
    expect($interfaces)->toContain(Filament\Forms\Contracts\HasForms::class);
});

test('Headernav page uses InteractsWithForms trait', function () {
    $reflection = new ReflectionClass(Headernav::class);
    $traits = $reflection->getTraitNames();
    expect($traits)->toContain(Filament\Forms\Concerns\InteractsWithForms::class);
});
