<?php

declare(strict_types=1);

namespace Modules\User\Models\Policies;

use Illuminate\Database\Eloquent\Model as EloquentModel;
use Modules\User\Models\BaseUser as Model;
use Modules\Xot\Actions\Cast\SafeStringCastAction;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

/**
 * Autorizzazione sugli utenti (DCP-285, D-06).
 *
 * `super-admin` passa da `XotBasePolicy::before()`. Gli altri ruoli che amministrano gli utenti sono `admin` e `user::admin`
 * (il ruolo che apre il pannello del modulo User, vedi `BaseUser::canAccessPanel`). Chiunque altro vede e aggiorna solo se stesso.
 * Nessuno cancella se stesso, nemmeno il super-admin: la regola sta in `before()`, che per il super-admin altrimenti direbbe sempre si'.
 */
class BaseUserPolicy extends XotBasePolicy
{
    /**
     * Ruoli che amministrano gli utenti, oltre a `super-admin`.
     *
     * @var list<string>
     */
    public const array ADMIN_ROLES = ['admin', 'user::admin'];

    /**
     * Abilita' che non si esercitano mai sul proprio utente.
     *
     * @var list<string>
     */
    private const array NEVER_ON_SELF = ['delete', 'forceDelete'];

    public function before(UserContract $user, string $ability, mixed ...$arguments): ?bool
    {
        $target = $arguments[0] ?? null;
        if ($target instanceof Model && \in_array($ability, self::NEVER_ON_SELF, true) && $this->isSelf($user, $target)) {
            return false;
        }

        return parent::before($user, $ability);
    }

    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(UserContract $user): bool
    {
        return $this->isUserAdmin($user);
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(UserContract $user, Model $model): bool
    {
        return $this->isUserAdmin($user) || $this->isSelf($user, $model);
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(UserContract $user): bool
    {
        return $this->isUserAdmin($user);
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(UserContract $user, Model $model): bool
    {
        return ($this->isUserAdmin($user) || $this->isSelf($user, $model)) && ! $this->isSuperAdmin($model);
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(UserContract $user, Model $model): bool
    {
        return $this->isUserAdmin($user) && ! $this->isSelf($user, $model) && ! $this->isSuperAdmin($model);
    }

    /**
     * Self-service account deletion from the front office (GDPR art. 17): only the own account.
     * `delete` stays the back-office ability (an admin removes other users, never themselves).
     */
    public function deleteOwnAccount(UserContract $user, Model $model): bool
    {
        return $this->isSelf($user, $model);
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
        return $user->hasRole('super-admin') && ! $this->isSelf($user, $model);
    }

    /**
     * Cancellazione in blocco: ogni record passa comunque da {@see self::delete()}, qui decide solo chi vede l'azione.
     */
    public function deleteAny(UserContract $user): bool
    {
        return $this->isUserAdmin($user);
    }

    /**
     * Abilita' secondarie: Filament, senza il metodo sulla policy, le considera consentite. Solo il super-admin (via before()).
     */
    public function restoreAny(UserContract $user): bool
    {
        return false;
    }

    public function forceDeleteAny(UserContract $user): bool
    {
        return false;
    }

    /**
     * Replication is intentionally denied for every Eloquent model in this policy.
     * Keep the base-policy parameter broad so the override remains substitutable.
     */
    public function replicate(UserContract $user, EloquentModel $model): bool
    {
        return false;
    }

    public function reorder(UserContract $user): bool
    {
        return false;
    }

    protected function isUserAdmin(UserContract $user): bool
    {
        return $user->hasRole(self::ADMIN_ROLES);
    }

    /**
     * Un amministratore di modulo non modifica ne' cancella un super-admin: altrimenti cambiandone la password lo diventa.
     */
    protected function isSuperAdmin(Model $model): bool
    {
        return $model->hasRole('super-admin');
    }

    protected function isSelf(UserContract $user, Model $model): bool
    {
        $id = SafeStringCastAction::cast($user->getAuthIdentifier());

        return $id !== '' && $id === SafeStringCastAction::cast($model->getAuthIdentifier());
    }
}
