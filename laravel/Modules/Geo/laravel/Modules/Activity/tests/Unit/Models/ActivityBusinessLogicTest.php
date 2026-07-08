<?php

declare(strict_types=1);

use Modules\Activity\Models\Activity;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('Activity Business Logic', function () {
    test('activity has correct connection configured', function () {
        $reflection = new ReflectionClass(Activity::class);
        $property = $reflection->getProperty('connection');
        $property->setAccessible(true);

        Assert::assertSame('activity', $property->getValue($reflection->newInstanceWithoutConstructor()));
    });

    test('activity has expected fillable fields', function () {
        $reflection = new ReflectionClass(Activity::class);
        $property = $reflection->getProperty('fillable');
        $property->setAccessible(true);

        $expectedFillable = [
            'id',
            'log_name',
            'description',
            'subject_type',
            'event',
            'subject_id',
            'causer_type',
            'causer_id',
            'properties',
        ];

        Assert::assertEquals($expectedFillable, $property->getValue($reflection->newInstanceWithoutConstructor()));
    });

    test('activity has scope methods documented', function () {
        $reflection = new ReflectionClass(Activity::class);
        $docComment = $reflection->getDocComment();

        Assert::assertStringContainsString('@method', (string) $docComment);
    });
});
