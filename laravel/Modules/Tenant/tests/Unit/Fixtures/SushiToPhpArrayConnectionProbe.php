<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToPhpArray;

/**
 * Sonda per SushiConnectionByName: righe fisse, nessun file di config tenant.
 */
final class SushiToPhpArrayConnectionProbe extends Model
{
    use SushiToPhpArray;

    protected $table = 'sushi_php_array_connection_probe';

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
