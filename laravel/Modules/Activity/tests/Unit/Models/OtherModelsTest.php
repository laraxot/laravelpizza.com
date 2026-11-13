<?php

declare(strict_types=1);
use Modules\Activity\Models\BaseModel;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

test('Snapshot model can be instantiated', function () {
<<<<<<< .merge_file_qJZkId
    $snapshot = new Snapshot();

    Assert::assertInstanceOf(Snapshot::class, $snapshot);
});

test('StoredEvent model can be instantiated', function () {
    $storedEvent = new StoredEvent();

    Assert::assertInstanceOf(StoredEvent::class, $storedEvent);
=======
    Assert::assertTrue((new ReflectionClass(Snapshot::class))->isInstantiable());
});

test('StoredEvent model can be instantiated', function () {
    Assert::assertTrue((new ReflectionClass(StoredEvent::class))->isInstantiable());
>>>>>>> .merge_file_vm1ZBF
});

test('BaseModel model can be instantiated', function () {
    $baseModel = new class() extends BaseModel
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertSame('activity_base_models', $baseModel->getTable());
});

test('Snapshot model has correct connection', function () {
    $snapshot = new Snapshot();

    Assert::assertIsString($snapshot->getConnectionName());
});

test('StoredEvent model has correct connection', function () {
    $storedEvent = new StoredEvent();

    Assert::assertIsString($storedEvent->getConnectionName());
});

test('BaseModel model has correct connection', function () {
    $baseModel = new class() extends BaseModel
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertIsString($baseModel->getConnectionName());
});
