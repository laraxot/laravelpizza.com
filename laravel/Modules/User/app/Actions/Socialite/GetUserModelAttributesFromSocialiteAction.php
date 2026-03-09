<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\Utils\UserNameFieldsResolver;
use Modules\User\Datas\SocialiteUserAttributesData;
use Spatie\QueueableAction\QueueableAction;

class GetUserModelAttributesFromSocialiteAction
{
    use QueueableAction;

    public function execute(string $provider, SocialiteUserContract $oauthUser): SocialiteUserAttributesData
    {
        if (empty($provider)) {
            throw new \InvalidArgumentException('Il provider non può essere vuoto');
        }

        $nameFieldsResolver = app(UserNameFieldsResolver::class, ['user' => $oauthUser]);
        if (null === $nameFieldsResolver) {
            throw new \RuntimeException('Impossibile istanziare UserNameFieldsResolver');
        }

        if (! is_string($nameFieldsResolver->name)) {
            throw new \RuntimeException('Il nome deve essere una stringa');
        }
        if (! is_string($nameFieldsResolver->lastName)) {
            throw new \RuntimeException('Il cognome deve essere una stringa');
        }

        $email = $oauthUser->getEmail();
        if (! is_string($email) || empty($email)) {
            throw new \RuntimeException('L\'email deve essere una stringa non vuota');
        }

        return new SocialiteUserAttributesData(
            name: $nameFieldsResolver->name,
            firstName: $nameFieldsResolver->name,
            lastName: $nameFieldsResolver->lastName,
            email: $email,
            provider: $provider,
        );
    }
}
