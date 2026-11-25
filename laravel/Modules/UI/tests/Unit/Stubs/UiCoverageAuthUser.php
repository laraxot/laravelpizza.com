<?php

declare(strict_types=1);

namespace Modules\UI\Tests\Unit\Stubs;

use Illuminate\Support\Collection;
use Modules\User\Models\Permission;
use Modules\User\Models\User;

/**
 * User in-memory per GetUserDataAction — evita Mockery property.notFound.
 *
 * Estende il `User` di dominio: `GetUserDataAction` risponde null a chi non implementa `UserContract`,
 * quindi un `Illuminate\Foundation\Auth\User` generico non arriva mai alla logica dell'avatar.
 * Ruoli e permessi sono in memoria: il test non apre connessioni.
 *
 * @see Modules/UI/docs/contracts/get-user-data-action.md
 */
final class UiCoverageAuthUser extends User
{
    public ?object $profile = null;

    public function relationLoaded($key): bool
    {
        // Solo `profile` e' simulato: le altre relazioni seguono il comportamento di Eloquent.
        if ($key === 'profile') {
            return $this->profile !== null;
        }

        return parent::relationLoaded($key);
    }

    /**
     * @return Collection<int, string>
     */
    public function getRoleNames(): Collection
    {
        return collect(['admin']);
    }

    /**
     * Permessi in memoria vuoti: stub coverage senza DB.
     *
     * @return Collection<int, Permission>
     */
    public function getAllPermissions(): Collection
    {
        return new Collection;
    }
}
