<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\SnapshotPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\Policies\UserBasePolicy;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Snapshot Policy', function (): void {
    test('policy extends user base policy', function (): void {
        Assert::assertTrue((new \ReflectionClass(SnapshotPolicy::class))->isSubclassOf(UserBasePolicy::class));
    });

    test('policy has expected public methods', function (): void {
        $reflection = new \ReflectionClass(SnapshotPolicy::class);
        $expectedMethods = ['view', 'create', 'update', 'delete', 'restore', 'forceDelete'];

        foreach ($expectedMethods as $method) {
            Assert::assertTrue($reflection->hasMethod($method), "Missing method: {$method}");
        }
    });

    test('user with permission can view', function (): void {
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->willReturn(true);

        $policy = new SnapshotPolicy;
        $result = $policy->view($user);

        Assert::assertTrue($result);
    });

    test('user without permission cannot view', function (): void {
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->willReturn(false);

        $policy = new SnapshotPolicy;
        $result = $policy->view($user);

        Assert::assertFalse($result);
    });
});
