<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

uses(\Modules\Activity\Tests\TestCase::class);

use Modules\Activity\Models\StoredEvent;

test('StoredEvent model can be instantiated', function () {
    $reflection = new \ReflectionClass(StoredEvent::class);
    $storedEvent = $reflection->newInstanceWithoutConstructor();

    expect($storedEvent)->toBeObject();
    // Verifichiamo che estenda il modello corretto da Spatie
    expect($storedEvent)->toBeInstanceOf(\Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent::class);
});

test('StoredEvent model has correct connection', function () {
    $reflection = new \ReflectionClass(StoredEvent::class);
    $storedEvent = $reflection->newInstanceWithoutConstructor();

    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    expect($property->getValue($storedEvent))->toBe('activity');
});
