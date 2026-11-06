<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Spatie\QueueableAction\QueueableAction;

/**
 * Reinvia la mail di verifica indirizzo, senza verificare nulla (DCP-285, D-04).
 *
 * Un indirizzo gia' verificato non riceve nulla. L'evento `Verified` non si lancia qui: dice che l'indirizzo E' STATO verificato,
 * e lo emettono solo i controller che controllano id e hash prima di `markEmailAsVerified()`.
 */
class ResendEmailVerificationAction
{
    use QueueableAction;

    /**
     * @return bool true se la notifica e' stata inviata, false se l'indirizzo era gia' verificato
     */
    public function execute(MustVerifyEmail $user): bool
    {
        if ($user->hasVerifiedEmail()) {
            return false;
        }

        $user->sendEmailVerificationNotification();

        return true;
    }
}
