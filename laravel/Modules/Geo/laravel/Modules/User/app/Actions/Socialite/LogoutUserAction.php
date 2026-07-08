<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

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
        /*
         * DB::table('oauth_refresh_tokens')
         * ->where('access_token_id', $accessToken->)
         * ->delete();
         */

        // Assert::methodExists($accessToken, 'delete');
        if (method_exists($accessToken, 'getKey')) {
            OauthRefreshToken::where('access_token_id', $accessToken->getKey())->delete();
        }

        if (method_exists($accessToken, 'delete')) {
            $accessToken->delete();

            // $user->token()->delete();
        }

        /*
         * MobileDeviceUser::where('user_id', $user->getKey())
         * ->update(['logout_at' => now()]);
         */
        DeviceUser::where('user_id', $user->getKey())->update(['logout_at' => now()]);
    }
}
