<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\Traits\GeographicalScopes;

final class GeographicalScopesPhpstanProbe extends GeoPhpstanProbeModel
{
    use GeographicalScopes;
}
