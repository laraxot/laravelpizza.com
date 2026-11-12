<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Modules\Meetup\Models\Profile;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Profilo dell'utente (lo stesso di `$user->profile`), creato al primo uso: gli account nati prima dei profili (o dal pannello) possono non averne uno.
 */
final class ResolveOwnProfileAction
{
    use QueueableAction;

    public function execute(User $user): Profile
    {
        // Stessa relazione che usano le viste (User::profile, HasOne): leggere con una query propria rischiava di
        // scrivere su un profilo diverso da quello mostrato se per errore l'utente ne ha più di uno.
        $profile = $user->profile()->first();
        if ($profile instanceof Profile) {
            return $profile;
        }

        return Profile::query()->create([
            'user_id' => $user->getKey(),
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
        ]);
    }
}
