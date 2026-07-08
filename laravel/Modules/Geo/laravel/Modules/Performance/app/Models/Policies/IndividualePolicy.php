<?php

declare(strict_types=1);

namespace Modules\Performance\Models\Policies;

use Modules\Performance\Models\Individuale as MyModel;
use Modules\User\Models\User;
use Modules\Xot\Contracts\UserContract;
use Modules\Xot\Models\Policies\XotBasePolicy;
use Override;

class IndividualePolicy extends BaseIndividualePolicy
{
    #[Override]
    public function viewAny(?UserContract $user): bool
    {
        if (get_class($this) == 'Modules\Performance\Models\Policies\IndividualePolicy') {
            $user = auth()->user();

            return $user?->isSuperAdmin() ?? false;
        }

        return true;
    }

    
}
