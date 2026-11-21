<?php

declare(strict_types=1);
use Modules\Activity\Models\BaseModel;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

<<<<<<< .merge_file_bBnBIp
test('Snapshot model can be instantiated', function () {
    Assert::assertTrue((new ReflectionClass(Snapshot::class))->isInstantiable());
});

test('StoredEvent model can be instantiated', function () {
    Assert::assertTrue((new ReflectionClass(StoredEvent::class))->isInstantiable());
});

test('BaseModel model can be instantiated', function () {
    $baseModel = new class extends BaseModel
=======
test('Snapshot model can be instantiated', function (): void {
    $snapshot = new Snapshot;
    Assert::assertSame('snapshots', $snapshot->getTable());
});

test('BaseModel model can be instantiated', function (): void {
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_tqWgyq
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertSame('activity_base_models', $baseModel->getTable());
});

<<<<<<< .merge_file_bBnBIp
test('Snapshot model has correct connection', function () {
    $snapshot = new Snapshot;
=======
test('Snapshot model has correct connection', function (): void {
    $snapshot = new Snapshot();
>>>>>>> .merge_file_tqWgyq

    Assert::assertIsString($snapshot->getConnectionName());
});

<<<<<<< .merge_file_bBnBIp
test('StoredEvent model has correct connection', function () {
    $storedEvent = new StoredEvent;
=======
test('StoredEvent model has correct connection', function (): void {
    $storedEvent = new StoredEvent();
>>>>>>> .merge_file_tqWgyq

    Assert::assertIsString($storedEvent->getConnectionName());
});

<<<<<<< .merge_file_bBnBIp
test('BaseModel model has correct connection', function () {
    $baseModel = new class extends BaseModel
=======
test('BaseModel model has correct connection', function (): void {
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_tqWgyq
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertIsString($baseModel->getConnectionName());
});
