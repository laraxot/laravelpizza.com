<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Nuova password scelta dal partecipante (la password attuale è già stata verificata dal form).
 * Le altre sessioni aperte con la vecchia password vengono chiuse; quella corrente resta valida.
 */
final class ChangeOwnPasswordAction
{
    use QueueableAction;

    public function execute(User $user, string $newPassword): void
    {
        $user->forceFill([
            'password' => Hash::make($newPassword),
            'remember_token' => Str::random(60),
        ])->save();

        if (Auth::guard('web')->id() === $user->getKey()) {
            Auth::guard('web')->logoutOtherDevices($newPassword);
        }
    }
}
