<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

describe('Activity Policy', function (): void {
    test('user with permission can view', function (): void {
        /** @var \Modules\Activity\Tests\TestCase $this */
// Create a mock user with permission
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->with('activity.view')->willReturn(true);

        $policy = new ActivityPolicy;
        $result = $policy->view($user);

        Assert::assertTrue($result);
    });

    test('user without permission cannot view', function (): void {
// Create a mock user without permission
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->with('activity.view')->willReturn(false);

        $policy = new ActivityPolicy;
        $result = $policy->view($user);

        Assert::assertFalse($result);
    });
});
