<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('Menu model can be instantiated', function () {
    $menu = new Menu();

    Assert::assertInstanceOf(Menu::class, $menu);
});

test('Menu model has expected fillable fields', function () {
    $menu = new Menu();

    $fillable = $menu->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('parent_id', $fillable);
});

test('Menu model implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships::class, $traits));
});

test('Menu model uses SushiToJsons trait', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(Modules\Tenant\Models\Traits\SushiToJsons::class, $traits));
});
