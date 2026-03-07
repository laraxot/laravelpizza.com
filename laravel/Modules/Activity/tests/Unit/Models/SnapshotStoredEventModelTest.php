<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use Spatie\SchemalessAttributes\Casts\SchemalessAttributes;

uses(TestCase::class);

test('snapshot getConnectionName returns a valid string', function (): void {
    $snapshot = new Snapshot();
    $connection = $snapshot->getConnectionName();

    expect($connection)->toBeString()->not->toBeEmpty();
    // In testing env the model redirects to default; otherwise uses 'activity'
    expect($connection)->toBeIn(['mysql', 'activity', config('database.default')]);
});

test('snapshot has expected table and fillable fields', function (): void {
    $snapshot = new Snapshot();

    expect($snapshot->getTable())->toBe('snapshots')
        ->and($snapshot->getFillable())->toContain('aggregate_uuid')
        ->and($snapshot->getFillable())->toContain('state');
});

test('stored event getConnectionName returns a valid string', function (): void {
    $storedEvent = new StoredEvent();
    $connection = $storedEvent->getConnectionName();

    expect($connection)->toBeString()->not->toBeEmpty();
    // In testing env the model redirects to default; otherwise uses 'activity'
    expect($connection)->toBeIn(['mysql', 'activity', config('database.default')]);
});

test('stored event has expected casts and metadata behavior', function (): void {
    $storedEvent = new StoredEvent();
    $casts = $storedEvent->getCasts();

    expect($storedEvent->getTable())->toBe('stored_events')
        ->and($casts)->toHaveKey('event_properties')
        ->and($casts['event_properties'])->toBe('array')
        ->and($casts)->toHaveKey('meta_data')
        ->and($casts['meta_data'])->toBe(SchemalessAttributes::class);
});

