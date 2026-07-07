<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Fixtures\Traits;

use Modules\Tenant\Models\Traits\SushiToPhpArray;

final class SushiToPhpArrayPhpstanProbe extends TenantPhpstanProbeModel
{
    use SushiToPhpArray;
}
