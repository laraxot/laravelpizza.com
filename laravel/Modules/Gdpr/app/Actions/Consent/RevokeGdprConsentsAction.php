<?php

declare(strict_types=1);

namespace Modules\Gdpr\Actions\Consent;

use Modules\Gdpr\Models\Consent;
use Modules\User\Models\BaseUser;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Spatie\QueueableAction\QueueableAction;

/**
 * Revoca tutti i consensi Gdpr di un utente (art. 7.3 GDPR).
 *
 * Non cancella i record: imposta `revoked_at` e `revoked_ip_address` per
 * conservare l'audit trail (art. 30). I consensi sono comunque cancellati
 * in cascata al soft-delete dell'utente.
 *
 * Usa solo colonne che esistono in `consents` (DCP-285, D-02). L'utente si riconosce da `user_id` + `user_type`, la chiave comune a
 * tutti i percorsi di scrittura: `user_type` e' la classe (SaveGdprConsentsAction) o l'alias morph (HasGdpr::giveConsent).
 * Lo user agent della revoca non e' salvato: manca la colonna `revoked_user_agent` (richiesta di schema nella story DCP-285).
 */
class RevokeGdprConsentsAction
{
    use QueueableAction;

    public function execute(BaseUser $user): void
    {
        Consent::query()
            ->where('user_id', SafeStringCastAction::cast($user->getKey()))
            ->whereIn('user_type', array_values(array_unique([$user->getMorphClass(), $user::class])))
            ->whereNull('revoked_at')
            ->update([
                'revoked_at' => now(),
                'revoked_ip_address' => request()->ip(),
                'updated_by' => auth()->id() ?? $user->getKey(),
            ]);
    }
}
