<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\Traits\GeoTrait;

/** Fixture per gli scope distanza di GeoTrait (SQL + binding, senza DB). */
final class GeographicalScopesTestModel extends Model
{
    use GeoTrait;

    protected $table = 'places';
}
