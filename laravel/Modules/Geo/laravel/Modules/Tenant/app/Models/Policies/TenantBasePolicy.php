<?php

declare(strict_types=1);

namespace Modules\Tenant\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class TenantBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        if ($ability !== '' && $user->hasRole('super-admin')) {
            return true;
        }

        return null;
    }
}
