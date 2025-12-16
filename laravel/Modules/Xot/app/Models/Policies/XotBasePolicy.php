<?php

declare(strict_types=1);

/**
 * ----------------------------------------------------------------.
 */

namespace Modules\Xot\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

// use Modules\Xot\Datas\XotData;

abstract class XotBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $_ability): ?bool
    {
        return once(function () use ($user) {
            if ($user->hasRole('super-admin')) {
                return true;
            }
        });
    }

    public function viewAny(UserContract $userContract): bool
    {
        return false;
    }
}
