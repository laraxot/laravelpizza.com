<?php

declare(strict_types=1);

namespace Modules\User\Actions\Passport;

use Modules\User\Models\OauthToken;
use Modules\Xot\Contracts\UserContract;
use Spatie\QueueableAction\QueueableAction;

/**
 * RevokeAllUserTokensAction: Revoca tutti i token di un utente.
 *
 * Questa action revoca tutti i token OAuth2 di un utente specifico,
 * utile per logout forzato o revoca di accesso.
 */
class RevokeAllUserTokensAction
{
    use QueueableAction;

    /**
     * Revoca tutti i token di un utente.
     *
     * @param UserContract|string $user L'utente di cui revocare i token (istanza o ID)
     *
     * @return int Numero di token revocati
     */
    public function execute(UserContract|string $user): int
    {
        return OauthToken::where('user_id', is_string($user) ? $user : $user->id)
            ->where('revoked', false)
            ->update(['revoked' => true]);
    }
}
