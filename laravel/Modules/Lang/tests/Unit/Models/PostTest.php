<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

uses(Modules\Lang\Tests\TestCase::class);

use Modules\Lang\Models\Post;

describe('Post Model', function () {
    test('extends BaseModel', function () {
        $model = new Post();

        expect($model)->toBeInstanceOf(Modules\Lang\Models\BaseModel::class);
    });

    test('uses HasSlug trait', function () {
        $model = new Post();

        expect(class_uses($model))->toHaveKey('Spatie\Sluggable\HasSlug');
    });

    test('uses HasXotFactory trait', function () {
        $model = new Post();

        expect(class_uses($model))->toHaveKey('Modules\Xot\Models\Traits\HasXotFactory');
    });

    test('uses Updater trait', function () {
        $model = new Post();

        expect(class_uses($model))->toHaveKey('Modules\Xot\Traits\Updater');
    });

    test('has correct connection', function () {
        $model = new Post();

        expect($model->getConnectionName())->toBe('lang');
    });

    test('has correct searchable fields', function () {
        expect(Post::SEARCHABLE_FIELDS)->toBe(['title', 'guid', 'txt']);
    });

    test('has snake attributes enabled', function () {
        expect(Post::$snakeAttributes)->toBeTrue();
    });

    test('has incrementing enabled', function () {
        $model = new Post();

        expect($model->incrementing)->toBeTrue();
    });

    test('has default perPage', function () {
        $model = new Post();

        expect($model->getPerPage())->toBe(30);
    });

    test('has correct fillable attributes', function () {
        $model = new Post();
        $fillable = $model->getFillable();

        expect($fillable)->toContain('id');
        expect($fillable)->toContain('user_id');
        expect($fillable)->toContain('post_id');
        expect($fillable)->toContain('lang');
        expect($fillable)->toContain('title');
    });

    test('has getSlugOptions method', function () {
        $model = new Post();

        expect(method_exists($model, 'getSlugOptions'))->toBeTrue();
    });

    test('has linkable relationship', function () {
        $model = new Post();

        expect(method_exists($model, 'linkable'))->toBeTrue();
    });

    test('has toSearchableArray method', function () {
        $model = new Post();

        expect(method_exists($model, 'toSearchableArray'))->toBeTrue();
    });

    test('casts datetime fields', function () {
        $model = new Post();
        $casts = $model->getCasts();

        expect($casts['created_at'])->toBe('datetime');
        expect($casts['updated_at'])->toBe('datetime');
        expect($casts['deleted_at'])->toBe('datetime');
        expect($casts['published_at'])->toBe('datetime');
    });

    test('casts array fields', function () {
        $model = new Post();
        $casts = $model->getCasts();

        expect($casts['image_resize_src'])->toBe('array');
        expect($casts['url_lang'])->toBe('array');
    });
});
