<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\Traits\GeoTrait;

final class GeoTraitPhpstanProbe extends GeoPhpstanProbeModel
{
    use GeoTrait;
}
