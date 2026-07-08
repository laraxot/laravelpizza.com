<?php

declare(strict_types=1);

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Mockery\MockInterface;
use Modules\User\Actions\Otp\Hasher;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Datas\PasswordData;
use Modules\User\Notifications\Auth\Otp;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

describe('SendOtpByUserAction', function () {
    it('generates and sends an OTP to the user', function () {
        Notification::fake();

        $user = UserFactory::new()->createOne([
            'email' => 'otp-'.uniqid('', true).'@example.com',
        ]);

        $passwordData = PasswordData::from([
            'otp_expiration_minutes' => 10,
        ]);

        $mockStr = configureMock(Str::class, function (MockInterface $mock): void {
            $mock->allows(['random' => 'random-otp-12']);
        });

        $mockHasher = configureMock(Hasher::class, function (MockInterface $mock): void {
            $mock->allows(['make' => str_repeat('a', 60)]);
        });

        $action = new SendOtpByUserAction($passwordData, $mockStr, $mockHasher);

        $now = Carbon::now();
        Carbon::setTestNow($now);

        $action->execute($user);

        $user->refresh();
        Assert::assertSame(str_repeat('a', 60), $user->password);
        Assert::assertTrue($user->is_otp);
        Assert::assertSame($now->addMinutes(10)->toDateTimeString(), $user->password_expires_at?->toDateTimeString());

        Notification::assertSentOnDemand(
            Otp::class,
            function (Otp $notification, array $channels, object $notifiable) use ($user): bool {
                /** @var array<string, string> $routes */
                $routes = $notifiable->routes ?? [];

                return ($routes['mail'] ?? null) === $user->email
                    && $notification->user->id === $user->id
                    && 'random-otp-12' === $notification->code;
            }
        );

        Carbon::setTestNow();
    });
});
