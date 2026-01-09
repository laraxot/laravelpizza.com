<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Modules\User\Models\SocialiteUser;
use Spatie\QueueableAction\QueueableAction;

class RetrieveSocialiteUserAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $provider, SocialiteUserContract $user): ?SocialiteUser
    {
        if (empty($provider)) {
            throw new \InvalidArgumentException('Il provider non può essere vuoto');
        }

        $providerId = $user->getId();
        if (! is_string($providerId) && ! is_int($providerId)) {
            throw new \RuntimeException('L\'ID del provider deve essere una stringa o un intero');
        }

        $res = SocialiteUser::query()
            ->with(['user'])
            ->where('provider', $provider)
            ->where('provider_id', $providerId)
            ->first();

        if (null === $res) {
            return null;
        }

        // Accesso sicuro alla proprietà token in modo type-safe
        $token = '';

        // Utilizzo ReflectionClass per accedere in modo sicuro alle proprietà/metodi
        try {
            $reflection = new \ReflectionClass($user);

            // Prova prima i metodi standard
            if ($reflection->hasMethod('getToken')) {
                $method = $reflection->getMethod('getToken');
                $method->setAccessible(true);
                $tokenValue = $method->invoke($user);
                if (is_string($tokenValue)) {
                    $token = $tokenValue;
                }
            } elseif ($reflection->hasMethod('token')) {
                $method = $reflection->getMethod('token');
                $method->setAccessible(true);
                $tokenValue = $method->invoke($user);
                if (is_string($tokenValue)) {
                    $token = $tokenValue;
                }
            } elseif ($reflection->hasProperty('token')) { // Prova poi ad accedere alla proprietà
                $property = $reflection->getProperty('token');
                $property->setAccessible(true);
                $tokenValue = $property->getValue($user);
                if (is_string($tokenValue)) {
                    $token = $tokenValue;
                }
            } elseif (isset($user->token) && is_string($user->token)) { // Fallback su accesso diretto con var_export
                $token = $user->token;
            }
        } catch (\ReflectionException $e) {
            // Fallback silenzioso
        }

        if (empty($token)) {
            // Se non riusciamo a ottenere un token valido, utilizziamo un valore predefinito
            $token = 'no_token_'.time();
        }

        $res->update([
            'token' => $token,
        ]);

        return $res;
    }
}
