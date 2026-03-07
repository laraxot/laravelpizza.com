<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

uses(TestCase::class);

test('snapshot getConnectionName resolves default connection in testing', function (): void {
    $snapshot = new Snapshot;
    $default = config('database.default');

    expect($snapshot->getConnectionName())->toBe(is_string($default) ? $default : 'mysql');
});

test('snapshot has expected table and fillable fields', function (): void {
    $snapshot = new Snapshot;

    expect($snapshot->getTable())->toBe('snapshots')
        ->and($snapshot->getFillable())->toContain('aggregate_uuid')
        ->and($snapshot->getFillable())->toContain('state');
});

test('stored event constructor aligns connection in testing', function (): void {
    $storedEvent = new StoredEvent;
    $default = config('database.default');

    expect($storedEvent->getConnectionName())->toBe(is_string($default) ? $default : 'mysql');
});

test('stored event has expected casts and metadata behavior', function (): void {
    $storedEvent = new StoredEvent;
    $casts = $storedEvent->getCasts();

    expect($storedEvent->getTable())->toBe('stored_events')
        ->and($casts)->toHaveKey('event_properties')
        ->and($casts['event_properties'])->toBe('array')
        ->and($casts)->toHaveKey('meta_data')
        ->and($casts['meta_data'])->toBe(SchemalessAttributes::class);
});
