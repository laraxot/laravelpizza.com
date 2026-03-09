<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\Snapshot;

test('Snapshot model can be instantiated', function () {
    $reflection = new \ReflectionClass(Snapshot::class);
    $snapshot = $reflection->newInstanceWithoutConstructor();

    expect($snapshot)->toBeObject();
    // Verifichiamo che estenda il modello corretto da Spatie
    expect($snapshot)->toBeInstanceOf(\Spatie\EventSourcing\Snapshots\EloquentSnapshot::class);
});

test('Snapshot model has correct connection', function () {
    $reflection = new \ReflectionClass(Snapshot::class);
    $snapshot = $reflection->newInstanceWithoutConstructor();

    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($snapshot))->toBe('activity');
});
