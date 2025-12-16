<?php

declare(strict_types=1);
use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Menu;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Modules\Xot\Models\Traits\TypedHasRecursiveRelationships;

use function Safe\class_uses;

use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;

describe('Menu Business Logic', function () {
    test('menu extends base model', function () {
        expect(Menu::class)->toBeSubclassOf(BaseModel::class);
    });

    test('menu implements recursive relationships contract', function () {
        expect(Menu::class)->toImplement(HasRecursiveRelationshipsContract::class);
    });

    test('menu has recursive relationships trait', function () {
        $traits = class_uses(Menu::class);

        expect($traits)->toHaveKey(TypedHasRecursiveRelationships::class);
    });

    test('menu has sushi to json trait', function () {
        $traits = class_uses(Menu::class);

        expect($traits)->toHaveKey(SushiToJsons::class);
    });

    test('menu has expected fillable fields', function () {
        $menu = new Menu();
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];

        expect($menu->getFillable())->toEqual($expectedFillable);
    });

    test('menu can get tree options for hierarchical display', function () {
        $options = Menu::getTreeMenuOptions();

        expect($options)->toBeArray();
    });

    test('menu can get label', function () {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        expect($menu->getLabel())->toBe('Test Menu');
    });

    test('menu has correct casts for structured data', function () {
        $menu = new Menu();
        $casts = $menu->getCasts();

        expect($casts['items'])->toBe('array');
        expect($casts['id'])->toBe('string');
    });

    test('menu has schema definition for structured data', function () {
        $menu = new Menu();

        expect($menu)->toHaveProperty('schema');
        expect($menu->schema['title'])->toBe('string');
        expect($menu->schema['parent_id'])->toBe('integer');
    });

    test('menu can get rows for sushi functionality', function () {
        $menu = new Menu();

        expect(method_exists($menu, 'getRows'))->toBeTrue();
    });

    test('menu can build tree queries', function () {
        $query = Menu::tree();

        expect($query)->toBeInstanceOf(Builder::class);
    });

    test('menu can query by depth', function () {
        $query = Menu::whereDepth(1);

        expect($query)->toBeInstanceOf(Builder::class);
    });
});
