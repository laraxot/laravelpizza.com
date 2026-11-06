<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;

use function Pest\Laravel\get;

test('forgot password screen can be rendered', function (): void {
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/forgot-password');

    $response->assertStatus(200);
});

test('users can request a password reset link', function (): void {
    Notification::fake();
    $user = $this->createTestUser();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});

test('password reset page can be rendered from a notification', function (): void {
    Notification::fake();
    $user = $this->createTestUser();
    $lang = app()->getLocale();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($lang): bool {
        $response = get('/'.$lang.'/reset-password/'.$notification->token);
        $response->assertStatus(200);

        return true;
    });
});

test('users can reset their password', function (): void {
    Notification::fake();
    $user = $this->createTestUser();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function (ResetPassword $notification) use ($user): bool {
        $response = LivewireVolt::test('auth.reset-password', ['token' => $notification->token])
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');

        $response->assertHasNoErrors();
        $response->assertRedirect(route('login', absolute: false));

        return true;
    });
});
