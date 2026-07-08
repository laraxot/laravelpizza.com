<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests;

use Modules\Tenant\Models\Tenant;

interface TenantContextSetter
{
    public function setCurrent(Tenant $tenant): void;
}
