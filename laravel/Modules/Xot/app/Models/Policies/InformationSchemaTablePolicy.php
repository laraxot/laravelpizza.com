<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies;

use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\InformationSchemaTable;
use Override;

class InformationSchemaTablePolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return $user->hasPermissionTo('information_schema_table.viewAny');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, InformationSchemaTable $_information_schema_table): bool
    {
        return $user->hasPermissionTo('information_schema_table.view');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $user->hasPermissionTo('information_schema_table.create');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, InformationSchemaTable $_information_schema_table): bool
    {
        return $user->hasPermissionTo('information_schema_table.update');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, InformationSchemaTable $_information_schema_table): bool
    {
        return $user->hasPermissionTo('information_schema_table.delete');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, InformationSchemaTable $_information_schema_table): bool
    {
        return $user->hasPermissionTo('information_schema_table.restore');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, InformationSchemaTable $information_schema_table): bool
    {
        return $user->hasPermissionTo('information_schema_table.forceDelete');
    }
}
