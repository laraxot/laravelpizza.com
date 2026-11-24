<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Models\Traits\HasXotFactory;
use PHPUnit\Framework\Assert;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEventQueryBuilder;

use function Safe\class_uses;

uses(TestCase::class);

test('stored event uses the default connection in testing and the stored_events table', function (): void {
    $storedEvent = new StoredEvent;

    Assert::assertSame(config('database.default'), $storedEvent->getConnectionName());
    Assert::assertSame('stored_events', $storedEvent->getTable());
});

test('stored event exposes the event sourcing fillable attributes', function (): void {
    $expected = [
        'id',
        'aggregate_uuid',
        'aggregate_version',
        'event_version',
        'event_class',
        'event_properties',
        'meta_data',
        'created_at',
        'updated_by',
        'created_by',
    ];

    Assert::assertSame($expected, (new StoredEvent)->getFillable());
});

test('stored event uses the Xot factory trait', function (): void {
    Assert::assertArrayHasKey(HasXotFactory::class, class_uses(StoredEvent::class));
});

test('stored event exposes the event sourcing query builder', function (): void {
    Assert::assertInstanceOf(EloquentStoredEventQueryBuilder::class, StoredEvent::query());
});
