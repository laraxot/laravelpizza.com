<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Modules\User\Models\OauthRefreshToken;
use Spatie\QueueableAction\QueueableAction;

/**
 * RevokeRefreshTokenAction: Revoca un refresh token OAuth2.
 */
class RevokeRefreshTokenAction
{
    use QueueableAction;

    public function __construct(
        private readonly OauthRefreshToken $refreshTokenModel,
    ) {
    }

    /**
     * Revoca un refresh token OAuth2.
     *
     * @param OauthRefreshToken|string $token Il token da revocare (istanza o ID)
     *
     * @return bool True se il token è stato revocato con successo
     */
    public function execute(OauthRefreshToken|string $token): bool
    {
        if (is_string($token)) {
            $token = $refreshTokenModel->find($token);
        }

        if (! $token instanceof OauthRefreshToken) {
            return false;
        }

        $token->revoked = true;
        $token->save();

        return true;
    }
}
