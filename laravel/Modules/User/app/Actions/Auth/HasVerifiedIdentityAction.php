<?php

declare(strict_types=1);

namespace Modules\User\Actions\Auth;

use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Spatie\QueueableAction\QueueableAction;

/**
 * Vero se l'identità dell'utente è verificata: email confermata oppure accesso con SPID o CIE (PRD-02).
 *
 * SPID e CIE garantiscono l'identità anche quando l'IdP non restituisce un'email: i controller del tema salvano
 * `spid.<CF>@noemail.local` con `email_verified_at` null, e il middleware `verified` di Laravel li bloccherebbe per sempre
 * (il link di verifica andrebbe a un indirizzo inesistente). Non rende l'email "verificata": le mail al cittadino
 * continuano a partire solo verso indirizzi confermati.
 */
final class HasVerifiedIdentityAction
{
    use QueueableAction;

    /** Valori di `users.auth_method` scritti dai controller SPID/CIE del tema Sixteen. */
    public const array TRUSTED_IDENTITY_METHODS = ['spid', 'cie'];

    public function execute(?Authenticatable $user): bool
    {
        if ($user === null) {
            return false;
        }

        if (! $user instanceof MustVerifyEmail || $user->hasVerifiedEmail()) {
            return true;
        }

        // Attributi grezzi, non getAttribute(): su un database non ancora migrato (`auth_method` arriva con
        // 2026_11_12_120000_create_users_table) Model::preventAccessingMissingAttributes() farebbe un 500.
        return $user instanceof Model
            && in_array($user->getAttributes()['auth_method'] ?? null, self::TRUSTED_IDENTITY_METHODS, true);
    }
}
