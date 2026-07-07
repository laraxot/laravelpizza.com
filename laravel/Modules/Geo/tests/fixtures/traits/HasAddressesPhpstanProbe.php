<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Traits\HasAddresses;

final class HasAddressesPhpstanProbe extends GeoPhpstanProbeModel
{
    use HasAddresses;
}
