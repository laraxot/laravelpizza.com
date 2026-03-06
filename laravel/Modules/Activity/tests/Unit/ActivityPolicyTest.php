<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\ActivityPolicy;
<<<<<<< HEAD
use Modules\Activity\Tests\TestCase;
=======
use PHPUnit\Framework\TestCase;
>>>>>>> a21dc33d (.)
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;

class ActivityPolicyTest extends TestCase
{
<<<<<<< HEAD
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
=======
>>>>>>> a21dc33d (.)

    #[Test]
    public function policy_extends_user_base_policy(): void
    {
        $this->assertTrue(
            is_subclass_of(
                ActivityPolicy::class,
                \Modules\User\Models\Policies\UserBasePolicy::class
            )
        );
    }

    #[Test]
    public function policy_has_view_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'view'));
    }

    #[Test]
    public function policy_has_create_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'create'));
    }

    #[Test]
    public function policy_has_update_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'update'));
    }

    #[Test]
    public function policy_has_delete_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'delete'));
    }

    #[Test]
    public function policy_has_restore_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'restore'));
    }

    #[Test]
    public function policy_has_force_delete_method(): void
    {
        $this->assertTrue(method_exists(ActivityPolicy::class, 'forceDelete'));
    }

    #[Test]
    public function user_with_permission_can_view(): void
    {
        // Create a mock user with permission
        $user = $this->createMock(User::class);
        $user->method('hasPermissionTo')->with('activity.view')->willReturn(true);

        $policy = new ActivityPolicy();
        $result = $policy->view($user);

        $this->assertTrue($result);
    }

    #[Test]
    public function user_without_permission_cannot_view(): void
    {
        // Create a mock user without permission
        $user = $this->createMock(User::class);
        $user->method('hasPermissionTo')->with('activity.view')->willReturn(false);

        $policy = new ActivityPolicy();
        $result = $policy->view($user);

        $this->assertFalse($result);
    }
<<<<<<< HEAD
=======

    #[Test]
    public function create_update_delete_restore_force_delete_delegate_to_permissions(): void
    {
        $user = $this->createMock(User::class);
        $user->expects($this->exactly(5))
            ->method('hasPermissionTo')
            ->willReturnMap([
                ['activity.create', true],
                ['activity.update', true],
                ['activity.delete', true],
                ['activity.restore', true],
                ['activity.forceDelete', true],
            ]);

        $policy = new ActivityPolicy();

        $this->assertTrue($policy->create($user));
        $this->assertTrue($policy->update($user));
        $this->assertTrue($policy->delete($user));
        $this->assertTrue($policy->restore($user));
        $this->assertTrue($policy->forceDelete($user));
    }
>>>>>>> a21dc33d (.)
}
