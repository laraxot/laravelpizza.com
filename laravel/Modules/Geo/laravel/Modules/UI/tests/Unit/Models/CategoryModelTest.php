<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Database\Factories\CategoryFactory;
use Modules\UI\Models\Category;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Category Model', function (): void {
    test('it can create a category with valid data', function (): void {
        $category = CategoryFactory::new()->createOne([
            'title' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => 1,
        ]);

        Assert::assertSame('Test Category', $category->title);
        Assert::assertSame(1, $category->is_active);
    });

    test('it has fillable attributes', function (): void {
        $category = new Category();
        $expected = ['name', 'description', 'icon', 'parent_id', 'is_active', 'sort_order'];

        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $category->getFillable(), true));
        }
    });

    test('category has timestamps', function (): void {
        $category = CategoryFactory::new()->createOne();

        Assert::assertNotNull($category->created_at);
        Assert::assertNotNull($category->updated_at);
    });
});
