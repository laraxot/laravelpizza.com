<?php

declare(strict_types=1);

use Modules\User\Actions\Auth\HasVerifiedIdentityAction;
use Modules\User\Actions\Auth\UpsertUserFromDigitalIdentityAction;
use Modules\User\Models\User;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;
use Webmozart\Assert\InvalidArgumentException;

uses(TestCase::class);

/*
 * PRD-02: accesso con SPID e CIE. I controller del tema Sixteen delegano a UpsertUserFromDigitalIdentityAction, che usa le
 * colonne aggiunte dalla migrazione owner `2026_11_12_120000_create_users_table` (prima l'accesso falliva con errore SQL).
 */
beforeEach(function (): void {
    config(['activitylog.enabled' => false]);
});

/**
 * @param  array<string, mixed>  $overrides
 * @return array<string, mixed>
 */
function digitalIdentityAttributes(array $overrides = []): array
{
    return array_merge([
        'fiscal_code' => 'TINIT-RSSMRA80A01H501U',
        'name' => 'Mario',
        'surname' => 'Rossi',
        'email' => 'mario.rossi.spid@example.org',
    ], $overrides);
}

it('creates a user from SPID with a verified email and a trusted identity', function (): void {
    $user = app(UpsertUserFromDigitalIdentityAction::class)->execute('spid', digitalIdentityAttributes(), emailVerified: true, identityProvider: 'poste');

    $fresh = User::query()->whereKey($user->getKey())->firstOrFail();
    $raw = $fresh->getAttributes();
    Assert::assertSame('RSSMRA80A01H501U', $raw['fiscal_code']);
    Assert::assertSame('spid', $raw['auth_method']);
    Assert::assertSame('poste', $raw['identity_provider']);
    Assert::assertSame('Mario', $raw['first_name']);
    Assert::assertSame('Rossi', $raw['last_name']);
    Assert::assertSame('Mario Rossi', $raw['name']);
    Assert::assertSame('mario.rossi.spid@example.org', $raw['email']);
    Assert::assertNotNull($raw['email_verified_at']);
    Assert::assertNotNull($raw['last_login_at']);
    Assert::assertTrue(app(HasVerifiedIdentityAction::class)->execute($fresh));
});

it('uses a placeholder email for CIE without a verified email but still trusts the identity', function (): void {
    $user = app(UpsertUserFromDigitalIdentityAction::class)->execute('cie', digitalIdentityAttributes([
        'fiscal_code' => 'VRDLGU75B12F205X',
        'email' => 'not-verified@example.org',
    ]), emailVerified: false);

    $raw = User::query()->whereKey($user->getKey())->firstOrFail()->getAttributes();
    Assert::assertSame('cie.vrdlgu75b12f205x@noemail.local', $raw['email']);
    Assert::assertNull($raw['email_verified_at']);
    Assert::assertSame('cie', $raw['identity_provider']);
    Assert::assertTrue(app(HasVerifiedIdentityAction::class)->execute(User::query()->whereKey($user->getKey())->firstOrFail()));
});

it('finds the same user again by fiscal code instead of creating a duplicate', function (): void {
    $first = app(UpsertUserFromDigitalIdentityAction::class)->execute('spid', digitalIdentityAttributes(), emailVerified: true);
    $second = app(UpsertUserFromDigitalIdentityAction::class)->execute('cie', digitalIdentityAttributes(['fiscal_code' => 'rssmra80a01h501u', 'email' => null]), emailVerified: false);

    Assert::assertSame($first->getKey(), $second->getKey());
    Assert::assertSame(1, User::query()->where('fiscal_code', 'RSSMRA80A01H501U')->count());
    Assert::assertSame('cie', User::query()->whereKey($first->getKey())->firstOrFail()->getAttributes()['auth_method']);
});

it('links an existing email account when the identity provider verifies the same email', function (): void {
    $existing = User::factory()->create(['email' => 'mario.rossi.spid@example.org', 'email_verified_at' => null]);

    $user = app(UpsertUserFromDigitalIdentityAction::class)->execute('spid', digitalIdentityAttributes(), emailVerified: true);

    Assert::assertSame($existing->getKey(), $user->getKey());
    $raw = User::query()->whereKey($existing->getKey())->firstOrFail()->getAttributes();
    Assert::assertSame('RSSMRA80A01H501U', $raw['fiscal_code']);
    Assert::assertNotNull($raw['email_verified_at']);
});

it('rejects a missing or malformed fiscal code', function (mixed $fiscalCode): void {
    app(UpsertUserFromDigitalIdentityAction::class)->execute('spid', digitalIdentityAttributes(['fiscal_code' => $fiscalCode]), emailVerified: false);
})->with([
    'missing' => [null],
    'too short' => ['ABC'],
    'symbols' => ['RSSMRA80A01H50;U'],
])->throws(InvalidArgumentException::class);

it('only accepts spid and cie as identity methods', function (): void {
    app(UpsertUserFromDigitalIdentityAction::class)->execute('password', digitalIdentityAttributes(), emailVerified: true);
})->throws(InvalidArgumentException::class);
