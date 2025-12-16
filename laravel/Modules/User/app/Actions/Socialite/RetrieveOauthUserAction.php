<?php

/**
 * @see https://github.com/DutchCodingCompany/filament-socialite
 */

declare(strict_types=1);

namespace Modules\User\Actions\Socialite;

use Laravel\Socialite\Contracts\User as SocialiteUserContract;
use Laravel\Socialite\Facades\Socialite;
// use DutchCodingCompany\FilamentSocialite\FilamentSocialite;
use Laravel\Socialite\Two\InvalidStateException;
use Modules\User\Events\InvalidState;
use Spatie\QueueableAction\QueueableAction;

class RetrieveOauthUserAction
{
    use QueueableAction;

    /**
     * Execute the action.
     */
    public function execute(string $provider): ?SocialiteUserContract
    {
        try {
            return Socialite::driver($provider)->user();

            // SocialiteProviders\Manager\OAuth2\User
        } catch (InvalidStateException $invalidStateException) {
            InvalidState::dispatch($invalidStateException);
        }

        return null;
    }
}

/*
 * +id: "auth0|6491ce20f1ac1401362d154f"
 * +nickname: "m.sottana"
 * +name: " "
 * +email: "m.sottana@egeatech.com"
 * +avatar: null
 * +user: array:7 [▼
 * "sub" => "auth0|6491ce20f1ac1401362d154f"
 * "nickname" => "m.sottana"
 * "name" => "m.sottana@egeatech.com"
 * "picture" => "https://s.gravatar.com/avatar/fb389ec0c8beecb7640aab7fde6df190?s=480&r=pg&d=https%3A%2F%2Fcdn.auth0.com%2Favatars%2Fm.png"
 * "updated_at" => "2023-09-19T14:09:05.783Z"
 * "email" => "m.sottana@egeatech.com"
 * "email_verified" => true
 * ]
 * +attributes: array:5 [▶]
 * +token: "eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIiwiaXNzIjoiaHR0cHM6Ly9kZXYtemxpcHV5MG4udXMuYXV0aDAuY29tLyJ9..Q-y0xn-QuXY84JvO.Xrov3EjXErMRjuB3L9ESLFiXJCQEE6Utm7BEQJdG1XgZy ▶"
 * +refreshToken: null
 * +expiresIn: 86400
 * +approvedScopes: null
 * +accessTokenResponseBody: array:5 [▼
 * "access_token" => "eyJhbGciOiJkaXIiLCJlbmMiOiJBMjU2R0NNIiwiaXNzIjoiaHR0cHM6Ly9kZXYtemxpcHV5MG4udXMuYXV0aDAuY29tLyJ9..Q-y0xn-QuXY84JvO.Xrov3EjXErMRjuB3L9ESLFiXJCQEE6Utm7BEQJdG1XgZy ▶"
 * "id_token" => "eyJhbGciOiJSUzI1NiIsInR5cCI6IkpXVCIsImtpZCI6ImtCN3VpMkRBbzJzNVZVRHVrOUFTaiJ9.eyJuaWNrbmFtZSI6Im0uc290dGFuYSIsIm5hbWUiOiJtLnNvdHRhbmFAZWdlYXRlY2guY29tIiwicGljdHV ▶"
 * "scope" => "openid profile email"
 * "expires_in" => 86400
 * "token_type" => "Bearer"
 * ]
 * }
 */
