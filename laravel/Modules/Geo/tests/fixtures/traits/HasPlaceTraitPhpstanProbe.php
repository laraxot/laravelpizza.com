<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\Traits\HasPlaceTrait;

final class HasPlaceTraitPhpstanProbe extends GeoPhpstanProbeModel
{
    use HasPlaceTrait;
}
