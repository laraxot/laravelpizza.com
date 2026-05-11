<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit\Models;

uses(TestCase::class);

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use Spatie\EventSourcing\Snapshots\EloquentSnapshot;

describe('Snapshot Business Logic', function () {
    test('snapshot has correct connection configured', function () {
        $reflection = new \ReflectionClass(Snapshot::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);

        expect($property->getValue($reflection->newInstanceWithoutConstructor()))->toBe('activity');
    });

    test('snapshot has expected fillable fields for event sourcing', function () {
        $reflection = new \ReflectionClass(Snapshot::class);
        $property = $reflection->getProperty('fillable');
        $property->setAccessible(true);

        $expectedFillable = [
            'id',
            'aggregate_uuid',
            'aggregate_version',
            'state',
            'created_at',
            'updated_at',
        ];

        expect($property->getValue($reflection->newInstanceWithoutConstructor()))->toEqual($expectedFillable);
    });

    test('snapshot extends eloquent snapshot from spatie', function () {
        expect(is_subclass_of(Snapshot::class, EloquentSnapshot::class))->toBeTrue();
    });

    test('snapshot has query builder methods documented', function () {
        $reflection = new \ReflectionClass(Snapshot::class);
        $docComment = $reflection->getDocComment();

        // Verify @method annotations exist for query builder methods
        expect($docComment)->toContain('@method');
        expect($docComment)->toContain('uuid');
        expect($docComment)->toContain('whereAggregateVersion');
    });
});
