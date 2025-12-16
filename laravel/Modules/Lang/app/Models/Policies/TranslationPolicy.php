<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Policies;

use Modules\Lang\Models\Translation;
use Modules\Xot\Contracts\UserContract;

class TranslationPolicy extends LangBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('translation.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Translation $translation): bool
    {
        unset($translation);

        return $user->hasPermissionTo('translation.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('translation.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Translation $translation): bool
    {
        unset($translation);

        return $user->hasPermissionTo('translation.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Translation $translation): bool
    {
        unset($translation);

        return $user->hasPermissionTo('translation.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, Translation $translation): bool
    {
        unset($translation);

        return $user->hasPermissionTo('translation.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Translation $translation): bool
    {
        unset($translation);

        return $user->hasPermissionTo('translation.forceDelete');
    }
}
