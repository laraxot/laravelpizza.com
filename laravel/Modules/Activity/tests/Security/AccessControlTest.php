<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Security;

/**
 * Security Test Case for Activity Module Access Control
 *
 * Tests authentication and authorization mechanisms for activity tracking
 * and audit trail functionality.
 */

use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

it('denies activity viewAny to users without permission', function (): void {
    $user = activityCreateUser();
    $policy = new ActivityPolicy;

    Assert::assertFalse($policy->viewAny($user));
});

it('allows activity viewAny to users with the correct permission', function (): void {
    $user = activityCreateUser();
    $user->givePermissionTo('activity.viewAny');
    $policy = new ActivityPolicy;

    Assert::assertTrue($policy->viewAny($user));
});

it('denies activity view to users without permission', function (): void {
    $user = activityCreateUser();
    $policy = new ActivityPolicy;

    Assert::assertFalse($policy->view($user));
});

it('super-admin bypasses activity policy checks via before()', function (): void {
    $superAdmin = activityCreateUser();
    $superAdmin->assignRole('super-admin');
    $policy = new ActivityPolicy;

    Assert::assertTrue($policy->viewAny($superAdmin));
    Assert::assertTrue($policy->view($superAdmin));
});

it('validates activity log data integrity', function (): void {
    $activity = activityCreateActivity([
        'description' => 'Valid description',
    ]);

    $activity->description = 'Tampered description';
    Assert::assertSame('Valid description', $activity->fresh()?->description);
});
