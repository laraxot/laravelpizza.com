<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;

abstract class ChartBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $ability): ?bool
    {
        if ($user->hasRole('super-admin')) {
            return true;
        }

        if ($ability === 'viewAny' && $user->hasPermissionTo('chart.viewAny')) {
            return true;
        }

        return null;
    }
}
