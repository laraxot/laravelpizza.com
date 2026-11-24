<?php

declare(strict_types=1);
use Modules\Activity\Models\BaseModel;
use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Snapshot model can be instantiated', function (): void {
    $snapshot = new Snapshot;
    Assert::assertSame('snapshots', $snapshot->getTable());
});

test('BaseModel model can be instantiated', function (): void {
<<<<<<< .merge_file_h7ssOe
<<<<<<< .merge_file_nRWDdA
    $baseModel = new class extends BaseModel
=======
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_RN4ZGC
=======
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_XGc7sZ
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertSame('activity_base_models', $baseModel->getTable());
});

test('Snapshot model has correct connection', function (): void {
<<<<<<< .merge_file_h7ssOe
<<<<<<< .merge_file_nRWDdA
    $snapshot = new Snapshot;
=======
    $snapshot = new Snapshot();
>>>>>>> .merge_file_RN4ZGC
=======
    $snapshot = new Snapshot();
>>>>>>> .merge_file_XGc7sZ

    Assert::assertIsString($snapshot->getConnectionName());
});

test('StoredEvent model has correct connection', function (): void {
<<<<<<< .merge_file_h7ssOe
<<<<<<< .merge_file_nRWDdA
    $storedEvent = new StoredEvent;
=======
    $storedEvent = new StoredEvent();
>>>>>>> .merge_file_RN4ZGC
=======
    $storedEvent = new StoredEvent();
>>>>>>> .merge_file_XGc7sZ

    Assert::assertIsString($storedEvent->getConnectionName());
});

test('BaseModel model has correct connection', function (): void {
<<<<<<< .merge_file_h7ssOe
<<<<<<< .merge_file_nRWDdA
    $baseModel = new class extends BaseModel
=======
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_RN4ZGC
=======
    $baseModel = new class() extends BaseModel
>>>>>>> .merge_file_XGc7sZ
    {
        protected $table = 'activity_base_models';
    };

    Assert::assertIsString($baseModel->getConnectionName());
});
