<?php

declare(strict_types=1);

namespace Modules\Ptv\Models\Policies;

use Modules\Ptv\Models\Profile as Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class ProfilePolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager', 'evaluator']);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Model $model): bool
    {
        if (! $model->exists) {
            return false;
        }

        if ($user->hasRole(['super-admin', 'admin', 'hr-manager'])) {
            return true;
        }

        if ($user->hasRole('evaluator') && $this->canEvaluate($user, $model)) {
            return true;
        }

        return $this->isSameProfile($user, $model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Model $model): bool
    {
        return $model->exists
            && ($user->hasRole(['super-admin', 'admin', 'hr-manager']) || $this->isSameProfile($user, $model));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Model $model): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Model $model): bool
    {
        return $user->hasRole('super-admin');
    }

    /**
     * Determine if the user can evaluate the profile.
     *
     * @phpstan-ignore-next-line return.tooWideBool
     */
    private function canEvaluate(UserContract $user, Model $model): bool
    {
        return $model->exists
            && $model->valutatore_id !== null
            && $user->hasRole('evaluator')
            && $user->profile !== null
            && $user->profile->id === (int) $model->valutatore_id;
    }

    private function isSameProfile(UserContract $user, Model $model): bool
    {
        if (! $model->exists || $user->profile === null) {
            return false;
        }

        return (int) $user->profile->id === (int) $model->id;
    }
}
