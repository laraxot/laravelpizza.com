<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\SnapshotPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;

class SnapshotPolicyTest extends TestCase
{
    #[Test]
    public function policy_extends_user_base_policy(): void
    {
        $this->assertTrue(
            is_subclass_of(
                SnapshotPolicy::class,
                \Modules\User\Models\Policies\UserBasePolicy::class
            )
        );
    }

    #[Test]
    public function policy_has_view_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'view'));
    }

    #[Test]
    public function policy_has_create_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'create'));
    }

    #[Test]
    public function policy_has_update_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'update'));
    }

    #[Test]
    public function policy_has_delete_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'delete'));
    }

    #[Test]
    public function policy_has_restore_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'restore'));
    }

    #[Test]
    public function policy_has_force_delete_method(): void
    {
        $this->assertTrue(method_exists(SnapshotPolicy::class, 'forceDelete'));
    }

    #[Test]
    public function user_with_permission_can_view(): void
    {
        // Create a mock user with permission
        $user = $this->createMock(User::class);
        $user->method('hasPermissionTo')->with('snapshot.view')->willReturn(true);

        $policy = new SnapshotPolicy();
        $result = $policy->view($user);

        $this->assertTrue($result);
    }

    #[Test]
    public function user_without_permission_cannot_view(): void
    {
        // Create a mock user without permission
        $user = $this->createMock(User::class);
        $user->method('hasPermissionTo')->with('snapshot.view')->willReturn(false);

        $policy = new SnapshotPolicy();
        $result = $policy->view($user);

        $this->assertFalse($result);
    }

    #[Test]
    public function create_update_delete_restore_force_delete_delegate_to_permissions(): void
    {
        $user = $this->createMock(User::class);
        $user->expects($this->exactly(5))
            ->method('hasPermissionTo')
            ->willReturnMap([
                ['snapshot.create', true],
                ['snapshot.update', true],
                ['snapshot.delete', true],
                ['snapshot.restore', true],
                ['snapshot.forceDelete', true],
            ]);

        $policy = new SnapshotPolicy();

        $this->assertTrue($policy->create($user));
        $this->assertTrue($policy->update($user));
        $this->assertTrue($policy->delete($user));
        $this->assertTrue($policy->restore($user));
        $this->assertTrue($policy->forceDelete($user));
    }
}
