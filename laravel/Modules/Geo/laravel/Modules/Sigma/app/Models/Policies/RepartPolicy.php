<?php

declare(strict_types=1);

namespace Modules\Sigma\Models\Policies;

use Modules\Sigma\Models\Repart as Post;
use Modules\Xot\Contracts\UserContract;

// use Modules\Xot\Traits\XotBasePolicyTrait; //DEPRECATED

class RepartPolicy
{
    // use HandlesAuthorization; e' dentro XotBasePolicyTrait
    // use XotBasePolicyTrait; //DEPRECATED

    public function before(UserContract $user): ?bool
    {
        // property_exists() non può essere usato sui modelli Eloquent perché gli attributi sono magici
        // Usiamo isset() che rispetta i magic methods __isset() di Eloquent
        if (! isset($user->perm)) {
            return null;
        }

        /** @var mixed $permRaw */
        $permRaw = $user->perm;
        if (! is_object($permRaw)) {
            return null;
        }

        /** @var object{perm_type?: int} $perm */
        $perm = $permRaw;
        if (! isset($perm->perm_type) || ! is_numeric($perm->perm_type)) {
            return null;
        }

        $permType = (int) $perm->perm_type;
        if ($permType < 5) {
            return null;
        }

        // superadmin
        return true;
    }

    /**
     * Determine whether the user can view any DocDummyPluralModel.
     */
    public function index(UserContract $_user, Post $_post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can edit the Repart model.
     *
     * Note: Repart model does not have created_by field, so all authenticated users can edit.
     */
    public function edit(UserContract $user, Post $post): bool
    {
        return true;
    }

    public function indexEdit(UserContract $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can update the Repart model.
     */
    public function update(UserContract $user, Post $post): bool
    {
        return true;
    }

    public function destroy(UserContract $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can delete the Repart model.
     */
    public function delete(UserContract $user, Post $post): bool
    {
        return true;
    }

    /**
     * Determine whether the user can restore the Repart model.
     *
     * Note: Repart model does not support soft deletes.
     */
    public function restore(UserContract $user, Post $post): bool
    {
        return false;
    }
}
