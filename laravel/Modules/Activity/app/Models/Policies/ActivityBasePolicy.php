<?php

declare(strict_types=1);

namespace Modules\Activity\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class ActivityBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
