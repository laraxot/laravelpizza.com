<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Illuminate\Auth\Access\HandlesAuthorization;
use Mockery;
use Mockery\MockInterface;
use Modules\Activity\Models\Policies\ActivityBasePolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

describe('Activity Base Policy', function (): void {
    test('policy is abstract', function (): void {
        $reflection = new \ReflectionClass(ActivityBasePolicy::class);
        Assert::assertTrue($reflection->isAbstract());
    });

    test('policy uses handles authorization trait', function (): void {
        Assert::assertTrue(
            in_array(
                HandlesAuthorization::class,
                class_uses_recursive(ActivityBasePolicy::class)
            )
        );
    });

    test('super admin user always allowed', function (): void {
        // Create a mock super-admin user
        /** @var MockInterface&User $user */
        $user = Mockery::mock(User::class);
        $user->shouldReceive('hasRole')->with('super-admin')->andReturn(true);

        // Test the policy
        $policy = new class extends ActivityBasePolicy
        {
            public function policyBefore(User $user): ?bool
            {
                return $this->before($user);
            }
        };

        $result = $policy->policyBefore($user);
        Assert::assertTrue($result);
    });
});
