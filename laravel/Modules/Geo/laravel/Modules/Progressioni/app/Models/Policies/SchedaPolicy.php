<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

use Modules\Progressioni\Models\Scheda;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class SchedaPolicy extends XotBasePolicy
{
    #[Override]
    public function before(UserContract $user, string $ability): ?bool
    {
        return null;
    }

    #[Override]
    public function viewAny(UserContract $userContract): bool
    {
        return true;
    }

    public function index(UserContract $userContract, Scheda $model): bool
    {
        return true;
    }

    public function edit(UserContract $userContract, Scheda $model): bool
    {
        return false;
    }

    public function destroy(UserContract $userContract, Scheda $model): bool
    {
        return false;
    }

    public function update(UserContract $userContract, Scheda $model): bool
    {
        return true;
    }

    public function create(UserContract $userContract): bool
    {
        return false;
    }

    public function schedaMassMail(UserContract $userContract, Scheda $model): bool
    {
        return true;
    }

    public function xlsrows(UserContract $userContract, Scheda $model): bool
    {
        return true;
    }

    public function graduatoriaPdf(UserContract $userContract, Scheda $model): bool
    {
        return true;
    }

    public function compila(UserContract $userContract, Scheda $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function schedaPdf(UserContract $userContract, Scheda $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function schedaMail(UserContract $userContract, Scheda $model): bool
    {
        return (bool) $model->ha_diritto;
    }

    public function sendMail(UserContract $userContract, Scheda $model): bool
    {
        return (bool) $model->ha_diritto;
    }
}
