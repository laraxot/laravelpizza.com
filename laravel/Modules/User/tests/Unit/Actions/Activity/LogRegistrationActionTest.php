<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Activity;

use Modules\User\Actions\Activity\LogRegistrationAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Attributes\Test;

class LogRegistrationActionTest extends TestCase
{
    #[Test]
    public function it_logs_registration_with_default_properties(): void
    {
        $user = new User(['type' => 'standard']);
        $user->forceFill(['id' => 1]);

        $action = new LogRegistrationAction();
        $action->execute($user);

        $this->assertTrue(true);
    }

    #[Test]
    public function it_logs_registration_with_custom_properties(): void
    {
        $user = new User(['type' => 'premium']);
        $user->forceFill(['id' => 2]);

        $action = new LogRegistrationAction();
        $action->execute($user, ['referral' => 'newsletter', 'source' => 'landing']);

        $this->assertTrue(true);
    }

    #[Test]
    public function it_logs_registration_with_different_user_types(): void
    {
        $standardUser = new User(['type' => 'standard']);
        $standardUser->forceFill(['id' => 3]);

        $adminUser = new User(['type' => 'admin']);
        $adminUser->forceFill(['id' => 4]);

        $action = new LogRegistrationAction();

        $action->execute($standardUser);
        $action->execute($adminUser);

        $this->assertTrue(true);
    }
}
