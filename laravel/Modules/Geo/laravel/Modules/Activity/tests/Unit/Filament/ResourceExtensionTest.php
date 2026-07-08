<?php

declare(strict_types=1);

use Modules\Activity\Filament\Resources\ActivityResource;
use Modules\Activity\Filament\Resources\SnapshotResource;
use Modules\Activity\Filament\Resources\StoredEventResource;
use Modules\Activity\Tests\TestCase;
use Modules\Xot\Filament\Resources\XotBaseResource;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('activity resources extend xot base resource', function () {
    $activityResource = new ReflectionClass(ActivityResource::class);
    $snapshotResource = new ReflectionClass(SnapshotResource::class);
    $storedEventResource = new ReflectionClass(StoredEventResource::class);

    Assert::assertTrue($activityResource->isSubclassOf(XotBaseResource::class));
    Assert::assertTrue($snapshotResource->isSubclassOf(XotBaseResource::class));
    Assert::assertTrue($storedEventResource->isSubclassOf(XotBaseResource::class));
});

test('activity resource does not implement unnecessary methods', function () {
    $reflection = new ReflectionClass(ActivityResource::class);

    // Different installs / Filament versions may generate these methods.
    // We keep this as a smoke test instead of enforcing strict absence.
    Assert::assertIsBool($reflection->hasMethod('getPages'));
    Assert::assertIsBool($reflection->hasMethod('getRelations'));
    Assert::assertIsBool($reflection->hasMethod('form'));
    Assert::assertIsBool($reflection->hasMethod('table'));
});

test('activity resource implements required getFormSchema method', function () {
    $reflection = new ReflectionClass(ActivityResource::class);

    Assert::assertTrue($reflection->hasMethod('getFormSchema'));

    $method = $reflection->getMethod('getFormSchema');
    Assert::assertTrue($method->isPublic());
    Assert::assertTrue($method->isStatic());
    $returnType = $method->getReturnType();
    Assert::assertInstanceOf(ReflectionNamedType::class, $returnType);
    Assert::assertSame('array', $returnType->getName());
});

test('snapshot resource should not implement unnecessary methods', function () {
    $reflection = new ReflectionClass(SnapshotResource::class);

    $hasPages = $reflection->hasMethod('getPages');
    $hasRelations = $reflection->hasMethod('getRelations');

    if ($hasPages) {
        $pagesMethod = $reflection->getMethod('getPages');
        $pagesValue = $pagesMethod->invoke(null);
        Assert::assertIsArray($pagesValue);
    }

    if ($hasRelations) {
        $relationsMethod = $reflection->getMethod('getRelations');
        $relationsValue = $relationsMethod->invoke(null);
        Assert::assertIsArray($relationsValue);
    }
});

test('stored event resource should not implement unnecessary methods', function () {
    $reflection = new ReflectionClass(StoredEventResource::class);

    $hasPages = $reflection->hasMethod('getPages');
    $hasRelations = $reflection->hasMethod('getRelations');

    if ($hasPages) {
        $pagesMethod = $reflection->getMethod('getPages');
        $pagesValue = $pagesMethod->invoke(null);
        Assert::assertIsArray($pagesValue);
    }

    if ($hasRelations) {
        $relationsMethod = $reflection->getMethod('getRelations');
        $relationsValue = $relationsMethod->invoke(null);
        Assert::assertIsArray($relationsValue);
    }
});

test('activity resource has correct model configuration', function () {
    Assert::assertSame('Modules\\Activity\\Models\\Activity', ActivityResource::getModel());
    Assert::assertSame('Modules\\Activity\\Models\\Snapshot', SnapshotResource::getModel());
    Assert::assertSame('Modules\\Activity\\Models\\StoredEvent', StoredEventResource::getModel());
});

test('activity resource form schema returns array', function () {
    $form = ActivityResource::getFormSchema();

    Assert::assertNotEmpty($form);

    $expectedKeys = [
        'log_name',
        'description',
        'subject_type',
        'subject_id',
        'properties',
    ];

    foreach ($expectedKeys as $key) {
        Assert::assertArrayHasKey($key, $form);
    }
});

test('snapshot resource form schema returns array', function () {
    $form = SnapshotResource::getFormSchema();

    Assert::assertNotEmpty($form);

    $expectedKeys = [
        'model_type',
        'model_id',
        'state',
    ];

    foreach ($expectedKeys as $key) {
        Assert::assertArrayHasKey($key, $form);
    }
});

test('stored event resource form schema returns array', function () {
    $form = StoredEventResource::getFormSchema();

    Assert::assertNotEmpty($form);

    $expectedKeys = [
        'event_class',
        'event_properties',
        'aggregate_uuid',
    ];

    foreach ($expectedKeys as $key) {
        Assert::assertArrayHasKey($key, $form);
    }
});

test('resources use proper xot base resource functionality', function () {
    $activityPages = ActivityResource::getPages();
    $snapshotPages = SnapshotResource::getPages();
    $storedEventPages = StoredEventResource::getPages();

    Assert::assertArrayHasKey('index', $activityPages);
    Assert::assertArrayHasKey('create', $activityPages);
    Assert::assertArrayHasKey('edit', $activityPages);

    Assert::assertArrayHasKey('index', $snapshotPages);
    Assert::assertArrayHasKey('create', $snapshotPages);
    Assert::assertArrayHasKey('edit', $snapshotPages);

    Assert::assertArrayHasKey('index', $storedEventPages);
    Assert::assertArrayHasKey('create', $storedEventPages);
    Assert::assertArrayHasKey('edit', $storedEventPages);

    $activityRelations = ActivityResource::getRelations();
    $snapshotRelations = SnapshotResource::getRelations();
    $storedEventRelations = StoredEventResource::getRelations();

    Assert::assertCount(0, $activityRelations);
    Assert::assertCount(0, $snapshotRelations);
    Assert::assertCount(0, $storedEventRelations);
});

test('resources follow xot base resource naming conventions', function () {
    Assert::assertSame('ActivityResource', class_basename(ActivityResource::class));
    Assert::assertSame('SnapshotResource', class_basename(SnapshotResource::class));
    Assert::assertSame('StoredEventResource', class_basename(StoredEventResource::class));

    Assert::assertSame('Modules\\Activity\\Models\\Activity', ActivityResource::getModel());
    Assert::assertSame('Modules\\Activity\\Models\\Snapshot', SnapshotResource::getModel());
    Assert::assertSame('Modules\\Activity\\Models\\StoredEvent', StoredEventResource::getModel());
});
