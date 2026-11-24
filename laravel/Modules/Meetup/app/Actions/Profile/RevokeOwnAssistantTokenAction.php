<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Modules\User\Models\User;

/**
 * Revoca un token personale dell'utente: l'assistente collegato con quel token smette subito di funzionare.
 * Solo i token dell'utente stesso: un id di un altro utente non trova niente e restituisce false.
 */
final class RevokeOwnAssistantTokenAction
{
    public function execute(User $user, string $tokenId): bool
    {
        return $user->tokens()
            ->whereKey($tokenId)
            ->where('revoked', false)
            ->update(['revoked' => true]) > 0;
    }
}
