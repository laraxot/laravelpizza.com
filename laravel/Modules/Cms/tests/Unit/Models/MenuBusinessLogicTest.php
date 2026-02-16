<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);
use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\Menu;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;

use function Safe\class_uses;

describe('Menu Business Logic', function () {
    test('menu extends base model', function () {
        expect(Menu::class)->toBeSubclassOf(BaseModel::class);
    });

    test('menu implements recursive relationships contract', function () {
        $menu = new Menu;
        expect($menu)->toBeInstanceOf(HasRecursiveRelationshipsContract::class);
    });

    test('menu has recursive relationships trait', function () {
        $traits = class_uses_recursive(Menu::class);

        // Menu uses HasRecursiveRelationships from staudenmeir/laravel-adjacency-list
        expect(array_values($traits))->toContain(Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships::class);
    });

    test('menu has sushi to json trait', function () {
        $traits = class_uses(Menu::class);

        expect($traits)->toHaveKey(SushiToJsons::class);
    });

    test('menu has expected fillable fields', function () {
        $menu = new Menu;
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
        $menu = new Menu;
        $menu->title = 'Test Menu';

        expect($menu->getLabel())->toBe('Test Menu');
    });

    test('menu has correct casts for structured data', function () {
        $menu = new Menu;
        $casts = $menu->getCasts();

        expect($casts['items'])->toBe('array');
        expect($casts['id'])->toBe('string');
    });

    test('menu has schema definition for structured data', function () {
        $menu = new Menu;

        // Use reflection to access protected $schema property
        $reflection = new ReflectionClass($menu);
        $schemaProperty = $reflection->getProperty('schema');

        expect($schemaProperty->isProtected())->toBeTrue();

        $schema = $schemaProperty->getValue($menu);
        expect($schema)->toBeArray();
        expect($schema['title'])->toBe('string');
        expect($schema['parent_id'])->toBe('integer');
    });

    test('menu can get rows for sushi functionality', function () {
        $menu = new Menu;

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
