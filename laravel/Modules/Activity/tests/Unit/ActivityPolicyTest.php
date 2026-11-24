<?php

declare(strict_types=1);

namespace Modules\Activity\Tests\Unit;

use Modules\Activity\Models\Policies\ActivityPolicy;
use Modules\Activity\Tests\TestCase;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

<<<<<<< HEAD
uses(\Modules\Activity\Tests\TestCase::class);
=======
uses(TestCase::class);
>>>>>>> laraxot/dev

describe('Activity Policy', function (): void {
    test('user with permission can view', function (): void {
        /** @var TestCase $this */
        // Create a mock user with permission
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->willReturn(true);

<<<<<<< HEAD
        $policy = new ActivityPolicy();
=======
        $policy = new ActivityPolicy;
>>>>>>> laraxot/dev
        $result = $policy->view($user);

        Assert::assertTrue($result);
    });

    test('user without permission cannot view', function (): void {
        // Create a mock user without permission
        $user = $this->createUnitMock(User::class);
        $user->method('hasPermissionTo')->willReturn(false);

<<<<<<< HEAD
        $policy = new ActivityPolicy();
=======
        $policy = new ActivityPolicy;
>>>>>>> laraxot/dev
        $result = $policy->view($user);

        Assert::assertFalse($result);
    });
});
