<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Footer;

test('Footer page can be instantiated', function () {
    $page = new Footer();
    expect($page)->toBeObject();
});

test('Footer page has data property', function () {
    $page = new Footer();
    $reflection = new \ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    expect($property->getValue($page))->toBeArray();
});

test('Footer page has footerData property', function () {
    $page = new Footer();
    $reflection = new \ReflectionClass($page);
    $property = $reflection->getProperty('footerData');
    $property->setAccessible(true);

    // Property exists but is null by default
    expect($property->getName())->toBe('footerData');
});

test('Footer page has mount method', function () {
    expect(method_exists(Footer::class, 'mount'))->toBeTrue();
});

test('Footer page has schema method', function () {
    expect(method_exists(Footer::class, 'schema'))->toBeTrue();
});

test('Footer page has updateData method', function () {
    expect(method_exists(Footer::class, 'updateData'))->toBeTrue();
});

test('Footer page has fillForms method', function () {
    expect(method_exists(Footer::class, 'fillForms'))->toBeTrue();
});

test('Footer page has getUpdateFormActions method', function () {
    expect(method_exists(Footer::class, 'getUpdateFormActions'))->toBeTrue();
});
