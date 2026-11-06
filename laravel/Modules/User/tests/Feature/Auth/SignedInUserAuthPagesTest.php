<?php

declare(strict_types=1);

use Modules\User\Database\Factories\UserFactory;
use Modules\User\Models\Policies\UserPolicy;
use Modules\User\Tests\TestCase;
use Modules\Xot\Datas\XotData;

uses(TestCase::class);

/*
 * Signed-in citizen on the auth pages and on account deletion (story auth-flow-redirects-reset-token, browser audit).
 * 1. The owner may delete their own account (GDPR art. 17), nobody else's.
 * 2. Login and registration pages send a signed-in user to the personal area instead of a form or a bare 403.
 */
beforeEach(function (): void {
    config(['activitylog.enabled' => false]);
});

test('a user may delete their own account and nobody else\'s', function (): void {
    $owner = UserFactory::new()->createOne();
    $other = UserFactory::new()->createOne();
    $policy = app(UserPolicy::class);

    expect($policy->deleteOwnAccount($owner, $owner))->toBeTrue()
        ->and($policy->deleteOwnAccount($owner, $other))->toBeFalse();
});

test('the owner of the configured user class opens the account delete url without a 403', function (): void {
    app()->setLocale('it');
    $id = UserFactory::new()->createOne(['email_verified_at' => now()])->getKey();
    // The factory builds the base model; the live app signs in the configured class, which the Gate has no policy for.
    $owner = XotData::make()->getUserClass()::query()->whereKey($id)->firstOrFail();
    $this->actingAs($owner);

    $this->get('/it/account/delete')->assertRedirect('/it');
});

test('a signed-in user is sent from the auth page to the personal area', function (string $lang, string $page): void {
    app()->setLocale($lang);
    $this->actingAs(UserFactory::new()->createOne(['email_verified_at' => now()]));

    $this->get('/'.$lang.'/auth/'.$page)->assertRedirect(url('/'.$lang.'/area-personale'));
})->with([
    'it login' => ['it', 'login'],
    'en login' => ['en', 'login'],
    'it register' => ['it', 'register'],
    'de register' => ['de', 'register'],
    'es register' => ['es', 'register'],
]);

test('a guest still sees the login and register forms', function (string $page): void {
    app()->setLocale('it');

    $this->get('/it/auth/'.$page)->assertOk();
})->with(['login', 'register']);
