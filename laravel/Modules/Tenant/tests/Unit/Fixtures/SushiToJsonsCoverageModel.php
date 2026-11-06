<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Modules\Tenant\Models\BaseModelJsons;

/**
 * Fixture di coverage: stesso trait dell'host reale `BaseModelJsons`.
 *
 * @property string|null $name
 */
final class SushiToJsonsCoverageModel extends BaseModelJsons
{
    protected $table = 'sushi_jsons_coverage';

    /** @var array<string, string>|string */
    protected $schema = [
        'id' => 'integer',
        'name' => 'string',
        'meta' => 'string',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'created_by' => 'integer',
        'updated_by' => 'integer',
    ];

    protected $fillable = [
        'name',
        'meta',
        'created_by',
        'updated_by',
    ];
}
