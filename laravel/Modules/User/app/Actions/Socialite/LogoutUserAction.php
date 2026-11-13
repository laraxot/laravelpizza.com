<?php

declare(strict_types=1);
/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

namespace Modules\User\Actions\Socialite;

// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Modules\User\Models\DeviceUser;
use Modules\User\Models\OauthRefreshToken;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;
use Webmozart\Assert\Assert;

class LogoutUserAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(UserContract $user): void
    {
        Assert::notNull($accessToken = $user->token(), '['.__FILE__.']['.__LINE__.']');

        // Revoca, non cancellazione: e' cio' che fa Passport, il token resta per l'audit e non e' piu' utilizzabile.
        if (method_exists($accessToken, 'getKey')) {
            OauthRefreshToken::query()
                ->where('access_token_id', $accessToken->getKey())
                ->update(['revoked' => true]);
        }

        if (method_exists($accessToken, 'revoke')) {
            $accessToken->revoke();
        }

        /*
         * MobileDeviceUser::where('user_id', $user->getKey())
         * ->update(['logout_at' => now()]);
         */
        DeviceUser::where('user_id', $user->getKey())->update(['logout_at' => now()]);
    }
}
