<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\Traits\SushiToJsons;

final class SushiToJsonsPhpstanProbe extends GeoPhpstanProbeModel
{
    use SushiToJsons;
}
