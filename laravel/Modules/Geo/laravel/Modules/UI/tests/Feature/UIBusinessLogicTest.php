<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Feature;

use Modules\UI\Database\Factories\CategoryFactory;
use Modules\UI\Database\Factories\CollectionFactory;
use Modules\UI\Models\Collection;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('UI Business Logic Integration', function (): void {
    describe('Category management', function (): void {
        it('can activate and deactivate categories', function (): void {
            $category = CategoryFactory::new()->createOne([
                'title' => 'Toggle Category',
                'is_active' => 0,
            ]);

            Assert::assertSame(0, $category->is_active);
            $category->update(['is_active' => 1]);
            Assert::assertSame(1, $category->fresh()?->is_active);
        });

        it('supports parent-child hierarchy', function (): void {
            $parent = CategoryFactory::new()->createOne(['title' => 'Parent']);
            $child = CategoryFactory::new()->createOne([
                'title' => 'Child',
                'parent_id' => $parent->id,
            ]);

            Assert::assertSame($parent->id, $child->parent_id);
        });
    });

    describe('Collection management', function (): void {
        it('stores collection metadata', function (): void {
            $collection = CollectionFactory::new()->createOne([
                'name' => 'hero-block',
                'type' => 'block',
                'description' => 'Hero section blocks',
            ]);

            Assert::assertSame('hero-block', $collection->name);
            Assert::assertSame('block', $collection->type);
            Assert::assertSame('Hero section blocks', $collection->description);
        });

        it('lists collections by type', function (): void {
            CollectionFactory::new()->createOne(['name' => 'a', 'type' => 'block']);
            CollectionFactory::new()->createOne(['name' => 'b', 'type' => 'widget']);

            $blocks = Collection::query()->where('type', 'block')->get();
            Assert::assertGreaterThanOrEqual(1, $blocks->count());
        });
    });
});
