<?php

declare(strict_types=1);

use Illuminate\Auth\Events\Verified;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\URL;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Tests\TestCase;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * PRD-02 / SEC-14 (story account-deletion-and-email-verification): la registrazione non verifica piu' l'email da sola.
 * La mail `VerifyEmail` porta un link firmato alla rotta `verification.verify` (`Modules/User/routes/web.php`), che segna
 * l'indirizzo come verificato solo per l'utente giusto e con l'hash giusto.
 */

beforeEach(function (): void {
    config(['activitylog.enabled' => false]);
    app()->setLocale('it');
});

test('the verification route exists and is signed', function (): void {
    $route = Route::getRoutes()->getByName('verification.verify');

    Assert::assertNotNull($route);
    $middleware = $route->gatherMiddleware();
    Assert::assertContains('auth', $middleware);
    Assert::assertContains('signed', $middleware);
});

test('the verification mail can build its link', function (): void {
    $user = UserFactory::new()->unverified()->createOne();

    $url = (new ReflectionMethod(VerifyEmail::class, 'verificationUrl'))->invoke(new VerifyEmail, $user);

    Assert::assertIsString($url);
    Assert::assertStringContainsString('/email/verify/'.SafeStringCastAction::cast($user->getKey()).'/', $url);
    Assert::assertStringContainsString('signature=', $url);
});

test('a valid signed link verifies the address once', function (): void {
    /** @var TestCase $this */
    Event::fake([Verified::class]);
    $user = UserFactory::new()->unverified()->createOne();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->getKey(),
        'hash' => sha1((string) $user->email),
    ]);

    $this->actingAs($user)->get($url)->assertRedirect();

    Assert::assertTrue((bool) $user->fresh()?->hasVerifiedEmail());
    Event::assertDispatchedTimes(Verified::class, 1);
});

test('a link with the wrong hash does not verify', function (): void {
    /** @var TestCase $this */
    $user = UserFactory::new()->unverified()->createOne();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $user->getKey(),
        'hash' => sha1('altro@example.com'),
    ]);

    $this->actingAs($user)->get($url)->assertForbidden();

    Assert::assertFalse((bool) $user->fresh()?->hasVerifiedEmail());
});

test('a link for another user does not verify', function (): void {
    /** @var TestCase $this */
    $owner = UserFactory::new()->unverified()->createOne();
    $other = UserFactory::new()->unverified()->createOne();
    $url = URL::temporarySignedRoute('verification.verify', now()->addMinutes(60), [
        'id' => $owner->getKey(),
        'hash' => sha1((string) $owner->email),
    ]);

    $this->actingAs($other)->get($url)->assertForbidden();

    Assert::assertFalse((bool) $owner->fresh()?->hasVerifiedEmail());
    Assert::assertFalse((bool) $other->fresh()?->hasVerifiedEmail());
});

test('an unsigned link does not verify', function (): void {
    /** @var TestCase $this */
    $user = UserFactory::new()->unverified()->createOne();
    $url = route('verification.verify', ['id' => $user->getKey(), 'hash' => sha1((string) $user->email)]);

    $this->actingAs($user)->get($url)->assertForbidden();

    Assert::assertFalse((bool) $user->fresh()?->hasVerifiedEmail());
});

test('the verified middleware sends an unverified user to the notice page', function (): void {
    /** @var TestCase $this */
    $user = UserFactory::new()->unverified()->createOne();
    Route::middleware(['web', 'auth', 'verified'])->get('/_test/verified-only', static fn (): string => 'ok');

    $this->actingAs($user)->get('/_test/verified-only')->assertRedirect();

    $verified = UserFactory::new()->createOne();
    $this->actingAs($verified)->get('/_test/verified-only')->assertOk();
});

test('EnsureVerifiedIdentity sends an unverified user to the notice page and lets verified users through', function (): void {
    /** @var TestCase $this */
    Route::middleware(['web', 'auth', \Modules\User\Http\Middleware\EnsureVerifiedIdentity::class])
        ->get('/_test/verified-identity-only', static fn (): string => 'ok');

    $unverified = UserFactory::new()->unverified()->createOne();
    $this->actingAs($unverified)->get('/_test/verified-identity-only')->assertRedirect();

    $verified = UserFactory::new()->createOne();
    $this->actingAs($verified)->get('/_test/verified-identity-only')->assertOk();
});
