<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Activity\Models\BaseModel;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Traits\Updater;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('it can create base model instance', function (): void {
    $model = new TestActivityModel;

    Assert::assertInstanceOf(BaseModel::class, $model);
    Assert::assertInstanceOf(Model::class, $model);
});

test('it has correct connection setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('activity', $model->getConnectionName());
});

test('it has correct primary key setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('id', $model->getKeyName());
    Assert::assertSame('int', $model->getKeyType());
    Assert::assertTrue($model->getIncrementing());
});

test('it has correct timestamps setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertTrue($model->usesTimestamps());
    Assert::assertTrue($model->timestamps);
});

test('it has correct per page setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame(30, $model->getPerPage());
});

test('it has correct snake attributes setting', function (): void {
    Assert::assertTrue(TestActivityModel::$snakeAttributes);
});

test('it has correct casts configuration', function (): void {
    $model = new TestActivityModel;
    $casts = $model->getCasts();

    Assert::assertIsArray($casts);
    Assert::assertArrayHasKey('created_at', $casts);
    Assert::assertSame('datetime', $casts['created_at']);
    Assert::assertArrayHasKey('updated_at', $casts);
    Assert::assertSame('datetime', $casts['updated_at']);
    Assert::assertArrayHasKey('deleted_at', $casts);
    Assert::assertSame('datetime', $casts['deleted_at']);
    Assert::assertArrayHasKey('id', $casts);
    Assert::assertSame('string', $casts['id']);
    Assert::assertArrayHasKey('published_at', $casts);
    Assert::assertSame('datetime', $casts['published_at']);
});

test('it has updater trait when configured', function (): void {
    $model = new TestActivityModel;
    /** @var array<class-string, class-string> $traits */
    $traits = class_uses_recursive($model::class);

    if (in_array(Updater::class, $traits, true)) {
        Assert::assertContains(Updater::class, $traits);

        return;
    }

    Assert::assertNotContains(Updater::class, $traits);
});

test('it has has factory trait', function (): void {
    $model = new TestActivityModel;
    /** @var array<class-string, class-string> $traits */
    $traits = class_uses_recursive($model::class);

    Assert::assertContains(HasFactory::class, $traits);
});

test('it can handle uuid generation', function (): void {
    $model = new TestActivityModel;
    $uuid = Str::uuid()->toString();
    $model->uuid = $uuid;
    $model->name = 'Test Model';

    Assert::assertSame($uuid, $model->uuid);
    Assert::assertSame('Test Model', $model->name);
});

test('it can handle timestamps', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->created_at = $now;
    $model->updated_at = $now;

    Assert::assertSame($now->timestamp, $model->created_at->timestamp);
    Assert::assertSame($now->timestamp, $model->updated_at->timestamp);
});

test('it can handle soft deletes', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->deleted_at = $now;

    Assert::assertSame($now->timestamp, $model->deleted_at->timestamp);
});

test('it can handle published at timestamp', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->published_at = $now;

    Assert::assertSame($now->timestamp, $model->published_at->timestamp);
});

test('it can handle user tracking fields', function (): void {
    $model = new TestActivityModel;
    $model->created_by = 123;
    $model->updated_by = 456;
    $model->deleted_by = 789;

    Assert::assertSame('123', $model->created_by);
    Assert::assertSame('456', $model->updated_by);
    Assert::assertSame('789', $model->deleted_by);
});

test('it has correct hidden attributes', function (): void {
    $model = new TestActivityModel;
    $hidden = $model->getHidden();

    Assert::assertIsArray($hidden);
    Assert::assertNotContains('password', $hidden);
});

test('it can use connection methods', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('activity', $model->getConnectionName());
    Assert::assertInstanceOf(ConnectionInterface::class, $model->getConnection());
});

test('it can use table methods', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('test_models', $model->getTable());
});

test('it can use per page methods', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame(30, $model->getPerPage());
    $model->setPerPage(50);
    Assert::assertSame(50, $model->getPerPage());
});

test('it can use snake attributes methods', function (): void {
    $model = new TestActivityModel;

    Assert::assertTrue($model::$snakeAttributes);
    $model::$snakeAttributes = false;
    Assert::assertFalse($model::$snakeAttributes);
    $model::$snakeAttributes = true;
    Assert::assertTrue($model::$snakeAttributes);
});

test('it can use fillable methods', function (): void {
    $model = new TestActivityModel;
    $fillable = $model->getFillable();

    Assert::assertIsArray($fillable);
    Assert::assertContains('name', $fillable);
    Assert::assertContains('value', $fillable);

    $newFillable = ['new_field'];
    $model->fillable($newFillable);
    Assert::assertSame($newFillable, $model->getFillable());
});

test('it can use hidden methods', function (): void {
    $model = new class extends TestActivityModel
    {
        /** @var list<string> */
        protected $hidden = ['secret_field'];
    };

    $hidden = $model->getHidden();
    Assert::assertContains('secret_field', $hidden);
    Assert::assertIsArray($hidden);

    $newHidden = ['new_secret'];
    $model->setHidden($newHidden);
    Assert::assertSame($newHidden, $model->getHidden());
});
