<?php

declare(strict_types=1);

namespace Modules\User\Tests\Unit\Actions\Otp;

use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Str;
use Modules\User\Actions\Otp\Hasher;
use Modules\User\Actions\Otp\SendOtpByUserAction;
use Modules\User\Datas\PasswordData;
use Modules\User\Models\User;
use Modules\User\Notifications\Auth\Otp;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

describe('SendOtpByUserAction', function () {
    it('generates and sends an OTP to the user', function () {
        // Arrange
        Notification::fake();

        $user = User::factory()->create([
            'email' => self::generateUniqueEmail(),
        ]);

        $passwordData = PasswordData::from([
            'otp_expiration_minutes' => 10,
        ]);

        $mockStr = mock(Str::class);
        $mockStr->shouldReceive('random')
            ->once()
            ->with(12)
            ->andReturn('random-otp-12');

        $mockHasher = mock(Hasher::class);
        $mockHasher->shouldReceive('make')
            ->once()
            ->with('random-otp-12')
            ->andReturn(str_repeat('a', 60));

        $action = new SendOtpByUserAction($passwordData, $mockStr, $mockHasher);

        // Set fixed time for testing expiration
        $now = Carbon::now();
        Carbon::setTestNow($now);

        // Act
        $action->execute($user);

        // Assert
        $user->refresh();
        expect($user->password)->toBe(str_repeat('a', 60));
        expect($user->is_otp)->toBeTrue();
        expect($user->password_expires_at->toDateTimeString())
            ->toBe($now->addMinutes(10)->toDateTimeString());

        Notification::assertSentOnDemand(
            Otp::class,
            function ($notification, $channels, $notifiable) use ($user) {
                return $notifiable->routes['mail'] === $user->email
                       && $notification->user->id === $user->id
                       && 'random-otp-12' === $notification->code;
            }
        );

        Carbon::setTestNow(); // Reset time
    });
});
