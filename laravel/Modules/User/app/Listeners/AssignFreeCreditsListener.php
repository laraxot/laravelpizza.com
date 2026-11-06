<?php

declare(strict_types=1);

namespace Modules\User\Listeners;

use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Modules\Predict\Models\Profile;

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
    private const int FREE_STARTING_CREDITS = 500;

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
        if ($userId === null) {
            return;
        }

        /** @var Profile $profile */
        $profile = Profile::firstOrCreate(
            ['user_id' => $userId],
            ['credits' => self::FREE_STARTING_CREDITS]
        );

        if ($profile->credits === 0) {
            $profile->update(['credits' => self::FREE_STARTING_CREDITS]);
        }
    }
}
