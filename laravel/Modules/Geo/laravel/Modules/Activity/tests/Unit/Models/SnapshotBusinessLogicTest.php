<?php

declare(strict_types=1);

use Modules\Activity\Models\Snapshot;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Snapshot Business Logic', function () {
    test('snapshot has correct connection configured', function () {
        $reflection = new ReflectionClass(Snapshot::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);

        Assert::assertSame('activity', $property->getValue($reflection->newInstanceWithoutConstructor()));
    });

    test('snapshot has expected fillable fields for event sourcing', function () {
        $reflection = new ReflectionClass(Snapshot::class);
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

        Assert::assertEquals($expectedFillable, $property->getValue($reflection->newInstanceWithoutConstructor()));
    });

    test('snapshot has query builder methods documented', function () {
        $reflection = new ReflectionClass(Snapshot::class);
        $docComment = $reflection->getDocComment();

        Assert::assertStringContainsString('@method', (string) $docComment);
        Assert::assertStringContainsString('uuid', (string) $docComment);
        Assert::assertStringContainsString('whereAggregateVersion', (string) $docComment);
    });
});
