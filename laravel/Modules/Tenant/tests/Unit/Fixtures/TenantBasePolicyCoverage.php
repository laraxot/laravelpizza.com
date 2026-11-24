<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Modules\Tenant\Models\Policies\TenantBasePolicy;

/**
 * Named concrete subclass to exercise TenantBasePolicy::before.
 */
final class TenantBasePolicyCoverage extends TenantBasePolicy {}
