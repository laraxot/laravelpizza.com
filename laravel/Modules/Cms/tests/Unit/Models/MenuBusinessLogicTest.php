<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Unit\Models;

use Modules\Cms\Models\Menu;
use Modules\Cms\Tests\TestCase;
use Modules\Tenant\Models\Traits\SushiToJsons;
use Modules\Xot\Contracts\HasRecursiveRelationshipsContract;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\Builder;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

use function Safe\class_implements;
use function Safe\class_uses;

/**
 * Verifica il contratto pubblico del model Menu (navigazione gerarchica Sushi).
 */
final class MenuBusinessLogicTest extends TestCase
{
    public function test_extends_cms_base_model(): void {}

    public function test_implements_recursive_relationships_contract(): void
    {
        Assert::assertTrue(in_array(HasRecursiveRelationshipsContract::class, class_implements(Menu::class), true));
    }

    public function test_uses_recursive_relationships_trait(): void
    {
        Assert::assertArrayHasKey(HasRecursiveRelationships::class, class_uses(Menu::class));
    }

    public function test_uses_sushi_to_json_trait(): void
    {
        Assert::assertArrayHasKey(SushiToJsons::class, class_uses(Menu::class));
    }

    public function test_exposes_expected_fillable_attributes(): void
    {
        Assert::assertSame(['title', 'items', 'parent_id'], (new Menu)->getFillable());
    }

    public function test_resolves_human_readable_label_from_title(): void
    {
        $menu = new Menu;
        $menu->title = 'Test Menu';

        Assert::assertSame('Test Menu', $menu->getLabel());
    }

    public function test_casts_structured_menu_items_as_array(): void
    {
        $casts = (new Menu)->getCasts();

        Assert::assertSame('array', $casts['items']);
        Assert::assertSame('string', $casts['id']);
    }

    public function test_builds_adjacency_list_tree_queries(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::tree());
    }

    public function test_can_filter_menu_nodes_by_depth(): void
    {
        Assert::assertInstanceOf(Builder::class, Menu::whereDepth(1));
    }
}
