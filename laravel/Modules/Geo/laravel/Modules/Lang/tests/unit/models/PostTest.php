<?php

declare(strict_types=1);

namespace Modules\Lang\Tests\Unit\Models;

use Modules\Lang\Models\BaseModel;
use Modules\Lang\Models\Post;
use Modules\Lang\Tests\TestCase;
use PHPUnit\Framework\Assert;

use function Safe\class_uses;

uses(TestCase::class);

describe('Post Model', function () {
    test('extends BaseModel', function () {
        $model = new Post();

        Assert::assertInstanceOf(BaseModel::class, $model);
    });

    test('uses HasSlug trait', function () {
        $model = new Post();

        Assert::assertArrayHasKey('Spatie\Sluggable\HasSlug', class_uses($model));
    });

    test('uses HasXotFactory trait', function () {
        $model = new Post();

        Assert::assertArrayHasKey('Modules\Xot\Models\Traits\HasXotFactory', class_uses($model));
    });

    test('uses Updater trait', function () {
        $model = new Post();

        Assert::assertArrayHasKey('Modules\Xot\Traits\Updater', class_uses($model));
    });

    test('has correct connection', function () {
        $model = new Post();

        Assert::assertSame('lang', $model->getConnectionName());
    });

    test('has correct searchable fields', function () {
        Assert::assertSame(['title', 'guid', 'txt'], Post::SEARCHABLE_FIELDS);
    });

    test('has snake attributes enabled', function () {
        Assert::assertTrue(Post::$snakeAttributes);
    });

    test('uses string primary key without auto increment', function () {
        $model = new Post();

        Assert::assertFalse($model->incrementing);
        Assert::assertSame('string', $model->getKeyType());
    });

    test('has default perPage', function () {
        $model = new Post();

        Assert::assertSame(30, $model->getPerPage());
    });

    test('has correct fillable attributes', function () {
        $model = new Post();
        $fillable = $model->getFillable();

        Assert::assertContains('id', $fillable);
        Assert::assertContains('user_id', $fillable);
        Assert::assertContains('post_id', $fillable);
        Assert::assertContains('lang', $fillable);
        Assert::assertContains('title', $fillable);
    });

    test('has getSlugOptions method', function () {
        $model = new Post();

        Assert::assertTrue(is_callable([$model, 'getSlugOptions']));
    });

    test('has linkable relationship', function () {
        $model = new Post();

        Assert::assertTrue(is_callable([$model, 'linkable']));
    });

    test('has toSearchableArray method', function () {
        $model = new Post();

        Assert::assertTrue(is_callable([$model, 'toSearchableArray']));
    });

    test('casts datetime fields', function () {
        $model = new Post();
        $casts = $model->getCasts();

        Assert::assertSame('datetime', $casts['created_at']);
        Assert::assertSame('datetime', $casts['updated_at']);
        Assert::assertSame('datetime', $casts['deleted_at']);
        Assert::assertSame('datetime', $casts['published_at']);
    });

    test('casts array fields', function () {
        $model = new Post();
        $casts = $model->getCasts();

        Assert::assertSame('array', $casts['image_resize_src']);
        Assert::assertSame('array', $casts['url_lang']);
    });
});
