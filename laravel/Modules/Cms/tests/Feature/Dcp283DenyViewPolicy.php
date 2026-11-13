<?php

declare(strict_types=1);

namespace Modules\Cms\Tests\Feature;

use Illuminate\Contracts\Auth\Authenticatable;

final class Dcp283DenyViewPolicy
{
    public function view(?Authenticatable $user, Dcp283Item $model): bool
    {
        return false;
    }
}
