<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;
use Modules\Geo\Models\Traits\GeographicalScopes;
use Modules\Geo\Models\Traits\GeoTrait;
use Modules\Geo\Models\Traits\HasPlaceTrait;
use Modules\Geo\Models\Traits\SushiToJsons;
use Modules\Geo\Traits\HasAddresses;

/**
 * Probe hosts so PHPStan analyses Geo traits used cross-module (SushiToJsons, HasAddresses, …).
 *
 * @property int|string|null $id
 * @property mixed|null      $address
 */
abstract class GeoPhpstanProbeModel extends BaseModel
{
    protected $table = 'geo_phpstan_trait_probes';
}

final class GeoTraitPhpstanProbe extends GeoPhpstanProbeModel
{
    use GeoTrait;
}

final class GeographicalScopesPhpstanProbe extends GeoPhpstanProbeModel
{
    use GeographicalScopes;
}

final class HasPlaceTraitPhpstanProbe extends GeoPhpstanProbeModel
{
    use HasPlaceTrait;
}

final class HasAddressesPhpstanProbe extends GeoPhpstanProbeModel
{
    use HasAddresses;
}

final class SushiToJsonsPhpstanProbe extends GeoPhpstanProbeModel
{
    use SushiToJsons;
}
