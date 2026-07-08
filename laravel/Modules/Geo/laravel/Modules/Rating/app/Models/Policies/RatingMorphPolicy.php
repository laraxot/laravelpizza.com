<?php

declare(strict_types=1);

namespace Modules\Rating\Models\Policies;

use Modules\Rating\Models\RatingMorph as Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class RatingMorphPolicy extends XotBasePolicy
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
        return $user->hasRole(['super-admin', 'admin', 'hr-manager'])
            || ($user->hasRole('evaluator') && $user->id === $model->user_id)
            || ($user->profile && $this->isOwner($user, $model));
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager', 'evaluator']);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager'])
            || ($user->hasRole('evaluator') && $user->id === $model->user_id)
            || ($user->profile && $this->isOwner($user, $model));
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Model $model): bool
    {
        return $user->hasRole(['super-admin', 'admin'])
            || ($user->hasRole('evaluator') && $user->id === $model->user_id);
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
     * Determine if the user is the owner of the rated model.
     */
    private function isOwner(UserContract $user, Model $model): bool
    {
        // Check if user owns the model being rated
        $ratedModel = $model->model;
        if (! $ratedModel) {
            return false;
        }

        // Check for common ownership patterns
        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        if (isset($ratedModel->user_id)) {
            if ($ratedModel->user_id === $user->id) {
                return true;
            }
        }

        // ✅ isset() invece di property_exists() - funziona per attributi magici Eloquent
        if (isset($ratedModel->matr) && $user->profile) {
            if ($ratedModel->matr === $user->profile->matr) {
                return true;
            }
        }

        return false;
    }
}
