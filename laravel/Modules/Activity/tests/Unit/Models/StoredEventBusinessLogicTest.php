<?php

declare(strict_types=1);

uses(\Modules\Activity\Tests\TestCase::class);
use Modules\Activity\Models\StoredEvent;
use Spatie\EventSourcing\StoredEvents\Models\EloquentStoredEvent;

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

    test('stored event has query builder methods documented', function (): void {
        // Verify query builder methods are available through @method annotations in PHPDoc
        // These are provided by Spatie's EloquentStoredEventQueryBuilder:
        // - afterVersion(int $version)
        // - whereAggregateRoot(string $uuid)
        // - whereEvent(string ...$eventClasses)

        $reflection = new \ReflectionClass(StoredEvent::class);
        $docComment = $reflection->getDocComment();

        // Verify @method annotations exist for query builder methods
        expect($docComment)->toContain('@method');
        expect($docComment)->toContain('afterVersion');
        expect($docComment)->toContain('whereAggregateRoot');
        expect($docComment)->toContain('whereEvent');
    });
});
