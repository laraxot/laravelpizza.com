<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

// //use Modules\Xot\Traits\XotBasePolicyTrait; //DEPRECATED
use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class StabiDirigentePolicy extends XotBasePolicy
{
    public function syncStabi(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function populateFromLastYear(UserContract $userContract, Model $model): bool
    {
        return true;
    }
}
