<?php

declare(strict_types=1);

namespace Modules\Lang\Models\Policies;

use Modules\Lang\Models\TranslationFile;
use Modules\Xot\Contracts\UserContract;

class TranslationFilePolicy extends LangBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('translation_file.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, TranslationFile $translationFile): bool
    {
        unset($translationFile);

        return $user->hasPermissionTo('translation_file.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('translation_file.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, TranslationFile $translationFile): bool
    {
        unset($translationFile);

        return $user->hasPermissionTo('translation_file.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, TranslationFile $translationFile): bool
    {
        unset($translationFile);

        return $user->hasPermissionTo('translation_file.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, TranslationFile $translationFile): bool
    {
        unset($translationFile);

        return $user->hasPermissionTo('translation_file.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, TranslationFile $translationFile): bool
    {
        unset($translationFile);

        return $user->hasPermissionTo('translation_file.forceDelete');
    }
}
