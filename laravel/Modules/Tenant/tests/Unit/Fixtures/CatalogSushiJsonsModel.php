<?php

declare(strict_types=1);

namespace Modules\Tenant\Tests\Unit\Fixtures;

use Modules\Tenant\Models\BaseModelJsons;

/**
 * Modello `catalog` letto da `database/content/catalog/*.json` (classe con nome, non anonima).
 */
final class CatalogSushiJsonsModel extends BaseModelJsons
{
    protected $table = 'catalog';

    /** @var array<string, mixed> */
    protected array $schema = ['name' => null, 'meta' => null];
}
