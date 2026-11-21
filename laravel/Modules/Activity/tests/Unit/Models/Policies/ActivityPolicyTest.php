<?php

declare(strict_types=1);

use Modules\Activity\Models\Policies\ActivityBasePolicy;
use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Models\Policies\SnapshotPolicy;
use Modules\Activity\Models\Policies\StoredEventPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\Policies\UserBasePolicy;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

test('ActivityPolicy can be instantiated', function () {
    $reflection = new ReflectionClass(ActivityPolicy::class);
    Assert::assertTrue($reflection->isInstantiable());
    Assert::assertTrue($reflection->isSubclassOf(UserBasePolicy::class));
});

test('ActivityBasePolicy is an abstract class', function () {
    $reflection = new ReflectionClass(ActivityBasePolicy::class);

    Assert::assertTrue($reflection->isAbstract());
});

test('SnapshotPolicy can be instantiated', function () {
    $reflection = new ReflectionClass(SnapshotPolicy::class);
    Assert::assertTrue($reflection->isInstantiable());
    Assert::assertTrue($reflection->isSubclassOf(UserBasePolicy::class));
});

test('StoredEventPolicy can be instantiated', function () {
    $reflection = new ReflectionClass(StoredEventPolicy::class);
    Assert::assertTrue($reflection->isInstantiable());
    Assert::assertTrue($reflection->isSubclassOf(UserBasePolicy::class));
});

test('ActivityPolicy method signatures', function () {
    $policy = new ActivityPolicy;
    $reflection = new ReflectionClass($policy);
    $expectedMethods = ['view', 'create', 'update', 'delete', 'restore', 'forceDelete'];

    foreach ($expectedMethods as $methodName) {
        Assert::assertTrue($reflection->hasMethod($methodName), "Missing method: {$methodName}");
        $method = $reflection->getMethod($methodName);
        Assert::assertCount(1, $method->getParameters());
    }
});
