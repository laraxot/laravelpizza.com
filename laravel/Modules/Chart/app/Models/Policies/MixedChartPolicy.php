<?php

declare(strict_types=1);

namespace Modules\Chart\Models\Policies;

use Modules\Chart\Models\MixedChart;
use Modules\Xot\Contracts\UserContract;

class MixedChartPolicy extends ChartBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('mixed_chart.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, MixedChart $mixed_chart): bool
    {
        return $user->hasPermissionTo('mixed_chart.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('mixed_chart.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, MixedChart $mixed_chart): bool
    {
        return $user->hasPermissionTo('mixed_chart.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, MixedChart $mixed_chart): bool
    {
        return $user->hasPermissionTo('mixed_chart.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, MixedChart $mixed_chart): bool
    {
        return $user->hasPermissionTo('mixed_chart.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, MixedChart $mixed_chart): bool
    {
        return $user->hasPermissionTo('mixed_chart.forceDelete');
    }
}
