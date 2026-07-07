<?php

declare(strict_types=1);

use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

uses(TestCase::class);

test('StoredEvent model can be instantiated', function () {
    $reflection = new ReflectionClass(StoredEvent::class);
    $storedEvent = $reflection->newInstanceWithoutConstructor();

    Assert::assertIsObject($storedEvent);
    // Verifichiamo che estenda il modello corretto da Spatie
    Assert::assertInstanceOf(EloquentStoredEvent::class, $storedEvent);
});

test('StoredEvent model has correct connection', function () {
    $reflection = new ReflectionClass(StoredEvent::class);
    $storedEvent = $reflection->newInstanceWithoutConstructor();

    $property = $reflection->getProperty('connection');
    $property->setAccessible(true);

    Assert::assertSame('activity', $property->getValue($storedEvent));
});
