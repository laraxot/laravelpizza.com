<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Models\StoredEvent;

test('Snapshot model can be instantiated', function () {
    $snapshot = new Snapshot;

    expect($snapshot)->toBeInstanceOf(Snapshot::class);
});

test('StoredEvent model can be instantiated', function () {
    $storedEvent = new StoredEvent;

    expect($storedEvent)->toBeInstanceOf(StoredEvent::class);
});

test('Snapshot model has correct connection', function () {
    $snapshot = new Snapshot;

    expect($snapshot->getConnectionName())->toBeString();
});

test('StoredEvent model has correct connection', function () {
    $storedEvent = new StoredEvent;

    expect($storedEvent->getConnectionName())->toBeString();
});

 
