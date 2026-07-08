<?php

declare(strict_types=1);

namespace Modules\IndennitaResponsabilita\Models\Policies;

use Illuminate\Database\Eloquent\Collection;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita;
use Modules\IndennitaResponsabilita\Models\IndennitaResponsabilita as Post;
use Modules\IndennitaResponsabilita\Models\Rating;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class IndennitaResponsabilitaPolicy extends XotBasePolicy
{
    /**
     * Determine whether the user can compila the model.
     */
    public function compila(UserContract $user, ?Post $post = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view any models.
     */
    #[Override]
    public function viewAny(UserContract $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, ?Post $post = null): bool
    {
        return true;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return false;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, ?Post $post = null): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager']);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, ?Post $post = null): bool
    {
        return $user->hasRole(['super-admin', 'admin', 'hr-manager']);
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(UserContract $user, ?Post $post = null): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(UserContract $user, Post $post): bool
    {
        return false;
    }

    public function sendMail(UserContract $user, Post $post): bool
    {
        return true;
    }

    public function recordPdf(UserContract $user, Post $record): bool
    {
        /** @var IndennitaResponsabilita $record */
        /** @var Collection<int, Rating> $ratings */
        $ratings = $record->ratings;
        // $ratings is always a Collection, not null
        /** @var float|int $sum */
        $sum = $ratings->sum('pivot.value');

        return $sum > 0;
    }
}
