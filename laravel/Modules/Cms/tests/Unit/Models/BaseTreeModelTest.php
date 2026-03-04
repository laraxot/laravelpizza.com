<?php

declare(strict_types=1);

uses(Modules\Cms\Tests\TestCase::class);

use Modules\Cms\Models\BaseTreeModel;

test('BaseTreeModel is abstract and extends BaseModel', function () {
    $reflection = new ReflectionClass(BaseTreeModel::class);

    expect($reflection->isAbstract())->toBeTrue()
        ->and($reflection->getParentClass()->getName())->toBe(Modules\Cms\Models\BaseModel::class);
});

test('BaseTreeModel implements HasRecursiveRelationships', function () {
    $reflection = new ReflectionClass(BaseTreeModel::class);
    $traits = $reflection->getTraitNames();

    expect(in_array(Staudenmeir\LaravelAdjacencyList\Eloquent\HasRecursiveRelationships::class, $traits))->toBeTrue();
});

test('BaseTreeModel has expected fillable fields', function () {
    // Create a concrete implementation for testing
    $model = new class extends BaseTreeModel
    {
        protected $table = 'test';
    };

    $fillable = $model->getFillable();

    expect($fillable)->toContain('title')
        ->and($fillable)->toContain('items')
        ->and($fillable)->toContain('parent_id');
});

test('BaseTreeModel has expected casts', function () {
    // Create a concrete implementation for testing
    $model = new class extends BaseTreeModel
    {
        protected $table = 'test';
    };

    $casts = $model->getCasts();

    expect($casts)->toHaveKey('items')
        ->and($casts['items'])->toBe('array');
});
