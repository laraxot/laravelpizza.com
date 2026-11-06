<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJsons;

/**
 * Named subclass with non-array schema property.
 */
final class SushiToJsonsInvalidSchemaModel extends Model
{
    use SushiToJsons;

    protected $table = 'sushi_jsons_invalid_schema';

    protected string $schema = 'invalid';
}
