<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToJson;

/**
 * Named subclass for SushiToJson trait coverage (no getJsonFile override).
 */
class SushiToJsonCoverageModel extends Model
{
    use SushiToJson;

    protected $table = 'sushi_json_coverage';

    /** @var array<string, string> */
    protected array $schema = [
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

    /**
     * @return array<string, string>
     */
    public function getSchema(): array
    {
        return $this->schema;
    }
}
