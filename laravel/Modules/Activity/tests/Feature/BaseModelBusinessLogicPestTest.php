<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Feature;

use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Modules\Activity\Models\BaseModel;
use Modules\Xot\Traits\Updater;

use function Safe\class_uses;

beforeEach(function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->model = new TestActivityModel;
});

test('can create base model instance', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model)->toBeInstanceOf(BaseModel::class);
    /* @phpstan-ignore-next-line property.notFound */
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('has correct connection setting', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getConnectionName())->toBe('activity');
});

test('has correct primary key setting', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getKeyName())->toBe('id');
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getKeyType())->toBe('string');
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getIncrementing())->toBeTrue();
});

test('has correct timestamps setting', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->usesTimestamps())->toBeTrue();
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->timestamps)->toBeTrue();
});

test('has correct per page setting', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getPerPage())->toBe(30);
});

test('has correct snake attributes setting', function (): void {
    expect(TestActivityModel::$snakeAttributes)->toBeTrue();
});

test('has correct casts configuration', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $casts = $this->model->getCasts();

    expect($casts)->toHaveKey('id');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['id'])->toBe('string');

    expect($casts)->toHaveKey('uuid');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['uuid'])->toBe('string');

    expect($casts)->toHaveKey('created_at');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['created_at'])->toBe('datetime');

    expect($casts)->toHaveKey('updated_at');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['updated_at'])->toBe('datetime');

    expect($casts)->toHaveKey('deleted_at');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['deleted_at'])->toBe('datetime');

    expect($casts)->toHaveKey('updated_by');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['updated_by'])->toBe('string');

    expect($casts)->toHaveKey('created_by');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['created_by'])->toBe('string');

    expect($casts)->toHaveKey('deleted_by');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['deleted_by'])->toBe('string');

    expect($casts)->toHaveKey('published_at');
    /* @phpstan-ignore-next-line offsetAccess.nonOffsetAccessible */
    expect($casts['published_at'])->toBe('datetime');
});

test('can use factory', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect(method_exists($this->model, 'factory'))->toBeTrue();
    /* @phpstan-ignore-next-line property.notFound */
    expect(method_exists($this->model, 'newFactory'))->toBeTrue();
});

test('has updater trait', function (): void {
    /** @var TestActivityModel $model */
    /** @phpstan-ignore-next-line property.notFound */
    $model = $this->model;
    $traits = class_uses($model);
    expect($traits)->toContain(Updater::class);
});

test('has has factory trait', function (): void {
    /** @var TestActivityModel $model */
    /** @phpstan-ignore-next-line property.notFound */
    $model = $this->model;
    $traits = class_uses($model);
    expect($traits)->toContain(HasFactory::class);
});

test('can handle uuid generation', function (): void {
    $uuid = Str::uuid()->toString();
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->uuid = $uuid;
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->name = 'Test Model';

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->uuid)->toBe($uuid);
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->name)->toBe('Test Model');
});

test('can handle timestamps', function (): void {
    $now = now();
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->created_at = $now;
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->updated_at = $now;

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->created_at->timestamp)->toBe($now->timestamp);
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->updated_at->timestamp)->toBe($now->timestamp);
});

test('can handle soft deletes', function (): void {
    $now = now();
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->deleted_at = $now;

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->deleted_at->timestamp)->toBe($now->timestamp);
});

test('can handle published at timestamp', function (): void {
    $now = now();
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->published_at = $now;

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->published_at->timestamp)->toBe($now->timestamp);
});

test('can handle created by tracking', function (): void {
    $userId = Str::uuid()->toString();
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->created_by = $userId;
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->updated_by = $userId;
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->deleted_by = $userId;

    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->created_by)->toBe($userId);
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->updated_by)->toBe($userId);
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->deleted_by)->toBe($userId);
});

test('has correct fillable configuration', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $fillable = $this->model->getFillable();
    expect($fillable)->toBeArray();
});

test('can access attributes', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    $this->model->name = 'Test Name';
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->name)->toBe('Test Name');
});

test('has correct table name', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getTable())->toBe('test_models');
});

test('has timestamps enabled', function (): void {
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->usesTimestamps())->toBeTrue();
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->timestamps)->toBeTrue();
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getCreatedAtColumn())->toBe('created_at');
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getUpdatedAtColumn())->toBe('updated_at');
});

test('can get connection', function (): void {
    /** @phpstan-ignore-next-line property.notFound */
    $connection = $this->model->getConnection();
    expect($connection)->toBeInstanceOf(ConnectionInterface::class);
    /* @phpstan-ignore-next-line property.notFound */
    expect($this->model->getConnectionName())->toBe('activity');
});
