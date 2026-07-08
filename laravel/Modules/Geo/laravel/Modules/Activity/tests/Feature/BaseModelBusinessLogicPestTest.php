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
use function Safe\class_uses;

uses(\Modules\Activity\Tests\TestCase::class);

test('can create base model instance', function (): void {
    $model = new TestActivityModel;

    Assert::assertInstanceOf(BaseModel::class, $model);
    Assert::assertInstanceOf(Model::class, $model);
});

test('has correct connection setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('activity', $model->getConnectionName());
});

test('has correct primary key setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('id', $model->getKeyName());
    Assert::assertSame('int', $model->getKeyType());
    Assert::assertTrue($model->getIncrementing());
});

test('has correct timestamps setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertTrue($model->usesTimestamps());
    Assert::assertTrue($model->timestamps);
});

test('has correct per page setting', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame(30, $model->getPerPage());
});

test('has correct snake attributes setting', function (): void {
    Assert::assertTrue(TestActivityModel::$snakeAttributes);
});

test('has correct casts configuration', function (): void {
    $model = new TestActivityModel;
    $casts = $model->getCasts();

    Assert::assertIsArray($casts);
    Assert::assertArrayHasKey('id', $casts);
    Assert::assertSame('string', $casts['id']);

    Assert::assertArrayHasKey('published_at', $casts);
    Assert::assertSame('datetime', $casts['published_at']);
});

test('can use factory', function (): void {
    $factory = TestActivityModel::factory();

    Assert::assertNotNull($factory);
});

test('has updater trait', function (): void {
    $model = new TestActivityModel;
    $traits = class_uses_recursive($model::class);
    Assert::assertContains(Updater::class, $traits);
});

test('has has factory trait', function (): void {
    $model = new TestActivityModel;
    $traits = class_uses_recursive($model::class);
    Assert::assertContains(HasFactory::class, $traits);
});

test('can handle uuid generation', function (): void {
    $model = new TestActivityModel;
    $uuid = Str::uuid()->toString();
    $model->uuid = $uuid;
    $model->name = 'Test Model';

    Assert::assertSame($uuid, $model->uuid);
    Assert::assertSame('Test Model', $model->name);
});

test('can handle timestamps', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->created_at = $now;
    $model->updated_at = $now;

    Assert::assertSame($now->timestamp, $model->created_at->timestamp);
    Assert::assertSame($now->timestamp, $model->updated_at->timestamp);
});

test('can handle soft deletes', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->deleted_at = $now;

    Assert::assertSame($now->timestamp, $model->deleted_at->timestamp);
});

test('can handle published at timestamp', function (): void {
    $model = new TestActivityModel;
    $now = now();
    $model->published_at = $now;

    Assert::assertSame($now->timestamp, $model->published_at->timestamp);
});

test('can handle created by tracking', function (): void {
    $model = new TestActivityModel;
    $userId = 42;
    $model->created_by = $userId;
    $model->updated_by = $userId;
    $model->deleted_by = $userId;

    Assert::assertSame((string) $userId, $model->created_by);
    Assert::assertSame((string) $userId, $model->updated_by);
    Assert::assertSame((string) $userId, $model->deleted_by);
});

test('has correct fillable configuration', function (): void {
    $model = new TestActivityModel;
    $fillable = $model->getFillable();
    Assert::assertIsArray($fillable);
});

test('has correct table name', function (): void {
    $model = new TestActivityModel;
    Assert::assertSame('test_models', $model->getTable());
});

test('has timestamps enabled', function (): void {
    $model = new TestActivityModel;
    Assert::assertTrue($model->usesTimestamps());
    Assert::assertTrue($model->timestamps);
    Assert::assertSame('created_at', $model->getCreatedAtColumn());
    Assert::assertSame('updated_at', $model->getUpdatedAtColumn());
});

test('can get connection', function (): void {
    $model = new TestActivityModel;
    $connection = $model->getConnection();
    Assert::assertInstanceOf(ConnectionInterface::class, $connection);
    Assert::assertSame('activity', $model->getConnectionName());
});
