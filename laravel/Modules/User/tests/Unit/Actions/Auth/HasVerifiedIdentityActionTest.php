<?php

declare(strict_types=1);

use Modules\User\Actions\Auth\HasVerifiedIdentityAction;
use Modules\User\Database\Factories\UserFactory;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

/*
 * PRD-02: chi puo' inviare una segnalazione. Modelli non salvati (make), nessun database.
 */

test('a guest has no verified identity', function (): void {
    Assert::assertFalse(app(HasVerifiedIdentityAction::class)->execute(null));
});

test('a confirmed email is a verified identity', function (): void {
    $user = UserFactory::new()->makeOne(['email_verified_at' => now()]);

    Assert::assertTrue(app(HasVerifiedIdentityAction::class)->execute($user));
});

test('an unconfirmed email without SPID or CIE is not a verified identity', function (): void {
    $user = UserFactory::new()->makeOne(['email_verified_at' => null]);

    Assert::assertFalse(app(HasVerifiedIdentityAction::class)->execute($user));
});

test('SPID and CIE logins are verified identities even without an email', function (string $method): void {
    $user = UserFactory::new()->makeOne([
        'email' => $method.'.RSSMRA80A01H501U@noemail.local',
        'email_verified_at' => null,
    ]);
    $user->setAttribute('auth_method', $method);

    Assert::assertTrue(app(HasVerifiedIdentityAction::class)->execute($user));
    Assert::assertFalse($user->hasVerifiedEmail(), 'the email itself must stay unverified: no mail goes to @noemail.local');
})->with(['spid', 'cie']);
