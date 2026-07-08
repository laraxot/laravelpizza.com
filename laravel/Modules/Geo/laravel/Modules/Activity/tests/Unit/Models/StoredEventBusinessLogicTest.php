<?php

declare(strict_types=1);

use Modules\Activity\Models\StoredEvent;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('StoredEvent Business Logic', function (): void {
    test('stored event has correct connection configured', function (): void {
        $storedEvent = new StoredEvent;

        Assert::assertSame('activity', $storedEvent->getConnectionName());
    });

    test('stored event has correct table configured', function (): void {
        $storedEvent = new StoredEvent;

        Assert::assertSame('stored_events', $storedEvent->getTable());
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

        Assert::assertEquals($expectedFillable, $storedEvent->getFillable());
    });

    test('stored event has query builder methods documented', function (): void {
        $reflection = new ReflectionClass(StoredEvent::class);
        $docComment = $reflection->getDocComment();

        Assert::assertStringContainsString('@method', (string) $docComment);
        Assert::assertStringContainsString('afterVersion', (string) $docComment);
        Assert::assertStringContainsString('whereAggregateRoot', (string) $docComment);
        Assert::assertStringContainsString('whereEvent', (string) $docComment);
    });
});
