<?php

declare(strict_types=1);

namespace Modules\User\Actions\Team;

use Modules\User\Models\TeamUser;
use Spatie\QueueableAction\QueueableAction;

class GetUserTeamsOptionAction
{
    use QueueableAction;

    public function execute(): array
    {
        $teams = TeamUser::where('user_id', authId())->get();

        return ['' => '--- Select ---'] + $teams->pluck('team.name', 'team.id')->toArray();
    }
}
