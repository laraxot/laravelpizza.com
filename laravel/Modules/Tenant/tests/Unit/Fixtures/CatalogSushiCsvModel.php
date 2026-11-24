<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToCsv;

/**
 * Modello `catalog` letto da `catalog.csv` tramite SushiToCsv (classe con nome, non anonima).
 *
 * @property string|null $name
 */
final class CatalogSushiCsvModel extends Model
{
    use SushiToCsv;

    protected $table = 'catalog';

    /** @var array<string, string> */
    protected array $schema = [
        'id' => 'integer',
        'name' => 'string',
    ];

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }
}
