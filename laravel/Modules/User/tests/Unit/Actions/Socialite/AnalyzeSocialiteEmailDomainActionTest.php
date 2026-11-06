<?php

declare(strict_types=1);
use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\AnalyzeSocialiteEmailDomainAction;
use Modules\User\Tests\TestCase;
use PHPUnit\Framework\Assert;

uses(TestCase::class);

function createMockSocialiteUserForDomain(?string $email): SocialiteUser
{
    return configureMock(SocialiteUser::class, function (MockInterface $mock) use ($email): void {
        $mock->allows(['getEmail' => $email]);
    });
}

describe('AnalyzeSocialiteEmailDomainAction', function () {
    beforeEach(function () {
        Config::set('services.google.email_domains.first_party.tld', null);
        Config::set('services.google.email_domains.client.tld', null);
    });

    it('throws for empty provider', function () {
        $ssoUser = createMockSocialiteUserForDomain('user@example.com');

        try {
            app(AnalyzeSocialiteEmailDomainAction::class)->execute($ssoUser, '');
            Assert::fail('Expected InvalidArgumentException');
        } catch (InvalidArgumentException $exception) {
        }
    });

    it('detects first party domain', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $analysis = app(AnalyzeSocialiteEmailDomainAction::class)
            ->execute(createMockSocialiteUserForDomain('user@company.com'), 'google');

        Assert::assertTrue($analysis->hasFirstPartyDomain);
        Assert::assertFalse($analysis->hasUnrecognizedDomain());
    });

    it('detects client domain', function () {
        Config::set('services.google.email_domains.client.tld', '@client.org');

        $analysis = app(AnalyzeSocialiteEmailDomainAction::class)
            ->execute(createMockSocialiteUserForDomain('user@client.org'), 'google');

        Assert::assertTrue($analysis->hasClientDomain);
    });

    it('marks unknown domain as unrecognized', function () {
        $analysis = app(AnalyzeSocialiteEmailDomainAction::class)
            ->execute(createMockSocialiteUserForDomain('user@random.com'), 'google');

        Assert::assertTrue($analysis->hasUnrecognizedDomain());
        Assert::assertFalse($analysis->hasFirstPartyDomain);
        Assert::assertFalse($analysis->hasClientDomain);
    });

    it('handles null email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $analysis = app(AnalyzeSocialiteEmailDomainAction::class)
            ->execute(createMockSocialiteUserForDomain(null), 'google');

        Assert::assertFalse($analysis->hasFirstPartyDomain);
        Assert::assertFalse($analysis->hasClientDomain);
    });

    it('handles empty email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $analysis = app(AnalyzeSocialiteEmailDomainAction::class)
            ->execute(createMockSocialiteUserForDomain(''), 'google');

        Assert::assertFalse($analysis->hasFirstPartyDomain);
        Assert::assertFalse($analysis->hasClientDomain);
    });
});
