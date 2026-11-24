<?php

declare(strict_types=1);

namespace Modules\Geo\Tests\Fixtures\Traits;

use Illuminate\Database\Eloquent\Model;
use Modules\Geo\Models\Traits\GeographicalScopes;

/**
 * Model fixture for the GeographicalScopes contract (scopes costruiti senza toccare il database).
 */
final class GeographicalScopesTestModel extends Model
{
    use GeographicalScopes;

    protected $table = 'places';
}
