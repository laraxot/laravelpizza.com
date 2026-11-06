<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Illuminate\Support\Str;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Datas\SocialiteEmailDomainAnalysisData;
use Spatie\QueueableAction\QueueableAction;

final class AnalyzeSocialiteEmailDomainAction
{
    use QueueableAction;

    public function execute(SocialiteUserContract $oauthUser, string $provider): SocialiteEmailDomainAnalysisData
    {
        if ($provider === '') {
            throw new \InvalidArgumentException('Il provider SSO non può essere vuoto');
        }

        return new SocialiteEmailDomainAnalysisData(
            hasFirstPartyDomain: $this->matchesConfiguredDomain($oauthUser, $provider, 'first_party'),
            hasClientDomain: $this->matchesConfiguredDomain($oauthUser, $provider, 'client'),
        );
    }

    private function matchesConfiguredDomain(
        SocialiteUserContract $oauthUser,
        string $provider,
        string $domainKind,
    ): bool {
        $email = $oauthUser->getEmail();
        if (! is_string($email) || $email === '') {
            return false;
        }

        $configuredDomain = config(sprintf('services.%s.email_domains.%s.tld', $provider, $domainKind));
        if (! is_string($configuredDomain) || $configuredDomain === '') {
            return false;
        }

        $emailDomain = Str::of($email)->after('@')->toString();
        $configDomain = Str::of($configuredDomain)->after('@')->toString();

        return $emailDomain === $configDomain;
    }
}
