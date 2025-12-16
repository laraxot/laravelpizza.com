<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class LangBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        unset($ability);
        if ($user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
