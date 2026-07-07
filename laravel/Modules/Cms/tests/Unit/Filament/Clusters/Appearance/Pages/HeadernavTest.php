<?php

declare(strict_types=1);

use Modules\Cms\Filament\Clusters\Appearance\Pages\Headernav;
use PHPUnit\Framework\Assert;

use function Safe\class_implements;

uses(Modules\Cms\Tests\TestCase::class);
test('Headernav page can be instantiated', function () {
    $page = new Headernav();
});

test('Headernav page has data property', function () {
    $page = new Headernav();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('data');
    $property->setAccessible(true);

    /** @var array<string, mixed> $dataValue */
    $dataValue = $property->getValue($page);
    Assert::assertArrayHasKey('sections', $dataValue);
});

test('Headernav page has headernavData property', function () {
    $page = new Headernav();
    $reflection = new ReflectionClass($page);
    $property = $reflection->getProperty('headernavData');
    $property->setAccessible(true);

    Assert::assertSame('headernavData', $property->getName());
});

test('Headernav page has mount method', function () {
});

test('Headernav page has schema method', function () {
});

test('Headernav page has updateData method', function () {
});

test('Headernav page has fillForms method', function () {
});

test('Headernav page has getUpdateFormActions method', function () {
});

test('Headernav page implements HasForms', function () {
    $interfaces = class_implements(Headernav::class);
    Assert::assertNotFalse($interfaces);
    Assert::assertContains(Filament\Forms\Contracts\HasForms::class, $interfaces);
});

test('Headernav page uses InteractsWithForms trait', function () {
    $reflection = new ReflectionClass(Headernav::class);
    $traits = $reflection->getTraitNames();
    Assert::assertContains(Filament\Forms\Concerns\InteractsWithForms::class, $traits);
});
