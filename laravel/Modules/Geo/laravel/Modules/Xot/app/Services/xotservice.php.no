<?php

declare(strict_types=1);

namespace Modules\Xot\Services;

use Illuminate\Database\Eloquent\Model;
use Modules\User\Models\Tenant;

class XotService
{
    /**
     * Get the tenant class name.
     *
     * @return class-string<Model>
     */
    public function getTenantClass(): string
    {
        return Tenant::class;
    }
}
