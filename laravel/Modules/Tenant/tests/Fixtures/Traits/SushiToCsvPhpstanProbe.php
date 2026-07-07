<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Fixtures\Traits;

use Modules\Tenant\Models\Traits\SushiToCsv;

final class SushiToCsvPhpstanProbe extends TenantPhpstanProbeModel
{
    use SushiToCsv;
}
