<?php

declare(strict_types=1);

namespace Modules\User\Contracts;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

/**
 * ---.
 *
 * @phpstan-require-extends Model
 */
interface RemovesTeamMembers
{
    public function remove(UserContract $user, TeamContract $teamContract, UserContract $teamMember): void;
}
