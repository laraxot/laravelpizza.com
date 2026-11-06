<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * Sonda per SushiConnectionByName: righe fisse, nessun CSV su disco.
 */
final class SushiToCsvConnectionProbe extends Model
{
    use SushiToCsv;

    protected $table = 'sushi_csv_connection_probe';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return [
            [
                'id' => 1,
                'name' => 'ttt',
            ],
        ];
    }
}
