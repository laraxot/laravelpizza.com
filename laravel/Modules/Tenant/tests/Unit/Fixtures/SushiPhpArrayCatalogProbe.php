<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Illuminate\Database\Eloquent\Model;
use Modules\Tenant\Models\Traits\SushiToPhpArray;

/**
 * Modello SushiToPhpArray senza override di getRows: legge da GetTenantConfigArrayAction.
 *
 * @property string|null $title
 */
final class SushiPhpArrayCatalogProbe extends Model
{
    use SushiToPhpArray;

    protected $table = 'catalog_items';

    /**
     * @return array<int, array<string, mixed>>
     */
    public function getRows(): array
    {
        return $this->getSushiRows();
    }
}
