<?php

declare(strict_types=1);

namespace Modules\Gdpr\Models\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Datas\XotData;

abstract class GdprBasePolicy
{
    use HandlesAuthorization;

    public function before(UserContract $user, string $_ability): ?bool
    {
        if (XotData::make()->super_admin === $user->email) {
            return true;
        }

        return null;
    }
}
