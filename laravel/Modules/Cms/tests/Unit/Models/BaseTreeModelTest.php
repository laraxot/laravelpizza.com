<?php

declare(strict_types=1);

use Modules\Cms\Models\BaseModel;
use Modules\Cms\Models\BaseTreeModel;
use PHPUnit\Framework\Assert;
use Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships;

test('BaseTreeModel is abstract and extends BaseModel', function () {
    $reflection = new ReflectionClass(BaseTreeModel::class);

    Assert::assertTrue($reflection->isAbstract());

    $parent = $reflection->getParentClass();
    Assert::assertInstanceOf(ReflectionClass::class, $parent);
    Assert::assertSame(BaseModel::class, $parent->getName());
});

test('BaseTreeModel implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(BaseTreeModel::class);
    $traits = $reflection->getTraitNames();

    Assert::assertTrue(in_array(HasRecursiveRelationships::class, $traits));
});

test('BaseTreeModel has expected fillable fields', function () {
    // Create a concrete implementation for testing
    $model = new class extends BaseTreeModel {
        protected $table = 'test';
    };

    $fillable = $model->getFillable();

    Assert::assertContains('title', $fillable);

    Assert::assertContains('items', $fillable);

    Assert::assertContains('parent_id', $fillable);
});

test('BaseTreeModel has expected casts', function () {
    // Create a concrete implementation for testing
    $model = new class extends BaseTreeModel {
        protected $table = 'test';
    };

    $casts = $model->getCasts();

    Assert::assertArrayHasKey('items', $casts);

    Assert::assertSame('array', $casts['items']);
});
