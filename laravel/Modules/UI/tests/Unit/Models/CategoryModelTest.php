<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Models;

use Modules\UI\Models\Category;
use Modules\UI\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Category Model', function (): void {
    test('it can hydrate a category with valid data in memory', function (): void {
        $category = new Category;
        $category->forceFill([
            'title' => 'Test Category',
            'slug' => 'test-category',
            'is_active' => 1,
            'sort_order' => 0,
        ]);

        Assert::assertSame('Test Category', $category->title);
        Assert::assertSame('test-category', $category->slug);
        Assert::assertSame(1, (int) $category->is_active);
    });

    test('it has fillable attributes', function (): void {
        $category = new Category;
        $expected = ['name', 'description', 'icon', 'parent_id', 'is_active', 'sort_order'];

        foreach ($expected as $field) {
            Assert::assertTrue(in_array($field, $category->getFillable(), true));
        }
    });

    test('category has timestamps enabled', function (): void {
        $category = new Category;

        Assert::assertTrue($category->timestamps);
    });
});
