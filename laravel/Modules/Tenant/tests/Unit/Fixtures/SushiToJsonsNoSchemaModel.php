<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJsons;

/**
 * Named subclass without schema property — covers empty resolveSchema / write failures.
 */
final class SushiToJsonsNoSchemaModel extends Model
{
    use SushiToJsons;

    protected $table = 'sushi_jsons_noschema';
}
