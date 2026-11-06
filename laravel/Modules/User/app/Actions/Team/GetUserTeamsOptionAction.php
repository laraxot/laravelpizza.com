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
        $result = [];
        foreach ($teams as $teamUser) {
            if ($teamUser->team !== null) {
                $result[(string) $teamUser->team->name] = (string) $teamUser->team->id;
            }
        }

        return $result;
    }
}
