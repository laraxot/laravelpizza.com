<?php

declare(strict_types=1);

namespace Modules\Meetup\Actions\Profile;

use Illuminate\Support\Facades\DB;
use Modules\Meetup\Datas\OwnProfileData;
use Modules\Meetup\Models\Profile;
use Modules\User\Models\User;
use Spatie\QueueableAction\QueueableAction;

/**
 * Salva nome, biografia e lingua preferita del partecipante.
 * Nome e cognome stanno sia sull'utente (email, menu, iscritti) sia sul profilo (pagina pubblica): restano allineati.
 */
final class UpdateOwnProfileAction
{
    use QueueableAction;

    public function __construct(private readonly ResolveOwnProfileAction $resolveProfile) {}

    public function execute(User $user, OwnProfileData $data): Profile
    {
        $firstName = trim($data->first_name);
        $lastName = trim($data->last_name);
        $bio = $data->bio === null ? null : trim($data->bio);
        $supported = array_keys((array) config('laravellocalization.supportedLocales', []));
        $locale = \in_array($data->locale, $supported, true) ? $data->locale : null;

        return DB::transaction(function () use ($user, $firstName, $lastName, $bio, $locale): Profile {
            $user->forceFill([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'name' => trim($firstName.' '.$lastName),
            ]);
            if ($locale !== null) {
                $user->forceFill(['lang' => $locale]);
            }
            $user->save();

            $profile = $this->resolveProfile->execute($user);
            $profile->forceFill([
                'first_name' => $firstName,
                'last_name' => $lastName,
                'bio' => $bio === '' ? null : $bio,
                'locale' => $locale,
            ])->save();

            return $profile;
        });
    }
}
