<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Modules\Xot\Models\Policies\XotBasePolicy;

class PerformanceFondoPolicy extends XotBasePolicy
{
    public function distribuisciSoldiIndividuale(mixed $user, mixed $post): bool
    {
        return true;
    }

    public function distribuisciSoldiOrganizzativa(mixed $user, mixed $post): bool
    {
        return true;
    }

    public function xlsSoldiIndividuale(mixed $user, mixed $post): bool
    {
        return true;
    }

    public function xlsSoldiOrganizzativa(mixed $user, mixed $post): bool
    {
        return true;
    }
}
