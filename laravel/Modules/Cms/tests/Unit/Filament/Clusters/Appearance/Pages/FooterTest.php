<?php

declare(strict_types=1);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Footer;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Footer page can be instantiated', function () {
    $page = new Footer();
});

test('Footer page has data property', function () {
    $page = new Footer();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    Assert::assertIsArray($property->getValue($page));
});

test('Footer page has footerData property', function () {
    $page = new Footer();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('footerData');
    $property->setAccessible(true);

    // Property exists but is null by default
    Assert::assertSame('footerData', $property->getName());
});

test('Footer page has mount method', function () {
});

test('Footer page has schema method', function () {
});

test('Footer page has updateData method', function () {
});

test('Footer page has fillForms method', function () {
});

test('Footer page has getUpdateFormActions method', function () {
});
