<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\StoredEventPolicy;
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

class StoredEventPolicyTest extends TestCase
{
    #[Test]
    public function policy_extends_user_base_policy(): void
    {
        // @var mixed assertTrue(
            is_subclass_of(
                StoredEventPolicy::class,
                \Modules\User\Models\Policies\UserBasePolicy::class
            )
        );
    }

    #[Test]
    public function user_with_permission_can_view(): void
    {
        $user = // @var mixed createMock(User::class;
        $user->method('hasPermissionTo')->with('stored_event.view')->willReturn(true);

        $policy = new StoredEventPolicy;
        // @var mixed assertTrue($policy->view($user;
    }

    #[Test]
    public function user_without_permission_cannot_view(): void
    {
        $user = // @var mixed createMock(User::class;
        $user->method('hasPermissionTo')->with('stored_event.view')->willReturn(false);

        $policy = new StoredEventPolicy;
        // @var mixed assertFalse($policy->view($user;
    }

    #[Test]
    public function policy_create_update_delete_restore_force_delete_methods_check_permissions(): void
    {
        $permissions = [
            'stored_event.create',
            'stored_event.update',
            'stored_event.delete',
            'stored_event.restore',
            'stored_event.forceDelete',
        ];

        $user = // @var mixed createMock(User::class;
        $user->method('hasPermissionTo')->willReturnCallback(
            static fn (string $permission): bool => in_array($permission, $permissions, true)
        );

        $policy = new StoredEventPolicy;

        // @var mixed assertTrue($policy->create($user;
        // @var mixed assertTrue($policy->update($user;
        // @var mixed assertTrue($policy->delete($user;
        // @var mixed assertTrue($policy->restore($user;
        // @var mixed assertTrue($policy->forceDelete($user;
    }
}
