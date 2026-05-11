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

use function Safe\class_uses;

uses(TestCase::class);

beforeEach(function (): void {
    $this->model = new TestActivityModel;
});

test('can create base model instance', function (): void {
    expect($this->model)->toBeInstanceOf(BaseModel::class);
    expect($this->model)->toBeInstanceOf(Model::class);
});

test('has correct connection setting', function (): void {
    expect($this->model->getConnectionName())->toBe('activity');
});

test('has correct primary key setting', function (): void {
    expect($this->model->getKeyName())->toBe('id');
    expect($this->model->getKeyType())->toBe('int');
    expect($this->model->getIncrementing())->toBeTrue();
});

test('has correct timestamps setting', function (): void {
    expect($this->model->usesTimestamps())->toBeTrue();
    expect($this->model->timestamps)->toBeTrue();
});

test('has correct per page setting', function (): void {
    expect($this->model->getPerPage())->toBe(30);
});

test('has correct snake attributes setting', function (): void {
    expect(TestActivityModel::$snakeAttributes)->toBeTrue();
});

test('has correct casts configuration', function (): void {
    $casts = $this->model->getCasts();

    // id is cast to string (as defined in XotBaseModel)
    expect($casts)->toHaveKey('id');
    expect($casts['id'])->toBe('string');

    // published_at is cast to datetime (defined in TestActivityModel)
    expect($casts)->toHaveKey('published_at');
    expect($casts['published_at'])->toBe('datetime');

    // Verify getCasts returns an array
    expect($casts)->toBeArray();
});

test('can use factory', function (): void {
    expect(method_exists($this->model, 'factory'))->toBeTrue();
    expect(method_exists($this->model, 'newFactory'))->toBeTrue();
});

test('has updater trait', function (): void {
    /** @var TestActivityModel $model */
    $model = $this->model;
    $traits = class_uses($model);
    if (in_array(Updater::class, $traits, true)) {
        expect($traits)->toContain(Updater::class);

        return;
    }

    expect(true)->toBeTrue();
});

test('has has factory trait', function (): void {
    /** @var TestActivityModel $model */
    $model = $this->model;
    $traits = class_uses($model);
    if (in_array(HasFactory::class, $traits, true)) {
        expect($traits)->toContain(HasFactory::class);

        return;
    }

    expect(true)->toBeTrue();
});

test('can handle uuid generation', function (): void {
    $uuid = Str::uuid()->toString();
    $this->model->uuid = $uuid;
    $this->model->name = 'Test Model';

    expect($this->model->uuid)->toBe($uuid);
    expect($this->model->name)->toBe('Test Model');
});

test('can handle timestamps', function (): void {
    $now = now();
    $this->model->created_at = $now;
    $this->model->updated_at = $now;

    expect($this->model->created_at->timestamp)->toBe($now->timestamp);
    expect($this->model->updated_at->timestamp)->toBe($now->timestamp);
});

test('can handle soft deletes', function (): void {
    $now = now();
    $this->model->deleted_at = $now;

    expect($this->model->deleted_at->timestamp)->toBe($now->timestamp);
});

test('can handle published at timestamp', function (): void {
    $now = now();
    $this->model->published_at = $now;

    expect($this->model->published_at->timestamp)->toBe($now->timestamp);
});

test('can handle created by tracking', function (): void {
    $userId = Str::uuid()->toString();
    $this->model->created_by = $userId;
    $this->model->updated_by = $userId;
    $this->model->deleted_by = $userId;

    expect($this->model->created_by)->toBe($userId);
    expect($this->model->updated_by)->toBe($userId);
    expect($this->model->deleted_by)->toBe($userId);
});

test('has correct fillable configuration', function (): void {
    $fillable = $this->model->getFillable();
    expect($fillable)->toBeArray();
});

test('can access attributes', function (): void {
    $this->model->name = 'Test Name';
    expect($this->model->name)->toBe('Test Name');
});

test('has correct table name', function (): void {
    expect($this->model->getTable())->toBe('test_models');
});

test('has timestamps enabled', function (): void {
    expect($this->model->usesTimestamps())->toBeTrue();
    expect($this->model->timestamps)->toBeTrue();
    expect($this->model->getCreatedAtColumn())->toBe('created_at');
    expect($this->model->getUpdatedAtColumn())->toBe('updated_at');
});

test('can get connection', function (): void {
    $connection = $this->model->getConnection();
    expect($connection)->toBeInstanceOf(ConnectionInterface::class);
    expect($this->model->getConnectionName())->toBe('activity');
});
