<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

uses(\Modules\Activity\Tests\TestCase::class);

test('snapshot getConnectionName resolves activity connection', function (): void {
    $snapshot = new Snapshot;

    Assert::assertSame('activity', $snapshot->getConnectionName());
});

test('snapshot has expected table and fillable fields', function (): void {
    $snapshot = new Snapshot;

    Assert::assertSame('snapshots', $snapshot->getTable());
    $fillable = $snapshot->getFillable();
    Assert::assertContains('aggregate_uuid', $fillable);
    Assert::assertContains('state', $fillable);
});

test('stored event constructor aligns activity connection', function (): void {
    $storedEvent = new StoredEvent;

    Assert::assertSame('activity', $storedEvent->getConnectionName());
});

test('stored event has expected casts and metadata behavior', function (): void {
    $storedEvent = new StoredEvent;
    $casts = $storedEvent->getCasts();

    Assert::assertArrayHasKey('event_properties', $casts);
    Assert::assertSame('array', $casts['event_properties']);
    Assert::assertArrayHasKey('meta_data', $casts);
    Assert::assertSame(SchemalessAttributes::class, $casts['meta_data']);
});
