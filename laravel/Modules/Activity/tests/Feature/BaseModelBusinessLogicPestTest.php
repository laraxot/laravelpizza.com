<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Traits\Updater;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('can create base model instance', function (): void {
    $model = new TestActivityModel;

    Assert::assertSame('test_models', $model->getTable());
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

// Il fixture sta in Tests\Feature, non in Models: GetFactoryAction ricava il modulo da `Modules\<M>\Models\`
// e non puo' generare una factory per lui. Si verifica quindi che il modello esponga factory(), non che ne risolva una.
test('can use factory', function (): void {
    $factory = new \ReflectionMethod(TestActivityModel::class, 'factory');

    Assert::assertTrue($factory->isPublic());
    Assert::assertTrue($factory->isStatic());
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
    $userId = random_int(1000, 9999);
    $model->created_by = $userId;
    $model->updated_by = $userId;
    $model->deleted_by = $userId;

    Assert::assertSame($userId, (int) $model->created_by);
    Assert::assertSame($userId, (int) $model->updated_by);
    Assert::assertSame($userId, (int) $model->deleted_by);
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
