<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Policies;

use Modules\Chart\Models\Chart;
use Modules\Xot\Contracts\UserContract;

class ChartPolicy extends ChartBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('chart.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Chart $chart): bool
    {
        return $user->hasPermissionTo('chart.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('chart.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Chart $chart): bool
    {
        return $user->hasPermissionTo('chart.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Chart $chart): bool
    {
        return $user->hasPermissionTo('chart.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Chart $chart): bool
    {
        return $user->hasPermissionTo('chart.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Chart $chart): bool
    {
        return $user->hasPermissionTo('chart.forceDelete');
    }
}
