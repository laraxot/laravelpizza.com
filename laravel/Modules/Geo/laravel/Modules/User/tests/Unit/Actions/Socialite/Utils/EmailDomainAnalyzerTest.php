<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Mockery\MockInterface;
use Modules\User\Actions\Socialite\Utils\EmailDomainAnalyzer;
use PHPUnit\Framework\Assert;

uses(Modules\User\Tests\TestCase::class);

function createMockSocialiteUser(?string $email): SocialiteUser
{
    return configureMock(SocialiteUser::class, function (MockInterface $mock) use ($email): void {
        $mock->allows(['getEmail' => $email]);
    });
}

describe('EmailDomainAnalyzer', function () {
    beforeEach(function () {
        /* @var \Modules\User\Tests\TestCase $this */
        Config::set('services.google.email_domains.first_party.tld', null);
        Config::set('services.google.email_domains.client.tld', null);
    });

    it('throws for empty provider', function () {
    });

    it('detects first party domain', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser('user@company.com');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        Assert::assertTrue($analyzer->hasFirstPartyDomain());
        Assert::assertFalse($analyzer->hasUnrecognizedDomain());
    });

    it('detects client domain', function () {
        Config::set('services.google.email_domains.client.tld', '@client.org');

        $ssoUser = createMockSocialiteUser('user@client.org');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        Assert::assertTrue($analyzer->hasClientDomain());
    });

    it('marks unknown domain as unrecognized', function () {
        $ssoUser = createMockSocialiteUser('user@random.com');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        Assert::assertTrue($analyzer->hasUnrecognizedDomain());
        Assert::assertFalse($analyzer->hasFirstPartyDomain());
        Assert::assertFalse($analyzer->hasClientDomain());
    });

    it('handles null email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser(null);
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        Assert::assertFalse($analyzer->hasFirstPartyDomain());
        Assert::assertFalse($analyzer->hasClientDomain());
    });

    it('handles empty email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser('');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        Assert::assertFalse($analyzer->hasFirstPartyDomain());
        Assert::assertFalse($analyzer->hasClientDomain());
    });
});
