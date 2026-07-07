<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Verified;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\URL;
use Modules\User\Models\User;
use PHPUnit\Framework\Assert;

uses(Modules\Cms\Tests\TestCase::class);
test('email verification screen can be rendered', function (): void {
    $user = cmsCreateUnverifiedUser();

    $lang = app()->getLocale();
    $response = cmsActingAsGet($user, '/'.$lang.'/verify-email');
    Assert::assertSame(200, $response->status());
});

test('email can be verified', function (): void {
    $user = cmsCreateUnverifiedUser();

    Event::fake();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1((string) $user->email),
    ]);

    $response = cmsActingAsGet($user, $verificationUrl);

    Event::assertDispatched(Verified::class);
    $freshUser = $user->fresh();
    Assert::assertInstanceOf(User::class, $freshUser);
    Assert::assertTrue($freshUser->hasVerifiedEmail());
    Assert::assertSame(route('dashboard', absolute: false).'?verified=1', $response->headers->get('Location'));
});

test('email is not verified with invalid hash', function (): void {
    $user = cmsCreateUnverifiedUser();

    $verificationUrl = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->id,
        'hash' => sha1('wrong-email'),
    ]);

    cmsActingAsGet($user, $verificationUrl);

    $freshUser = $user->fresh();
    Assert::assertInstanceOf(User::class, $freshUser);
    Assert::assertFalse($freshUser->hasVerifiedEmail());
});
