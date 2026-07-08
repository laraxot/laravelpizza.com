<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class CriteriEsclusionePolicy extends XotBasePolicy
{
    public function checkGgCatecoPosfunNoAsz(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function populateFromLastYear(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function trovaEsclusi(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function findStabi0(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function syncProgressioniRepQua(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function xlsProgressioni(UserContract $userContract, Model $model): bool
    {
        return true;
    }
}
