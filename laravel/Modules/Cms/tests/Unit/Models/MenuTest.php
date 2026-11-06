<?php

declare(strict_types=1);

use Modules\Cms\Models\Menu;
use Modules\Tenant\Models\Traits\SushiToJsons;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

test('Menu model can be instantiated', function () {
    Assert::assertSame(Menu::class, (new Menu)::class);

});

test('Menu model has expected fillable fields', function () {
    $menu = new Menu;

    $fillable = $menu->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('parent_id', $fillable);
});

test('Menu model implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(HasRecursiveRelationships::class, $traits));
});

test('Menu model uses SushiToJsons trait', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(SushiToJsons::class, $traits));
});
