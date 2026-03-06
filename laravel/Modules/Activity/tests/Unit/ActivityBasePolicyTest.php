<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\ActivityBasePolicy;
<<<<<<< HEAD
use Modules\Activity\Tests\TestCase;
=======
use PHPUnit\Framework\TestCase;
>>>>>>> a21dc33d (.)
use Modules\User\Models\User;
use PHPUnit\Framework\Attributes\Test;

class ActivityBasePolicyTest extends TestCase
{
<<<<<<< HEAD
    use \Illuminate\Foundation\Testing\DatabaseTransactions;
=======
>>>>>>> a21dc33d (.)

    #[Test]
    public function policy_is_abstract(): void
    {
        $reflection = new \ReflectionClass(ActivityBasePolicy::class);
        $this->assertTrue($reflection->isAbstract());
    }

    #[Test]
    public function policy_uses_handles_authorization_trait(): void
    {
        $this->assertTrue(
            in_array(
                \Illuminate\Auth\Access\HandlesAuthorization::class,
                class_uses_recursive(ActivityBasePolicy::class)
            )
        );
    }

    #[Test]
    public function policy_has_before_method(): void
    {
        $this->assertTrue(method_exists(ActivityBasePolicy::class, 'before'));
    }

    #[Test]
    public function super_admin_user_always_allowed(): void
    {
        // Create a mock super-admin user
        $user = $this->createMock(User::class);
        $user->method('hasRole')->with('super-admin')->willReturn(true);

        // Test the policy
        $policy = new class extends ActivityBasePolicy {
            public function testBefore(User $user): ?bool
            {
                return $this->before($user);
            }
        };

        $result = $policy->testBefore($user);
        $this->assertTrue($result);
    }
<<<<<<< HEAD
=======

    #[Test]
    public function non_super_admin_returns_null_in_before(): void
    {
        $user = $this->createMock(User::class);
        $user->method('hasRole')->with('super-admin')->willReturn(false);

        $policy = new class extends ActivityBasePolicy {
            public function testBefore(User $user): ?bool
            {
                return $this->before($user);
            }
        };

        $result = $policy->testBefore($user);
        $this->assertNull($result);
    }
>>>>>>> a21dc33d (.)
}
