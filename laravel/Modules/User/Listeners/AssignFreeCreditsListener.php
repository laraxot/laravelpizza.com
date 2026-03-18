<?php

declare(strict_types=1);

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;

/**
 * Listener per assegnare crediti iniziali gratuiti ai nuovi utenti.
 *
 * Richiede il modulo Predict con Profile (credits). Se assente, non esegue nulla.
 */
class AssignFreeCreditsListener
{
    /**
     * Crediti iniziali gratuiti per nuovi utenti.
     */
    private const FREE_STARTING_CREDITS = 500;

    /**
     * Handle the event.
     */
    public function handle(Registered $event): void
    {
        if (! class_exists('Modules\\Predict\\Models\\Profile')) {
            return;
        }

        $user = $event->user;
        if (! $user instanceof Authenticatable) {
            return;
        }

        $userId = $user->getAuthIdentifier();
        if (null === $userId) {
            return;
        }

        /** @var \Modules\Predict\Models\Profile $profile */
        $profile = \Modules\Predict\Models\Profile::firstOrCreate(
            ['user_id' => $userId],
            ['credits' => self::FREE_STARTING_CREDITS]
        );

        if (0 === $profile->credits) {
            $profile->update(['credits' => self::FREE_STARTING_CREDITS]);
        }
    }
}
