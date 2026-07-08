<?php

declare(strict_types=1);

namespace Modules\Progressioni\Models\Policies;

use Illuminate\Database\Eloquent\Model;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;

class AssenzePolicy extends XotBasePolicy
{
    public function cloneLastYear(UserContract $userContract, Model $model): bool
    {
        return true;
    }

    public function populateFromLastYear(UserContract $userContract, Model $model): bool
    {
        return true;
    }
}
