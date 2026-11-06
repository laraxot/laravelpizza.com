<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * Named subclass for SushiToCsv trait coverage.
 */
class SushiToCsvCoverageModel extends Model
{
    use SushiToCsv;

    protected $table = 'sushi_csv_coverage';

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
        'updated_at' => 'datetime',
        'updated_by' => 'integer',
        'created_at' => 'datetime',
        'created_by' => 'integer',
    ];

    protected $fillable = [
        'name',
        'updated_at',
        'updated_by',
        'created_at',
        'created_by',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }
}
