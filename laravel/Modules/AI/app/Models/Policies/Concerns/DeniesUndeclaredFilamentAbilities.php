<?php

declare(strict_types=1);

namespace Modules\Xot\Models\Policies\Concerns;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;

/**
 * Nega le abilità che Filament interroga sulle resource e che la policy non dichiara.
 *
 * Filament considera consentita un'abilità quando la policy non ha il metodo
 * corrispondente: senza questo trait chi ha `viewAny` potrebbe usare eliminazione
 * massiva, ripristino, riordino o collegamento di relazioni. Una policy che vuole
 * concedere una di queste abilità ridefinisce il metodo. Il super-admin passa
 * comunque da `XotBasePolicy::before()`.
 */
trait DeniesUndeclaredFilamentAbilities
{
    public function deleteAny(UserContract $user): bool
    {
        return false;
    }

    public function forceDeleteAny(UserContract $user): bool
    {
        return false;
    }

    public function restoreAny(UserContract $user): bool
    {
        return false;
    }

    public function reorder(UserContract $user): bool
    {
        return false;
    }

    public function replicate(UserContract $user, Model $record): bool
    {
        return false;
    }

    public function attach(UserContract $user): bool
    {
        return false;
    }

    public function associate(UserContract $user): bool
    {
        return false;
    }

    public function detach(UserContract $user, Model $record): bool
    {
        return false;
    }

    public function detachAny(UserContract $user): bool
    {
        return false;
    }

    public function dissociate(UserContract $user, Model $record): bool
    {
        return false;
    }

    public function dissociateAny(UserContract $user): bool
    {
        return false;
    }
}
