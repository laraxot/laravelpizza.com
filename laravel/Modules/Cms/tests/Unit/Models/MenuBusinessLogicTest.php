<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

uses(TestCase::class);

describe('Menu Business Logic', function (): void {
    test('menu implements recursive relationships contract', function (): void {
        $menu = new Menu();
        Assert::assertInstanceOf(HasRecursiveRelationshipsContract::class, $menu);
    });

    test('menu has recursive relationships trait', function (): void {
        $traits = class_uses_recursive(Menu::class);

        Assert::assertContains(HasRecursiveRelationships::class, array_values($traits));
    });

    test('menu has sushi to json trait', function (): void {
        $traits = class_uses(Menu::class);

        Assert::assertArrayHasKey(SushiToJsons::class, $traits);
    });

    test('menu has expected fillable fields', function (): void {
        $menu = new Menu();
        $expectedFillable = [
            'title',
            'items',
            'parent_id',
        ];

        Assert::assertEquals($expectedFillable, $menu->getFillable());
    });

    test('menu can get label', function (): void {
        $menu = new Menu();
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    });

    test('menu has correct casts for structured data', function (): void {
        $menu = new Menu();
        $casts = $menu->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    });

    test('menu has schema definition for structured data', function (): void {
        $menu = new Menu();

        $reflection = new \ReflectionClass($menu);
        $schemaProperty = $reflection->getProperty('schema');

        Assert::assertTrue($schemaProperty->isProtected());

        /** @var array<string, mixed> $schema */
        $schema = $schemaProperty->getValue($menu);
        Assert::assertSame('string', $schema['title']);
        Assert::assertSame('integer', $schema['parent_id']);
    });

    test('menu can build tree queries', function (): void {
        $query = Menu::tree();

        Assert::assertInstanceOf(Builder::class, $query);
    });

    test('menu can query by depth', function (): void {
        $query = Menu::whereDepth(1);

        Assert::assertInstanceOf(Builder::class, $query);
    });
});
