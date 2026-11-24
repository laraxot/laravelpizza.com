<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Xot;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Tenant;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\XotService::getTenantClass().
<<<<<<< .merge_file_cULJzQ
 *
 * @see docs/contracts/get-tenant-class-action.md
 *
=======
 * @see docs/contracts/get-tenant-class-action.md
>>>>>>> .merge_file_0YL7pZ
 * @contract docs/contracts/get-tenant-class-action.md
 */
class GetTenantClassAction
{
    use QueueableAction;

    /**
     * @return class-string<Model>
     */
    public function execute(): string
    {
        return Tenant::class;
    }
}
