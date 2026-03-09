<?php

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Actions\Socialite\Utils\UserNameFieldsResolver;
<<<<<<< HEAD
||||||| 6161e129d
use RuntimeException;
use Modules\User\Datas\SocialiteUserAttributesData;
=======
use Modules\User\Datas\SocialiteUserAttributesData;
>>>>>>> feature/ralph-loop-implementation
use Spatie\QueueableAction\QueueableAction;

class GetUserModelAttributesFromSocialiteAction
{
    use QueueableAction;

    public readonly string $name;

    public readonly string $first_name;

    public readonly string $last_name;

    public readonly string $email;

    public function __construct()
        private readonly string $provider,
        private readonly SocialiteUserContract $oauthUser,
    ) {
        if (empty($provider)) {
            throw new \InvalidArgumentException('Il provider non può essere vuoto');
        }

<<<<<<< HEAD
        $nameFieldsResolver = app(UserNameFieldsResolver::class, ['user' => $this->oauthUser]);
||||||| 6161e129d
        $nameFieldsResolver = app(UserNameFieldsResolver::class, ['user' => $oauthUser]);
        if ($nameFieldsResolver === null) {
            throw new RuntimeException('Impossibile istanziare UserNameFieldsResolver');
=======
        $nameFieldsResolver = app(UserNameFieldsResolver::class, ['user' => $oauthUser]);
>>>>>>> feature/ralph-loop-implementation
        if (null === $nameFieldsResolver) {
            throw new \RuntimeException('Impossibile istanziare UserNameFieldsResolver');
        }

        if (! is_string($nameFieldsResolver->name)) {
            throw new \RuntimeException('Il nome deve essere una stringa');
        }
<<<<<<< HEAD
        if (! is_string($nameFieldsResolver->last_name)) {
||||||| 6161e129d
        if (! is_string($nameFieldsResolver->lastName)) {
            throw new RuntimeException('Il cognome deve essere una stringa');
=======
        if (! is_string($nameFieldsResolver->lastName)) {
>>>>>>> feature/ralph-loop-implementation
            throw new \RuntimeException('Il cognome deve essere una stringa');
        }

        $this->name = $nameFieldsResolver->name;
        $this->first_name = $nameFieldsResolver->name;
        $this->last_name = $nameFieldsResolver->last_name;

        $email = $this->oauthUser->getEmail();
        if (! is_string($email) || empty($email)) {
            throw new \RuntimeException('L\'email deve essere una stringa non vuota');
        }
        $this->email = $email;
    }

    public function getProvider(): string
    {
        return $this->provider;
    }
}
