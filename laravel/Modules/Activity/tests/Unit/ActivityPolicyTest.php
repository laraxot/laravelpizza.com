<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Mockery;
use Mockery\MockInterface;
use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(\Modules\Activity\Tests\TestCase::class);

describe('Activity Policy', function (): void {
    test('user with permission can view', function (): void {
        // Create a mock user with permission
        /** @var MockInterface&User $user */
        $user = Mockery::mock(User::class);
        $user->shouldReceive('hasPermissionTo')->with('activity.view')->andReturn(true);

        $policy = new ActivityPolicy();
        $result = $policy->view($user);

        Assert::assertTrue($result);
    });

    test('user without permission cannot view', function (): void {
        // Create a mock user without permission
        /** @var MockInterface&User $user */
        $user = Mockery::mock(User::class);
        $user->shouldReceive('hasPermissionTo')->with('activity.view')->andReturn(false);

        $policy = new ActivityPolicy();
        $result = $policy->view($user);

        Assert::assertFalse($result);
    });
});
