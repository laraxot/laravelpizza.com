<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Config;
use Laravel\Socialite\Contracts\User as SocialiteUser;
use Modules\User\Actions\Socialite\Utils\EmailDomainAnalyzer;
use Modules\User\Tests\TestCase;

uses(TestCase::class);

function createMockSocialiteUser(?string $email): SocialiteUser
{
    $mock = Mockery::mock(SocialiteUser::class);
    $mock->shouldReceive('getEmail')->andReturn($email);

    return $mock;
}

describe('EmailDomainAnalyzer', function () {
    beforeEach(function () {
        Config::set('services.google.email_domains.first_party.tld', null);
        Config::set('services.google.email_domains.client.tld', null);
    });

    it('throws for empty provider', function () {
        expect(fn () => new EmailDomainAnalyzer(''))
            ->toThrow(\InvalidArgumentException::class, 'Il provider SSO non può essere vuoto');
    });

    it('detects first party domain', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser('user@company.com');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        expect($analyzer->hasFirstPartyDomain())->toBeTrue()
            ->and($analyzer->hasUnrecognizedDomain())->toBeFalse();
    });

    it('detects client domain', function () {
        Config::set('services.google.email_domains.client.tld', '@client.org');

        $ssoUser = createMockSocialiteUser('user@client.org');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        expect($analyzer->hasClientDomain())->toBeTrue();
    });

    it('marks unknown domain as unrecognized', function () {
        $ssoUser = createMockSocialiteUser('user@random.com');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        expect($analyzer->hasUnrecognizedDomain())->toBeTrue()
            ->and($analyzer->hasFirstPartyDomain())->toBeFalse()
            ->and($analyzer->hasClientDomain())->toBeFalse();
    });

    it('handles null email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser(null);
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        expect($analyzer->hasFirstPartyDomain())->toBeFalse()
            ->and($analyzer->hasClientDomain())->toBeFalse();
    });

    it('handles empty email gracefully', function () {
        Config::set('services.google.email_domains.first_party.tld', '@company.com');

        $ssoUser = createMockSocialiteUser('');
        $analyzer = new EmailDomainAnalyzer('google');
        $analyzer->setUser($ssoUser);

        expect($analyzer->hasFirstPartyDomain())->toBeFalse()
            ->and($analyzer->hasClientDomain())->toBeFalse();
    });
});
