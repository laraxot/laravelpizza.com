<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;

class IndividualeAssenzePolicy extends XotBasePolicy
{
    public function refreshAssenzeFields(mixed $user, mixed $post): bool
    {
        return true;
    }
}
