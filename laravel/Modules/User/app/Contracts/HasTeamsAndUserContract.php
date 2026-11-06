<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Modules\User\Models\Team;
use Modules\Xot\Contracts\UserContract;

/**
 * Interfaccia che combina le funzionalità di HasTeamsContract e UserContract.
 */
interface HasTeamsAndUserContract extends HasTeamsContract, UserContract
{
    public function canRemoveTeamMember(Team $team, HasTeamsContract $user): bool;

    /**
     * Verifica se l'utente può aggiornare un membro del team.
     */
    public function canUpdateTeamMember(Team $team, HasTeamsContract $user): bool;
}
