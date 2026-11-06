<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;

/**
 * @property int|string|null $id
 * @property mixed|null      $address
 */
abstract class GeoPhpstanProbeModel extends BaseModel
{
    protected $table = 'geo_phpstan_trait_probes';
}
