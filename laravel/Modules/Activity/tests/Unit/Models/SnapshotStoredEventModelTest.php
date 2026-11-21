<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

uses(TestCase::class);

test('snapshot getConnectionName resolves the default connection in testing', function (): void {
    $snapshot = new Snapshot;

    // In testing i modelli event-sourcing usano la connessione di default
    // (la 'activity' non esiste in config/database.php di test).
    Assert::assertSame(config('database.default'), $snapshot->getConnectionName());
});

test('snapshot has expected table and fillable fields', function (): void {
    $snapshot = new Snapshot;

    Assert::assertSame('snapshots', $snapshot->getTable());
    $fillable = $snapshot->getFillable();
    Assert::assertContains('aggregate_uuid', $fillable);
    Assert::assertContains('state', $fillable);
});

test('stored event constructor aligns the default connection in testing', function (): void {
    $storedEvent = new StoredEvent;

    Assert::assertSame(config('database.default'), $storedEvent->getConnectionName());
});

test('stored event has expected casts and metadata behavior', function (): void {
    $storedEvent = new StoredEvent;
    $casts = $storedEvent->getCasts();

    Assert::assertArrayHasKey('event_properties', $casts);
    Assert::assertSame('array', $casts['event_properties']);
    Assert::assertArrayHasKey('meta_data', $casts);
    Assert::assertSame(SchemalessAttributes::class, $casts['meta_data']);
});
