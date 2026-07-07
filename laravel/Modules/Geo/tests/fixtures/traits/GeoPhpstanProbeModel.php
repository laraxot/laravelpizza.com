<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Modules\Geo\Models\BaseModel;

/**
 * @property int|string|null $id
 *                                    <<<<<<< HEAD
 *                                    <<<<<<< HEAD
 * @property mixed|null      $address
 *                                    =======
 * @property mixed|null      $address
 *                                    >>>>>>> e3f0965 (.)
 *                                    =======
 * @property mixed|null      $address
 *                                    >>>>>>> 225c1bf (delete .claude-flow/)
 */
abstract class GeoPhpstanProbeModel extends BaseModel
{
    protected $table = 'geo_phpstan_trait_probes';
}
