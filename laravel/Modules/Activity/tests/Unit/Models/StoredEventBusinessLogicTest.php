<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Activity\Models\StoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Safe\class_uses;

describe('StoredEvent Business Logic', function (): void {
    test('stored event has correct connection configured', function (): void {
        $storedEvent = new StoredEvent();

        expect($storedEvent->getConnectionName())->toBe('activity');
    });

    test('stored event has correct table configured', function (): void {
        $storedEvent = new StoredEvent();

        expect($storedEvent->getTable())->toBe('stored_events');
    });

    test('stored event has expected fillable fields for event sourcing', function (): void {
        $storedEvent = new StoredEvent();
        $expectedFillable = [
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

        expect($storedEvent->getFillable())->toEqual($expectedFillable);
    });

    test('stored event extends eloquent stored event for event sourcing', function (): void {
        // @phpstan-ignore-next-line - is_subclass_of with class strings is always true for existing inheritance
        expect(is_subclass_of(
            StoredEvent::class,
            EloquentStoredEvent::class,
        ))->toBeTrue();
    });

    test('stored event has factory trait for testing', function (): void {
        $traits = class_uses(StoredEvent::class);

        expect($traits)->toHaveKey(HasFactory::class);
    });

    test('stored event can query after specific version', function (): void {
        StoredEvent::factory()->create(['aggregate_version' => 1, 'aggregate_uuid' => 'test-1']);
        StoredEvent::factory()->create(['aggregate_version' => 2, 'aggregate_uuid' => 'test-2']);
        StoredEvent::factory()->create(['aggregate_version' => 3, 'aggregate_uuid' => 'test-3']);

        $results = StoredEvent::afterVersion(1)->get();

        expect($results->count())->toBeGreaterThanOrEqual(2);
        expect($results->where('aggregate_version', '>', 1)->count())->toBe($results->count());
    });

    test('stored event can query by aggregate root uuid', function (): void {
        $uuid = 'test-uuid-'.uniqid();

        StoredEvent::factory()->create(['aggregate_uuid' => $uuid]);
        StoredEvent::factory()->create(['aggregate_uuid' => 'other-uuid-'.uniqid()]);

        $results = StoredEvent::whereAggregateRoot($uuid)->get();

        expect($results->count())->toBeGreaterThanOrEqual(1);
        expect($results->first()->aggregate_uuid)->toBe($uuid);
    });

    test('stored event can query by event class', function (): void {
        $eventClass = 'App\\Events\\TestEvent'.uniqid();

        StoredEvent::factory()->create(['event_class' => $eventClass]);
        StoredEvent::factory()->create(['event_class' => 'App\\Events\\OtherEvent'.uniqid()]);

        $results = StoredEvent::whereEvent($eventClass)->get();

        expect($results->count())->toBeGreaterThanOrEqual(1);
        expect($results->first()->event_class)->toBe($eventClass);
    });
});
