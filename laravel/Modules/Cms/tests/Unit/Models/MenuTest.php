<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\Menu;

test('Menu model can be instantiated', function () {
    $menu = new Menu;

    expect($menu)->toBeInstanceOf(Menu::class);
});

test('Menu model has expected fillable fields', function () {
    $menu = new Menu;

    $fillable = $menu->getFillable();

    expect($fillable)->toContain('title')
        ->and($fillable)->toContain('parent_id');
});

test('Menu model implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    expect(in_array(Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships::class, $traits))->toBeTrue();
});

test('Menu model uses SushiToJsons trait', function () {
    $reflection = new ReflectionClass(Menu::class);
    $traits = $reflection->getTraitNames();

    expect(in_array(Modules\Tenant\Models\Traits\SushiToJsons::class, $traits))->toBeTrue();
});
