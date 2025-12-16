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
interface InvitesTeamMembers
{
    public function invite(
        UserContract $userContract,
        TeamContract $teamContract,
        string $email,
        ?string $role = null,
    ): void;
}
