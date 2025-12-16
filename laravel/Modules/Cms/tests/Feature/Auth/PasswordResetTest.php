<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature\Auth;

use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Support\Facades\Notification;
use Livewire\Volt\Volt as LivewireVolt;
use Modules\Xot\Tests\TestCase;

use function Pest\Laravel\get;

uses(TestCase::class);

<<<<<<< HEAD
test('reset password link screen can be rendered', function (): void {
=======
test('forgot password page can be rendered', function () {
>>>>>>> 46d657c (.)
    $lang = app()->getLocale();
    $response = get('/'.$lang.'/forgot-password');

    $response->assertStatus(200);
});

<<<<<<< HEAD
test('reset password link can be requested', function (): void {
    Notification::fake();

    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
test('password reset link can be sent', function () {
>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class);
});

<<<<<<< HEAD
test('reset password screen can be rendered', function (): void {
    Notification::fake();

    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
test('reset password link renders reset password page', function () {
>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($lang) {
        $response = get('/'.$lang.'/reset-password/'.$notification->token);
        $response->assertStatus(200);

        return true;
    });
});

<<<<<<< HEAD
test('password can be reset with valid token', function (): void {
    Notification::fake();

    /** @var class-string<\Illuminate\Database\Eloquent\Model> $userClass */
    $userClass = XotData::make()->getUserClass();
    /** @var \Illuminate\Contracts\Auth\Authenticatable&\Illuminate\Database\Eloquent\Model $user */
=======
test('password can be reset', function () {
>>>>>>> 46d657c (.)
    $user = $userClass::factory()->create();
    $lang = app()->getLocale();

    LivewireVolt::test('auth.forgot-password')->set('email', $user->email)->call('sendPasswordResetLink');

    Notification::assertSentTo($user, ResetPassword::class, function ($notification) use ($user) {
        $response = LivewireVolt::test('auth.reset-password', ['token' => $notification->token])
            ->set('email', $user->email)
            ->set('password', 'password')
            ->set('password_confirmation', 'password')
            ->call('resetPassword');

        $response->assertHasNoErrors()->assertRedirect(route('login', absolute: false));

        return true;
    });
});
