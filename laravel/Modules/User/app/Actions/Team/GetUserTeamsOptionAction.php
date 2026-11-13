<?php

declare(strict_types=1);

namespace Modules\User\Actions\Team;

use Modules\User\Models\TeamUser;
use Spatie\QueueableAction\QueueableAction;

class GetUserTeamsOptionAction
{
    use QueueableAction;

    /**
     * @return array<int|string, string>
     */
    public function execute(): array
    {
        $teams = TeamUser::with('team')->where('user_id', authId())->get();
        // Opzioni di una Select: chiave = id del team, valore = nome mostrato, piu' il placeholder vuoto.
        // Le righe team_user orfane (team cancellato) si saltano.
        $result = ['' => '--- Select ---'];
        foreach ($teams as $teamUser) {
            if ($teamUser->team !== null) {
                $result[(string) $teamUser->team->id] = (string) $teamUser->team->name;
            }
        }

        return $result;
    }
}
