<?php

declare(strict_types=1);

namespace Modules\Geo\Datas;

use Modules\Xot\Datas\Concerns\MakesFromTenantConfig;
use Spatie\LaravelData\Data;

/** Tenant configuration contract for Geo's settings entry point. */
final class GeoConfigData extends Data
{
    use MakesFromTenantConfig;

    public bool $enabled = true;
}
