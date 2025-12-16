<?php

declare(strict_types=1);
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Modules\Activity\Models\StoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

use function Safe\class_uses;

describe('StoredEvent Business Logic', function (): void {
    test('stored event has correct connection configured', function (): void {
        $storedEvent = new StoredEvent;

        expect($storedEvent->getConnectionName())->toBe('activity');
    });

    test('stored event has correct table configured', function (): void {
        $storedEvent = new StoredEvent;

        expect($storedEvent->getTable())->toBe('stored_events');
    });

    test('stored event has expected fillable fields for event sourcing', function (): void {
        $storedEvent = new StoredEvent;
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

    test('stored event has after version scope method', function (): void {
        expect(method_exists(StoredEvent::class, 'scopeAfterVersion'))->toBeTrue();
    });

    test('stored event has where aggregate root scope method', function (): void {
        expect(method_exists(StoredEvent::class, 'scopeWhereAggregateRoot'))->toBeTrue();
    });

    test('stored event has where event scope method', function (): void {
        expect(method_exists(StoredEvent::class, 'scopeWhereEvent'))->toBeTrue();
    });
});
