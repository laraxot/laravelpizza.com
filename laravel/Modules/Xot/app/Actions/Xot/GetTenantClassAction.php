<?php

declare(strict_types=1);

namespace Modules\Xot\Actions\Xot;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Tenant;
use Spatie\QueueableAction\QueueableAction;

/**
 * Replaces Modules\Xot\Services\XotService::getTenantClass().
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
